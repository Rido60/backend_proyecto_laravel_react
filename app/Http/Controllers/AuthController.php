<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        # validacion
        $credenciales = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        if (!Auth::attempt($credenciales)){
            return response()->json(["messaje"=> "Usuario no Autenticado"],401);
        }

        // generar el token con sactum
        $user = Auth::user();
        $token = $user->createtoken("token personal")->plainTextToken;

        // responder
        return response()->json([
            "access_token"=> $token,
            "token_type"=> "Bearer",
            "usuario"=>$user

        ]);
    }

    public function register(Request $request)
    {
        # validar
        $request->validate([
            "name" => "required|alpha",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8|max:15"


        ]);
        // si falla no pasa al siguiente(guardar) y da error de 422
        //guardar
        $usuario = new User;  //instancia
        $usuario->name = $request->name ;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);

        $usuario->save();

        //return
        return response()->json(["message"=> "Usuario Registrado con exito"],201);
    }

    public function miPerfil()
    {
        # perfil
        $user = Auth::user();
        return response()->json($user);
    }

    public function salir()
    {
        # salir
        Auth::user()->tokens()->delete();
        return response()->json(["message"=> "Salio correctamente"]);
    }
}


