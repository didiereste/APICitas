<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\Cita;
use App\Models\Horario;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CitaController extends Controller
{
    public function pedircita(Request $request){

        try{
            $request->validate([
                'nombre_propie' => 'required|string|max:100',
                'placa' => 'required',
                'cilindraje' => 'required|numeric',
                'servicio' => 'required|string',
                'tipo_vehiculo' => 'required|numeric',
                'descripcion' => 'required|string|max:100',
                'fecha' => 'required|date',
                'hora' => 'required|date_format:H:i:s',
                'user_id' => 'required|numeric'
            ]);
            
            //Unir fecha con la hora
            $fecha_hora_string= $request->input('fecha') . ' '. $request->input('hora');
            $fecha_hora = Carbon::parse($fecha_hora_string)->setTimezone('America/Bogota');
            $fecha_actual= Carbon::now('America/Bogota');

            if($fecha_hora < $fecha_actual){
                return ApiResponse::error('La fecha no puede ser inferior a la actual', 500);
            }

            //Sacar el nombre del dia
            $nombre_dia = $fecha_hora->format('l');

            //Buscar en base de datos si ese dia se encuentra en el horario
            $horario = Horario::where('dia_semana', $nombre_dia)->first();

            //Validar si el dia si existe
            if(!$horario) {
                return ApiResponse::error('El dia señalado no hay servicio en el taller');
            }

            //Buscar la duracion de las citas del taller
            $buscarDuracion = Horario::where('dia_semana', 'Monday')
                                     ->first();
            $duracionCita= $buscarDuracion->duracion_cita;

            //Sacar las hora minutos y segundos de la fecha y compararlas con las horas del horario estipulado
            $horaCita = $fecha_hora->format('H:i:s');
            $horaInicio = $buscarDuracion->hora_inicio;
            $horaFin = $buscarDuracion->hora_fin;

            //Comparar si las horas de la cita si estan en el rango de las que estan en la base de datos

            if($horaCita >= $horaInicio && $horaCita <=$horaFin){

                //Buscar si la cita existe en la DB
                $citaExistente = Cita::where('fecha_inicio_cita', '<=', $fecha_hora)
                                     ->where('fecha_fin_cita', '>=', $fecha_hora)
                                     ->exists();

                //Validar en caso de que exista o no
                if($citaExistente){
                    return ApiResponse::error('La cita solicitada ya se encuentra ocupada');
                }

                //Sacar la fecha de fin de cita dependiendo de la duracion de la cita

                $fecha_fin_cita = $fecha_hora->copy()->addMinutes($duracionCita);

                $cita= new Cita();

                $cita->nombre_propie= $request->input('nombre_propie');
                $cita->placa = $request->input('placa');
                $cita->cilindraje= $request->input('cilindraje');
                $cita->servicio= $request->input('servicio');
                $cita->descripcion= $request->input('descripcion');
                $cita->user_id= $request->input('user_id');
                $cita->fecha_inicio_cita= $fecha_hora;
                $cita->fecha_fin_cita= $fecha_fin_cita;
                $cita->tipo_vehiculo = $request->input('tipo_vehiculo');

                $cita->save();

                return ApiResponse::success('Cita programada correctamente', 400, $cita);
            }

        }catch(ValidationException $e){
            $errors = $e->validator->errors()->toArray();
            return ApiResponse::error('Error de validacion',500, $errors);
        }
        
    }


    
}
