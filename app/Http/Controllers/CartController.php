<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('cart', compact('cart'));
    }

    public function addToCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        // Check if item already exists in cart
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $request->name,
                "price" => $request->price,
                "image" => $request->image,
                "seller_id" => $request->seller_id, // ensure seller_id is received
                "quantity" => 1,
            ];
        }

        session()->put('cart', $cart);

        $uniqueItemCount = count($cart);

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart!',
            'cart_count' => $uniqueItemCount 
        ]);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed!');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared!');
    }

    public function increase($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    public function decrease($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            } else {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }
}