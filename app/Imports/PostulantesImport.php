<?php

namespace App\Imports;

use App\Models\Postulante;
use Maatwebsite\Excel\Concerns\ToModel;

class PostulantesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Postulante([
            //
        ]);
    }
}
