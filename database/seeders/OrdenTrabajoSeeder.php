<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehiculo;
use App\Models\Sucursal;
use App\Models\Usuario;
use App\Models\Mecanico;
use App\Models\OrdenTrabajo;

class OrdenTrabajoSeeder extends Seeder
{
    public function run(): void
    {
        $vehiculos = Vehiculo::all();
        $sucursal  = Sucursal::first();
        $usuario   = Usuario::first();
        $mecanicos = Mecanico::all();

        if ($vehiculos->isEmpty() || !$sucursal || !$usuario) {
            $this->command->warn('Faltan datos base. Ejecuta primero OrdenesCatalogoSeeder y VehiculoSeeder.');
            return;
        }

        $estados = ['RECIBIDA', 'EN_PROCESO', 'FINALIZADA', 'ENTREGADA', 'ANULADA'];
        $pesos   = [20, 25, 25, 25, 5];

        // Resultado de diagnóstico: solo aplica a órdenes que ya avanzaron
        $resultados = ['REPARABLE', 'REQUIERE_REPUESTO', 'NO_REPARABLE'];
        $pesosResultado = [55, 30, 15];

        $diagnosticos = [
            'Cambio de aceite y filtro',
            'Revisión de frenos delanteros',
            'Diagnóstico de motor - ruido anómalo',
            'Cambio de batería',
            'Alineación y balanceo',
            'Revisión de sistema eléctrico',
            'Cambio de correa de distribución',
            'Mantenimiento preventivo general',
            'Cambio de amortiguadores',
            'Revisión de aire acondicionado',
        ];

        $inicio = now()->subMonths(7);

        foreach ($vehiculos as $vehiculo) {
            $cantidadOrdenes = random_int(1, 3);

            for ($k = 0; $k < $cantidadOrdenes; $k++) {
                $estado = $this->elegirAleatorio($estados, $pesos);
                $fechaIngreso = $inicio->copy()->addDays(random_int(0, 210));

                // Solo las órdenes que ya pasaron por diagnóstico (no RECIBIDA/ANULADA) tienen resultado
                $resultadoDiagnostico = in_array($estado, ['EN_PROCESO', 'FINALIZADA', 'ENTREGADA'])
                    ? $this->elegirAleatorio($resultados, $pesosResultado)
                    : null;

                $orden = OrdenTrabajo::create([
                    'id_cliente'             => $vehiculo->id_cliente,
                    'id_vehiculo'            => $vehiculo->id_vehiculo,
                    'id_sucursal'            => $sucursal->id_sucursal,
                    'id_usuario_registro'    => $usuario->id_usuario,
                    'fecha_ingreso'          => $fechaIngreso,
                    'fecha_entrega_estimada' => $fechaIngreso->copy()->addDays(random_int(1, 5)),
                    'estado'                 => $estado,
                    'diagnostico'            => $diagnosticos[array_rand($diagnosticos)],
                    'resultado_diagnostico'  => $resultadoDiagnostico,
                    'observaciones'          => null,
                    'total'                  => random_int(150, 1800),
                ]);

                if ($mecanicos->isNotEmpty()) {
                    $orden->mecanicos()->sync([$mecanicos->random()->id_mecanico]);
                }
            }
        }
    }

    private function elegirAleatorio(array $opciones, array $pesos): string
    {
        $total = array_sum($pesos);
        $r = random_int(1, $total);
        $acumulado = 0;

        foreach ($opciones as $i => $opcion) {
            $acumulado += $pesos[$i];
            if ($r <= $acumulado) {
                return $opcion;
            }
        }

        return $opciones[0];
    }
}
