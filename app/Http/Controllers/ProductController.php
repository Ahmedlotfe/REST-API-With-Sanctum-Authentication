<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all());
    }


    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255|unique:products,slug',
            'price' => 'required',
        ]);
        return Product::create($request);
    }

    public function show($id)
    {
        $product = Product::find($id);
        return $product ?? response()->json(['status' => "Product Not found"], Response::HTTP_NOT_FOUND);;
    }


    public function update($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['status' => "Product Not found"], Response::HTTP_NOT_FOUND);;
        }

        $product->update(request()->all());
        return $product;
    }


    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['status' => "Product Not found"], Response::HTTP_NOT_FOUND);;
        }

        $product->delete();
        return "Deleted";
    }


    public function search($slug)
    {
        $product = Product::where('name', 'like', '%' . $slug . '%')->get();
        return $product ?? response()->json(['status' => "Product Not found"], Response::HTTP_NOT_FOUND);;
    }
}
