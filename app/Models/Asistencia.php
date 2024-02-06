<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = ['postulante_id', 'user_id' ,'fecha_asistencia'];

    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }

    // Getter para modificar el valor antes de devolverlo
    public function getFechaAsistenciaAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y H:i:s');
    }
}
