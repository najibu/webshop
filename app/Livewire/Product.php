<?php

namespace App\Livewire;

use Livewire\Component;

class Product extends Component
{
    public $productId;

    public function mount()
    {

    }

    public function getProductProperty()
    {
        return \App\Models\Product::findOrfail($this->productId);
    }


    public function render()
    {
        return view('livewire.product');
    }
}
