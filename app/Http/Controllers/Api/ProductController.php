<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; 

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $product = Product::create([
            'name'=> $request->name,
            'price'=> $request->price,
            'stock'=> $request->stock,
            'category'=> $request->category,
        ]);

        return response()->json([
            'message' => 'Product added successfully',
            'data' => $product
        ], 201);
    }

    public function index(){
        $product=Product::all();
        return response()->json([
            'message' =>"product fetched successfully",
            'data' => $product
            
        ]);
    }


    public function show($id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }

    return response()->json([
        'data' => $product
    ]);
}
   public function update(Request $request, $id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }

    $product->update([
        'name' => $request->name,
        'price' => $request->price,
        'stock' => $request->stock,
        'category' => $request->category,
    ]);

    return response()->json([
        'message' => 'Product updated successfully',
        'data' => $product
    ]);
}

public function destroy (Request $request,$id){
$product=Product::find($id);
 

if (!$product) {
        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }
     $product->delete();

    return response()->json([
        'message' => 'Product deleted successfully'
    ]);

}
}