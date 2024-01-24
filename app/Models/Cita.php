<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable=[
        'fecha_inicio_cita',
        'fecha_fin_cita',
        'estado',
        'placa',
        'nombre_propie',
        'cilindraje',
        'servicio',
        'descripcion',
        'user_id',
        'tipo_vehiculo',

    ];

    protected $table='citas';


    public function tipovehiculo()
    {
        return $this->belongsTo(TipoVehiculo::class, 'tipo_vehiculo');
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
