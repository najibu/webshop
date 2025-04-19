<?php

namespace App\Actions\Webshop;

use App\Models\Cart;

class AddProductVariantToCart
{
    public function add(int $variantId)
    {
        if (auth()->guest()) {
            $cart = Cart::firstOrCreate([
                'session_id' => session()->getId(),
            ]);
        }

        if (auth()->user()) {
            $cart = auth()->user()->cart ?: auth()->user()->cart()->create();
        }

        dd($cart);
    }
}
