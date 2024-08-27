<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('user_id', $request->user_id)
                        ->where('menu_item_id', $request->menu_item_id)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $request->user_id,
                'menu_item_id' => $request->menu_item_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json(['message' => 'Item added to cart successfully'], 200);
    }
}
