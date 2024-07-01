<?php

namespace App\Http\Livewire\Dashboard;

use App\Services\TaxService;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class Tax extends Component
{
    public Collection|\Illuminate\Support\Collection $taxes;
    public $selected_tax = null;
    public $field_name = 'tax_id';

    public $status = null;
    
    public function mount()
    {
        $this->taxes = app()->make(TaxService::class)->getTaxesForSelectDropDown();
    }

    public function render()
    {
        return view('livewire.dashboard.tax');
    }
}