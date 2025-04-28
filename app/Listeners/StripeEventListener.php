<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Cashier\Events\WebhookReceived;
use App\Actions\Webshop\HandleCheckoutSesssionCompleted;

class StripeEventListener
{
    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'checkout.session.completed') {
            (new HandleCheckoutSesssionCompleted())->handle($event->payload['data']['object']['id']);
        }
    }
}
