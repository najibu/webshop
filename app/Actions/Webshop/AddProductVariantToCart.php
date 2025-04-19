<?php

namespace App\Actions\Webshop;

use App\Factories\CartFactory;
use App\Models\Cart;

class AddProductVariantToCart
{
    public function add(int $variantId)
    {
        CartFactory::make()->items()->firstOrCreate([
            'product_variant_id' => $variantId,
        ], [
            'quantity' => 0,
        ])->increment('quantity');
    }
}
