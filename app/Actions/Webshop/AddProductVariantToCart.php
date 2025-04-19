<?php

namespace App\Actions\Webshop;

use App\Models\Cart;

class AddProductVariantToCart
{
    public function add(int $variantId)
    {
        $cart = match (auth()->guest()) {
            true => Cart::firstOrCreate(['session_id' => session()->getId()]),
            false => auth()->user()->cart ?: auth()->user()->cart()->create(),
        };


        $cart->items()->create([
            'variant_id' => $variantId,
            'quantity' => 1,
        ]);
    }
}
