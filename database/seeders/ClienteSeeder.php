<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    /**
     * Carga 25 clientes de ejemplo, con fechas de registro distribuidas
     * en los últimos meses (útil para que el Dashboard se vea con datos reales).
     */
    public function run(): void
    {
        $clientes = [
            ['Juan Pérez Rojas',        '4587963',  '70012345', 'juan.perez@gmail.com',       'Av. Banzer #450, Santa Cruz'],
            ['María Flores Vaca',       '6234871',  '76598741', 'maria.flores@gmail.com',     'Calle Junín #120, Santa Cruz'],
            ['Carlos Mamani Quispe',    '5896321',  '71234568', 'carlos.mamani@hotmail.com',  'Av. Cristo Redentor #890'],
            ['Ana Gutiérrez Salazar',   '7412589',  '68974521', 'ana.gutierrez@gmail.com',    'Barrio Equipetrol, Calle 5'],
            ['Pedro Salvatierra Vera',  '3698521',  '75319864', 'pedro.salvatierra@gmail.com','Av. Alemana #234'],
            ['Lucía Áñez Rodríguez',    '2589631',  '69875412', 'lucia.anez@gmail.com',       'Villa 1ro de Mayo, Calle 12'],
            ['Roberto Choque Ticona',   '8963214',  '77412589', 'roberto.choque@gmail.com',   'Av. Grigotá #1560'],
            ['Daniela Suárez Peña',     '4123698',  '73698521', 'daniela.suarez@hotmail.com', 'Barrio Sirari, Calle 8'],
            ['Miguel Rojas Ibáñez',     '9632587',  '78521463', 'miguel.rojas@gmail.com',     'Av. Beni km 5'],
            ['Fernanda Justiniano',     '1478523',  '76321459', 'fernanda.j@gmail.com',       'Urbanización Las Palmas'],
            ['Jorge Vaca Guzmán',       '6598741',  '70147852', 'jorge.vaca@gmail.com',       'Av. Piraí #340'],
            ['Patricia Melgar Soliz',   '3216549',  '72589631', 'patricia.melgar@gmail.com',  'Calle Ayacucho #560'],
            ['Diego Antelo Rivero',     '5478963',  '71596328', 'diego.antelo@hotmail.com',   'Barrio Las Américas'],
            ['Camila Ortiz Barrientos', '8521473',  '79632587', 'camila.ortiz@gmail.com',     'Av. Roca y Coronado #78'],
            ['Sergio Áviles Montaño',   '7896541',  '74123698', 'sergio.aviles@gmail.com',    'Zona Norte, Calle 21'],
            ['Valeria Rivero Cronemb.', '2345678',  '76854123', 'valeria.rivero@gmail.com',   'Av. Cañoto #450'],
            ['Andrés Paz Estenssoro',   '9871234',  '78965412', 'andres.paz@gmail.com',       'Barrio Urubó Villa 3'],
            ['Gabriela Cuéllar Justin.','4567891',  '70258963', 'gabriela.cuellar@hotmail.com','Av. Radial 27 #1200'],
            ['Ricardo Terrazas Ávila',  '6789123',  '77896541', 'ricardo.terrazas@gmail.com', 'Calle Warnes #230'],
            ['Sofía Bejarano López',    '3459871',  '75478963', 'sofia.bejarano@gmail.com',   'Barrio Hamacas, Calle 4'],
            ['Marcelo Landívar Soria',  '8129456',  '76589214', 'marcelo.landivar@gmail.com', 'Av. Mutualista #670'],
            ['Claudia Rocha Méndez',    '5673214',  '78123456', 'claudia.rocha@gmail.com',    'Villa Copacabana, Calle 9'],
            ['Iván Salguero Prado',     '9214567',  '71472583', 'ivan.salguero@hotmail.com',  'Av. Santos Dumont #340'],
            ['Natalia Vargas Céspedes', '6541239',  '73951628', 'natalia.vargas@gmail.com',   'Barrio Las Brisas, Calle 6'],
            ['Óscar Molina Fernández',  '4789632',  '79517532', 'oscar.molina@gmail.com',     'Av. Doble Vía La Guardia'],
        ];

        // Fechas de registro repartidas en los últimos 8 meses (para poblar el Dashboard)
        $inicio = now()->subMonths(8);

        foreach ($clientes as $i => $c) {
            [$nombre, $ci, $telefono, $email, $direccion] = $c;

            Cliente::create([
                'nombre'         => $nombre,
                'ci_nit'         => $ci,
                'telefono'       => $telefono,
                'email'          => $email,
                'direccion'      => $direccion,
                'fecha_registro' => $inicio->copy()->addDays($i * 9), // distribuye las fechas
                'estado'         => $i % 9 === 0 ? false : true,      // un par de clientes inactivos
            ]);
        }
    }
}
