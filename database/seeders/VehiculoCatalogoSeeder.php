<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MarcaVehiculo;
use App\Models\ModeloVehiculo;

class VehiculoCatalogoSeeder extends Seeder
{
    /**
     * Carga marcas y modelos comunes para que el selector
     * del formulario de Vehículos no esté vacío.
     */
    public function run(): void
    {
        $catalogo = [
            'Toyota'   => ['Hilux', 'Corolla', 'RAV4', 'Yaris'],
            'Nissan'   => ['Versa', 'X-Trail', 'Frontier'],
            'Hyundai'  => ['Tucson', 'Accent', 'Santa Fe'],
            'Suzuki'   => ['Swift', 'Vitara', 'Alto'],
            'Chevrolet'=> ['Spark', 'Sail', 'Onix'],
        ];

        foreach ($catalogo as $marca => $modelos) {
            $marcaCreada = MarcaVehiculo::create([
                'nombre' => $marca,
                'pais_origen' => null,
            ]);

            foreach ($modelos as $modelo) {
                ModeloVehiculo::create([
                    'id_marca'    => $marcaCreada->id_marca,
                    'nombre'      => $modelo,
                    'tipo_motor'  => null,
                    'cilindrada'  => null,
                ]);
            }
        }
    }
}
