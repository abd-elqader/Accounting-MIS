<?php

namespace App\Http\Livewire\Dashboard;

use App\Services\CustomerService;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class Customer extends Component
{
    public Collection|\Illuminate\Support\Collection $customers;
    public $selected_customer = null;
    public $field_name = 'customer_id';

    
    public function mount()
    {
        $this->customers = app()->make(CustomerService::class)->getCustomersForSelectDropDown();
    }

    public function render()
    {
        return view('livewire.dashboard.customer');
    }
}