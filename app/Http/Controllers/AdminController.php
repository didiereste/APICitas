<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\Cita;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;


class AdminController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('can:administrar');
    }
    

    public function cambiarestado(Request $request, string $id)
    {
        try{
            $cita = Cita::findOrfail($id);

            $request->validate([
                'estado' => 'required|string'
            ]);

            $cita->estado=$request->input('estado');

            $cita->update();

            return ApiResponse::success('Estado de cita cambiado correctamente',200,$cita);

        }catch(ModelNotFoundException $e){
            return ApiResponse::error('La cita no existe');
        }catch(ValidationException $e){
            return ApiResponse::error('Error de validacion',400,$e->getMessage());
        }
    }


    public function listadocitas()
    {
        try{
            $citas=Cita::all();
            return ApiResponse::success('Listado cargado correctamente', 200, $citas);
        }catch(Exception $e){
            return ApiResponse::error('Error inesperado', 400, $e);
        }
       
    }

    public function userlistado()
    {
        try{
            $users=User::all();
            return ApiResponse::success('Listado cargado correctamente', 200, $users);
        }catch(Exception $e){
            return ApiResponse::error('Error inesperado', 400, $e);
        }
    }


    public function deleteuser(string $id)
    {
        try{
            $user=User::findOrfail($id);

            $user->delete();

            return ApiResponse::success('Usuario eliminado correctamente',400, $user);

        }catch(ModelNotFoundException $e){
            return ApiResponse::error('El usuario no existe');
        }
    }

    public function updateuser(Request $request, string $id)
    {
        try{
            $user=User::findOrfail($id);

            $request->validate([
                'name' => 'string|max:100',
                'email' => 'email|max:100',Rule::unique('users', 'email')->ignore($id),
                'rol_id' => 'required|numeric'
            ]);
            
            $user->name=$request->input('name');
            $user->email=$request->input('email');
            $user->update();


            $rolNuevo= $request->input('rol_id');
            $user->syncRoles([$rolNuevo]);
            
            return ApiResponse::success('Usuario actualizado correctamente',200, $user);
            
        }catch(ModelNotFoundException $e){
            return ApiResponse::error('Usuario no existente', 400);
        }catch(ValidationException $e){
            $errors = $e->validator->errors()->toArray();
            return ApiResponse::error('Error de validacion',400, $errors);
        }

    }

    public function mostraruser(string $id)
    {  
        try{
            $user=User::findOrfail($id);
            return ApiResponse::success('Usuario cargado correctamente', 200, $user);

        }catch(ModelNotFoundException $e){
            return ApiResponse::error('Usuario no encontrado', 400);
        }
    }
}
