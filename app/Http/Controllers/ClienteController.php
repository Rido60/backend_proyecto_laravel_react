<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // listar con   ELOQUENT ORM
        $clientes = Cliente::get();

        return response()->json($clientes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Guardar con ELOQUENT ORM

        $request->validate([
            "nombre_completo"=> "required",
            "ci_nit"=> "required"
        ]);
        $cliente = new Cliente();
        $cliente->nonmbre_completo = $request->nonmbre_completo;
        $cliente->ci_nit = $request->ci_nit;
        $cliente->telefono = $request->telefono;
        $cliente->correo = $request->correo;
        $cliente->save();

        return response()->json(["message"=>"cliente Registrado"]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //buscar por id ELOQUENT ORM
        $cliente= Cliente::findorfail($id);

        return response()->json($cliente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            "nombre_completo"=> "required",
            "ci_nit"=> "required"
        ]);
        $cliente = Cliente::findorfail($id);
        $cliente->nonmbre_completo = $request->nonmbre_completo;
        $cliente->ci_nit = $request->ci_nit;
        $cliente->telefono = $request->telefono;
        $cliente->correo = $request->correo;
        $cliente->update();

        return response()->json(["message"=>"cliente Actualizado"]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //eliminar
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return response()->json(["message" => "Cliente Eliminado"]);
    }
}
