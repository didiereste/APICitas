<?php

namespace Database\Seeders;

use App\Models\TipoVehiculo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoVehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehiculo1= new TipoVehiculo();
        $vehiculo1->nombre='Taxi';
        $vehiculo1->save();

        $vehiculo1= new TipoVehiculo();
        $vehiculo1->nombre='Particular';
        $vehiculo1->save();
    }
}
