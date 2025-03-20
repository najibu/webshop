<div class="grid grid-cols-2 gap-10 py-12">
    <div class="space-y-4">
        <div class="bg-white p-5 rounded-lg shadow">
            <img src="/{{ $this->product->image->path }}" alt="{{ $this->product->name }}" class="">
        </div>

        <div class="grid grid-cols-4 gap-4">
            @foreach ($this->product->images as $image)
                <div class="bg-white p-2 rounded shadow">
                    <img src="/{{ $image->path }}" alt="{{ $this->product->name }}">
                </div>
            @endforeach
        </div>
    </div>

    <div>
        <h1 class="text-3xl font-medium"> {{ $this->product->name }} </h1>
        <div class="text-xl text-gray-700">{{ $this->product->price }}</div>

        <div class="mt-4">
            {{ $this->product->description }}
        </div>

        <div class="mt-4 space-y-4">
            <select name="variant" id="variant"
                class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-800">
                @foreach ($this->product->variants as $variant)
                    <option value="{{ $variant->id }}">{{ $variant->size }} / {{ $variant->color }}</option>
                @endforeach
            </select>

            <x-button>
                Add to Cart
            </x-button>
        </div>
    </div>


</div>
