<?php

namespace App\Models;

use Money\Money;
use Money\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected function total(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->items->reduce(function (Money $total, CartItem $item) {
                    return $total->add($item->subtotal);
                }, new Money(0, new Currency('USD')));
            }
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CartItem::class);
    }

}
