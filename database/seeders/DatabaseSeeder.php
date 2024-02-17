<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Programacion;
use App\Models\Postulante;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Sleep;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();


        $role = Role::create(['name' => 'admin']);

        //Usuario par alogin
        $user = \App\Models\User::factory()->create([
            'name' => 'LUIS MIGUEL FEIJOO VALERIANO',
            'username' => '70757711',
            'password' => Hash::make('12345')
        ]);

        $user->assignRole('admin');

        \App\Models\User::factory()->create(['username' => 'user1']);
        \App\Models\User::factory()->create(['username' => 'user2']);
        \App\Models\User::factory()->create(['username' => 'user3']);
        \App\Models\User::factory()->create(['username' => 'user4']);
        \App\Models\User::factory()->create(['username' => 'user5']);
        \App\Models\User::factory()->create(['username' => 'user6']);
        \App\Models\User::factory()->create(['username' => 'user7']);
        \App\Models\User::factory()->create(['username' => 'user8']);
        \App\Models\User::factory()->create(['username' => 'user9']);
        \App\Models\User::factory()->create(['username' => 'user10']);
        \App\Models\User::factory()->create(['username' => 'user11']);
        \App\Models\User::factory()->create(['username' => 'user12']);
        \App\Models\User::factory()->create(['username' => 'user13']);
        \App\Models\User::factory()->create(['username' => 'user14']);
        \App\Models\User::factory()->create(['username' => 'user15']);
        \App\Models\User::factory()->create(['username' => 'user16']);

        //Primera fecha de programacion
        /* ;*/


        $sedes = [
            'BELEN DE OSMA Y PARDO 0236323',
            'COAR APURIMAC',
            'COAR AYACUCHO',
            'COAR CUSCO',
            'COAR ICA',
            'COAR MADRE DE DIOS',
            'COAR MOQUEGUA',
            'CORONEL LADISLAO ESPINAR 0236646',
            'DANIEL BECERRA OCAMPO 0309815',
            'G.U.E SAN CARLOS',
            'I.E. NUESTRA SEÑORA DE LAS MERCEDES',
            'IE ALMIRANTE MIGUEL GRAU',
            'IE FRANCISCO GARCIA CALDERÓN',
            'IE LIBERTADOR CASTILLA',
            'IE NUESTRA SEORA PERPETUO SOCORRO DE PUQUIO',
            'IEP N 72723 SEOR DE HUANCA',
            'JAPAM 0617647',
            'JOSE ANTONIO ENCINAS 0239665',
            'MANCO II 0233098',
            'SEDE CUSCO II  IE AVA',
            'SIMON RODRIGUEZ 0275503',
            'UNIVERSIDAD CATÓLICA SAN PABLO'
        ];

        foreach ($sedes as $sede) {
            Programacion::firstOrCreate([
                'turno' => 'MAÑANA',
                'fecha' => now(),
                'estado' => 'UNIVERSIDAD CATÓLICA SAN PABLO' === $sede ? 1: 0,
                'sede' => $sede
            ]);
        }

        $FILE = public_path('LISTA_OFICIAL.csv');
        if (file_exists($FILE)) {
            $datos = array_map(function ($linea) {
                return str_getcsv($linea, ';');
            }, file($FILE));

            foreach ($datos as $dato) {
                $programacion = Programacion::where('sede', 'LIKE', '%' . $dato[3] . '%')->first();

                if ($programacion) {
                    \App\Models\Postulante::factory()->create([
                        'ubigeo_detalle' => $dato[0].' / '.$dato[1].' / '.$dato[2],
                        'dni' => $dato[5],
                        'nombres' => $dato[8],
                        'apellidos' => $dato[6].' '.$dato[7],
                        'aula' => $dato[11],
                        'piso' => $dato[10],
                        'pabellon' => $dato[9],
                        'programacion_id' => $programacion->id,
                    ]);
                }
            }
        }

    }
}
