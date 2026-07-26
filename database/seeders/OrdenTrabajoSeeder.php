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
    /**
     * Crea entre 1 y 3 órdenes de trabajo por cada vehículo existente,
     * con estados y fechas distribuidas en los últimos 7 meses, para que
     * el Dashboard (gráfico de dona y de línea) se vea con datos reales.
     *
     * IMPORTANTE: requiere haber corrido antes:
     *   php artisan db:seed --class=OrdenesCatalogoSeeder   (sucursal, usuario, mecánicos)
     *   php artisan db:seed --class=VehiculoSeeder          (vehículos)
     */
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
        $pesos   = [20, 25, 25, 25, 5]; // distribución aproximada en porcentaje

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
                $estado = $this->elegirEstadoAleatorio($estados, $pesos);
                $fechaIngreso = $inicio->copy()->addDays(random_int(0, 210));

                $orden = OrdenTrabajo::create([
                    'id_cliente'             => $vehiculo->id_cliente,
                    'id_vehiculo'            => $vehiculo->id_vehiculo,
                    'id_sucursal'            => $sucursal->id_sucursal,
                    'id_usuario_registro'    => $usuario->id_usuario,
                    'fecha_ingreso'          => $fechaIngreso,
                    'fecha_entrega_estimada' => $fechaIngreso->copy()->addDays(random_int(1, 5)),
                    'estado'                 => $estado,
                    'diagnostico'            => $diagnosticos[array_rand($diagnosticos)],
                    'observaciones'          => null,
                    // Total de ejemplo — se calculará automáticamente cuando
                    // se implemente el detalle de servicios/repuestos por orden.
                    'total'                  => random_int(150, 1800),
                ]);

                if ($mecanicos->isNotEmpty()) {
                    $orden->mecanicos()->sync([$mecanicos->random()->id_mecanico]);
                }
            }
        }
    }

    /** Elige un estado al azar respetando los pesos/porcentajes indicados */
    private function elegirEstadoAleatorio(array $estados, array $pesos): string
    {
        $total = array_sum($pesos);
        $r = random_int(1, $total);
        $acumulado = 0;

        foreach ($estados as $i => $estado) {
            $acumulado += $pesos[$i];
            if ($r <= $acumulado) {
                return $estado;
            }
        }

        return $estados[0];
    }
}
