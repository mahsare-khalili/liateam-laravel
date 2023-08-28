<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    
    public function create(Request $request)
    {

        $this->validate($request,
        [
            'name' => 'required',
            'price' => 'required',
            'inventory' => 'required',
        ]);

        $this->authUser();

        $product = Product::create($request->only(['name', 'price', 'inventory']));

        return response()->json(compact('product'));
    }

    public function all()
    {
        $this->authUser();

        return Product::all();
    }

    public function update(Request $request, Product $product)
    {
        $this->authUser();

        $product->update($request->only(['name', 'price', 'inventory']));

        return response()->json(compact('product'));
    }

    public function show(Product $product)
    {
        $this->authUser();

        return response()->json(compact('product'));
    }

    public function delete(Product $product)
    {
        $this->authUser();

        $product->delete();
    }
}
