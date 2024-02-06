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
            'password' => Hash::make('70757711')
        ]);

        $user->assignRole('admin');

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

        $FILE = public_path('POSTULANTE_POR_SITUACION.csv');
        if (file_exists($FILE)) {
            $datos = array_map(function ($linea) {
                return str_getcsv($linea, ';');
            }, file($FILE));

            foreach ($datos as $dato) {
                $programacion = Programacion::where('sede', 'LIKE', '%' . $dato[0] . '%')->first();

                if ($programacion) {
                    \App\Models\Postulante::factory()->create([
                        'dni' => $dato[1],
                        'nombres' => $dato[3],
                        'apellidos' => $dato[2],
                        'programacion_id' => $programacion->id,
                    ]);
                }
            }
        }

    }
}
