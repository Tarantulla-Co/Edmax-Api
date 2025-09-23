<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Add product to cart
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'nullable|integer|min:1',
        ]);

        $cart = Cart::create([
            'product_id' => $request->product_id,
            'quantity'   => $request->quantity ?? 1,
        ]);

        return response()->json([
            'message' => 'Product added to cart',
            'cart'    => $cart->load('product'),
        ], 201);
    }

    // Get all cart items
    public function index()
    {
        $cartItems = Cart::with('product')->get();
        return response()->json($cartItems);
    }

    // Remove from cart
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return response()->json(['message' => 'Item removed from cart']);
    }
}
