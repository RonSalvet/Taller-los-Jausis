<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\ModeloVehiculo;
use App\Models\Vehiculo;

class VehiculoSeeder extends Seeder
{
    /**
     * Crea 1 o 2 vehículos por cada cliente existente, usando los modelos
     * cargados por VehiculoCatalogoSeeder (Toyota, Nissan, Hyundai...).
     */
    public function run(): void
    {
        $clientes = Cliente::all();
        $modelos  = ModeloVehiculo::all();

        if ($modelos->isEmpty()) {
            $this->command->warn('No hay modelos de vehículo. Ejecuta primero: php artisan db:seed --class=VehiculoCatalogoSeeder');
            return;
        }

        $colores = ['Blanco', 'Negro', 'Gris', 'Rojo', 'Azul', 'Plata', 'Verde'];
        $letras  = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $placaBase = 1000;

        foreach ($clientes as $cliente) {
            $cantidad = random_int(1, 2);

            for ($j = 0; $j < $cantidad; $j++) {
                $placaBase++;
                $modelo = $modelos->random();

                Vehiculo::create([
                    'id_cliente'  => $cliente->id_cliente,
                    'id_modelo'   => $modelo->id_modelo,
                    'placa'       => $placaBase . '-' . substr(str_shuffle($letras), 0, 3),
                    'anio'        => random_int(2008, 2024),
                    'color'       => $colores[array_rand($colores)],
                    'nro_chasis'  => strtoupper(substr(bin2hex(random_bytes(8)), 0, 17)),
                    'kilometraje' => random_int(5000, 150000),
                ]);
            }
        }
    }
}
