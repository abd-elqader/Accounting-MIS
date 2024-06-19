<?php

namespace App\Http\Livewire\Dashboard;

use App\Services\SupplierService;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class Supplier extends Component
{
    public Collection|\Illuminate\Support\Collection $suppliers;
    public $selected_supplier = null;
    public $field_name = 'supplier_id';

    
    public function mount()
    {
        $this->suppliers = app()->make(SupplierService::class)->getSuppliersForSelectDropDown();
    }

    public function render()
    {
        return view('livewire.dashboard.supplier');
    }
}