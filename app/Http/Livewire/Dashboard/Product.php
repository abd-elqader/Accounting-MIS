<?php

namespace App\Http\Livewire\Dashboard;

use App\Services\ProductService;

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class Product extends Component
{
    public Collection|\Illuminate\Support\Collection $products;
    public $selected_product = null;
    public $field_name = 'product_id';

    
    public function mount()
    {
        $this->products = app()->make(ProductService::class)->getProductsForSelectDropDown();
    }

    public function render()
    {
        return view('livewire.dashboard.product');
    }
}