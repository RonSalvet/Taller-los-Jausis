<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\Sucursal;
use App\Models\Usuario;
use App\Models\Mecanico;

class OrdenesCatalogoSeeder extends Seeder
{
    /**
     * Datos base necesarios para poder crear una Orden de Trabajo:
     * roles, una sucursal, un usuario que registra órdenes, y mecánicos.
     */
    public function run(): void
    {
        $rolAdmin = Rol::create(['nombre' => 'Administrador', 'descripcion' => 'Acceso total al sistema']);
        Rol::create(['nombre' => 'Recepcionista', 'descripcion' => 'Registra clientes y órdenes']);
        Rol::create(['nombre' => 'Mecanico', 'descripcion' => 'Ejecuta las órdenes de trabajo']);

        $sucursal = Sucursal::create([
            'nombre'    => 'Sucursal Central',
            'direccion' => 'Av. Principal #123, Santa Cruz de la Sierra',
            'telefono'  => '33123456',
            'zona'      => 'Centro',
        ]);

        Usuario::create([
            'id_rol'          => $rolAdmin->id_rol,
            'id_sucursal'     => $sucursal->id_sucursal,
            'nombre_completo' => 'Administrador General',
            'email'           => 'admin@tallerpro.com',
            'password_hash'   => bcrypt('password'), // temporal, hasta implementar login real
            'telefono'        => '70000000',
            'estado'          => true,
        ]);

        $mecanicos = ['Luis Vargas', 'Roberto Choque', 'Daniel Suárez', 'Miguel Rojas'];
        foreach ($mecanicos as $nombre) {
            Mecanico::create([
                'id_sucursal'         => $sucursal->id_sucursal,
                'nombre'              => $nombre,
                'ci'                  => strval(random_int(3000000, 9999999)),
                'telefono'            => '7' . random_int(1000000, 9999999),
                'fecha_contratacion'  => now()->subMonths(random_int(1, 24)),
                'disponibilidad'      => true,
            ]);
        }
    }
}
