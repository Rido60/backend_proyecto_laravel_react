<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //listar con sql
        //$categorias = DB::select ("select * from categorias");
        //listar con query Builder
        $categorias = DB::table("categorias")->get();

        //retornar
        return response()->json($categorias, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // muestra un formulario de creacion para categoria solo sirve para trabajar el laravel
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //guardar los datos en la base de datos
        // sql
        //DB::insert("insert into categorias(nombre,detalle) values (?,?)", [$request->nombre, $request->detalle]);

        //query builder
        DB::table("categorias")->insert(['nombre'=>$request->nombre, 'detalle'=>$request->detalle]);
        return response()->json(["message"=> "categoria guardada"]);
    }

    /**;
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //buscar por id y muestra un recurso
        //listar con sql
        //$categoria = DB::select ("select * from categorias where id = ?",  [$id]);

         //listar con query Builder
       // $categoria = DB::table("categorias")->find($id);

        //ELOQUENT ORM
        $categoria = Categoria::with('productos')->find($id);
        //$categoria = productos;
        return response()->json($categoria, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //mostrar un formulario de edicion para un recurso por id

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //modificar un recurso por ID en la BD ELOQUENT ORM
        //listar con ELOQUENT ORM
        $categoria = Categoria::find($id);
        $categoria ->nombre = $request->nombre;
        $categoria ->detalle = $request->detalle;
        $categoria->update();
        return  response()->json(["message"=> "categoria modificada"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //buscar por id y eliminar de la Base de Datos
        //listar con ELOQUENT ORM
        $categoria = Categoria::find($id);
        $categoria->delete();
        return  response()->json(["message"=> "categoria eliminada"]);

    }
}
