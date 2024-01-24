<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\Cita;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Spatie\FlareClient\Api;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:citar');
    }
    
    public function miscitas(string $id)
    {
        try{
            
            $user= User::findOrfail($id);
            $citas=Cita::where('user_id',$user->id)->get();

            return ApiResponse::success('Listado de citas encontrado correctamente', 200, $citas);
        }catch(ModelNotFoundException $e){
            return ApiResponse::error('Usuario no existente',404);
        }
    }
}
