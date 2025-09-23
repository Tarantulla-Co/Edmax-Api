<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'image'       => $imagePath,
        ]);

        return response()->json([$product, 'message' => 'Product Created Successfully'],201);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

   public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'name'        => 'sometimes|required|string',
        'price'       => 'sometimes|required|numeric',
        'description' => 'nullable|string',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Update basic fields
    $product->fill([
        'name'        => $validated['name']        ?? $product->name,
        'price'       => $validated['price']       ?? $product->price,
        'description' => $validated['description'] ?? $product->description,
    ]);

    
    // If a new image is uploaded, store and replace
    if ($request->hasFile('image')) {
        // optionally delete old file
        if ($product->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }

        $path = $request->file('image')->store('products', 'public');
        $product->image = $path;
       
    }

    $product->save();

     return response()->json([
        $product,
            'mesage ' => 'Product Updated Successfully',
            'code' => 201,
        ],201);

}

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product deleted']);
    }
}
