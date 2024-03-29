<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //listar
        $limit = $request->limit?$request->limit:5;
        if(isset($request->q)){
             $productos = Producto::where('nombre','like','%'.$request->q.'%')
                            ->with('categoria')
                            ->orderBy('id','desc')
                            ->paginate($limit);
        }else{
        $productos = Producto::orderBy('id','desc')
                            ->with('categoria')
                            ->paginate($limit);
        }
        //$producto = Producto::get();

        return response()->json($productos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validar
        $request->validate([
            "nombre"=> "required",
            "precio"=> "required",
            "categoria_id" => "required"
        ]);

        //guardar datos
        $prod = new Producto();
        $prod->nombre = $request->nombre;
        $prod->precio = $request->precio;
        $prod->cantidad = $request->cantidad;
        $prod->stock = $request->stock;
        $prod->descripcion = $request->descripcion;
        $prod->categoria_id = $request->categoria_id;
        $prod->save();


        return response()->json(["message" => "Producto Registrado"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $prod = Producto::findorfail($id);

        return response()->json($prod);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            "nombre"=> "required",
            "precio"=> "required",
            "cantidad"=> "required",
            "stock" => "required",
            "descripcion"=> "required",
            "categoria_id" => "required"
        ]);
        $prod = Producto::findorfail($id);
        $prod->nombre = $request->nombre;
        $prod->precio = $request->precio;
        $prod->cantidad = $request->cantidad;
        $prod->stock = $request->stock;
        $prod->descripcion = $request->descripcion;
        $prod->categoria_id = $request->categoria_id;
        $prod->update();

        return response()->json(["message" => "Usuario Actualizado"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //eliminacion
        $prod = Producto::findOrFail($id);
        $prod->estado = 0;
        $prod->update();

        return response()->json(["message" => "Producto Eliminado"]);
    }
}
