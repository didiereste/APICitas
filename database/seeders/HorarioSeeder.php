<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diasSemana = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        foreach ($diasSemana as $dia) {
            DB::table('horarios')->insert([
                'dia_semana' => $dia,
                'hora_inicio' => '08:00:00',
                'hora_fin' => '16:00:00',
                'duracion_cita' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
