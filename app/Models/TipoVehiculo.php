<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoVehiculo extends Model
{
    use HasFactory;

    protected $fillable=[
        'nombre',
    ];

    protected $table= 'tipo_vehiculos';
    
    
    public function citas()
    {
        return $this->hasMany(Cita::class, 'tipo_vehiculo');
    }
}
