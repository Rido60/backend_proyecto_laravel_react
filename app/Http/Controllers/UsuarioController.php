<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //listar
        //listar con ELOQUENT ORM

        $users = User::get();
        //$users = User::get();

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Guardar los datos en la base de datos
        $request->validate([
            "name"=> "required",
            "email"=> "required|email|unique:users,email",
            "password" => "required"
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();


        return response()->json(["message" => "Usuario Registrado"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //buscar por id y muestra un recurso
        $user = User::findorfail($id);
        //$users = User::get();

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //modificar un recurso por ID en la BD
        $request->validate([
            "name"=> "required",
            "email"=> "required|email|unique:users,email",
            "password" => "required"
        ]);
        $user = User::findorfail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->update();

        return response()->json(["message" => "Usuario Actualizado"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //buscar por id y eliminar de la Base de Datos
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(["message" => "Usuario Eliminado"]);
    }
}
