<?php

namespace App\Actions\Webshop;

use App\Models\Cart;
use App\Models\User;
use Stripe\LineItem;
use App\Models\OrderItem;
use Laravel\Cashier\Cashier;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HandleCheckoutSesssionCompleted
{
    public function handle($sessionId)
    {
        DB::transaction(function () use ($sessionId) {
            $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);
            $user = User::find($session->metadata->user_id);
            $cart = Cart::find($session->metadata->cart_id);

            $order = $user->orders()->create([
                'stripe_checkout_session_id' => $session->id,
                'amount_shipping' => $session->total_details->amount_shipping,
                'amount_discount' => $session->total_details->amount_discount,
                'amount_tax' => $session->total_details->amount_tax,
                'amount_subtotal' => $session->amount_subtotal,
                'amount_total' => $session->amount_total,
                'billing_address' => json_encode([
                    'name' => $session->customer_details->name,
                    'line1' => $session->customer_details->address->line1,
                    'line2' => $session->customer_details->address->line2,
                    'city' => $session->customer_details->address->city,
                    'state' => $session->customer_details->address->state,
                    'postal_code' => $session->customer_details->address->postal_code,
                    'country' => $session->customer_details->address->country,
                ]),
                'shipping_address' => json_encode([
                    'name' => $session->shipping_details->name,
                    'line1' => $session->shipping_details->address->line1,
                    'line2' => $session->shipping_details->address->line2,
                    'city' => $session->shipping_details->address->city,
                    'state' => $session->shipping_details->address->state,
                    'postal_code' => $session->shipping_details->address->postal_code,
                    'country' => $session->shipping_details->address->country,
                ])
            ]);

            $lineItems = Cashier::stripe()->checkout->sessions->allLineItems($session->id);

            $orderItems = collect($lineItems->all())->map(function (LineItem $line) {
                $product = Cashier::stripe()->products->retrieve($line->price->product);

                return new OrderItem ([
                    'product_variant_id' => $product->metadata->product_variant_id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $line->price->unit_amount,
                    'quantity' => $line->quantity,
                    'amount_discount' => $line->amount_discount,
                    'amount_subtotal' => $line->amount_subtotal,
                    'amount_tax' => $line->amount_tax,
                    'amount_total' => $line->amount_total,
                ]);
            });

            $order->items()->saveMany($orderItems);

            $cart->items()->delete();
            $cart->delete();

            Mail::to($user)->send(new OrderConfirmation($order));
        });
    }
}
