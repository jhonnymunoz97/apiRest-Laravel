<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response([
            'stauts' => 'success',
            'message' => 'Lisatdo de Productos',
            'data' => $products,
            'code' => 200,
        ]);
    }

    public function saveImage($img){
        $image = $img;
        $image = (str_contains($image,'data:image/jpeg')) ? $image = str_replace( 'data:image/jpeg;base64,', '', $image) : $image = str_replace( 'data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = time() . '.' . 'png';
        File::put(public_path() . "//img//" . $imageName, base64_decode($image));
        $dir = asset("img/". $imageName);
        return $dir;
    }

    public function store(Request $request)
    {
        $product = new Product();
        $product->nombre = $request->nombre;
        $product->descripcion = $request->descripcion;   
        $product->imagen = $this->saveImage($request->imagen);
        $product->save();

        return response([
            'stauts' => 'success',
            'message' => 'Producto registrado con éxito',
            'code' => 200,
        ]);
    }

    public function show($product)
    {
        $product = Product::findOrFail($product);
        return response([
            'message' => 'Producto encontrado',
            'data' => $product,
            'status' => 'success',
            'code' => 200
        ]);
    }

    public function update(Request $request, $idP)
    {
        $product = Product::findOrFail($idP);
        $request['imagen'] = (str_contains($request->imagen,"http")) 
                ? $request->imagen : $this->saveImage($request->imagen);                                       
        $product->update($request->all());
        return response([
            'message' => 'El Producto se actualizó correctamente',
            'data' => $product,
            'status' => 'success',
            'code' => 200
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response([
            'message' => 'El Producto se eliminó con éxito',
            'status' => 'success',
            'code' => 200,
        ]);
    }
}
