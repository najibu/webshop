<div class="grid grid-cols-4 mt-12 gap-4">
    <div class="bg-white rounded-lg shadow p-5 col-span-3">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left">Product</th>
                    <th class="text-left">Price</th>
                    <th class="text-left">Color</th>
                    <th class="text-left">Size</th>
                    <th class="text-left">Quantity</th>
                    <th class="text-right">Total</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td> {{ $item->product->price }} </td>
                    <td>{{ $item->variant->color }}</td>
                    <td>{{ $item->variant->size }}</td>
                    <td class="flex items-center">
                        <button wire:click="decrement({{ $item->id }})" @disabled($item->quantity == 1)>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                <path d="M3.75 7.25a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5h-8.5Z" />
                            </svg>
                        </button>
                        <div>
                            {{ $item->quantity }}
                        </div>
                        <button wire:click="increment({{ $item->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                <path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
                            </svg>
                        </button>
                    </td>
                    <td class="text-right">
                        {{  $item->subtotal }}
                    </td>
                    <td class="pl-2">
                        <button wire:click="delete({{ $item->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right font-medium">Total</td>
                    <td class="font-medium text-right">{{ $this->cart->total }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div>
        <div class="bg-white rounded-lg shadow p-5 col-span-1">
            @guest
                <p>Please <a href="{{ route('register') }}" class="underline">register</a> or <a href="{{ route('login') }}" class="underline">login</a> to continue.</p>
            @endguest
            @auth
                <x-button wire:click="checkout">
                   Checkout
                </x-button>
            @endauth
        </div>
    </div>
</div>
