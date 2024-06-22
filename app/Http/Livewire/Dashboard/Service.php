<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

use App\Services\ProductService;
use App\Services\ServiceService;
use Illuminate\Database\Eloquent\Collection;

class Service extends Component
{
    public Collection|\Illuminate\Support\Collection $services;
    public $selected_service = null;
    public $field_name = 'service_id';

    
    public function mount()
    {
        $this->services = app()->make(ServiceService::class)->getServicesForSelectDropDown();
    }

    public function render()
    {
        return view('livewire.dashboard.service');
    }
}