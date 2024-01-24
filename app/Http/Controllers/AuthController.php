<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    

    public function login()
    {
        try {
            // Validar las credenciales antes de intentar la autenticación
            request()->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            // Extraer las credenciales del cuerpo de la solicitud.
            $credentials = request(['email', 'password']);
    
            // Intentar autenticar al usuario y obtener un token.
            if (!$token = auth()->attempt($credentials)) {
                return ApiResponse::error('Credenciales incorrectas', 401);
            }
    
            // Responder con un mensaje de éxito y el token.
            return ApiResponse::success('Inicio de sesión exitoso', 200, $token);
        } catch ( ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return ApiResponse::error('Error de validacion ', 500, $errors);
        }
    }


    public function register(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:100|unique:users,email',
                'password' => 'required|min:6',
            ]);
            $passwordEncryptada= Hash::make($request->input('password'));
            $user= User::create(array_merge($request->all(),['password' => $passwordEncryptada]));

            $role = Role::find(2);
            $user->assignRole($role);

            return ApiResponse::success('El usuario se registró correctamente', 200, $user);

        }catch(ValidationException $e) {
            
            return ApiResponse::error('Error en la validacion',400, $e->getMessage());
        }
    }

    public function me()
    {
        $user= auth()->user();
        // Retorna el usuario autenticado en formato JSON.
        return ApiResponse::success('Informacion usuario logeado',200,$user);
    }

    public function logout()
    {
        auth()->logout();

        return ApiResponse::success('Cerrado de sesion exitoso', 200);
    }
}
