<?php

namespace App\Http\Livewire\Dashboard;

use App\Services\CountryService;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class Country extends Component
{
    public Collection|\Illuminate\Support\Collection $countries;
    public $selected_country = null;
    public $field_name = 'country_id';

    public $status = null;
    
    public function mount()
    {
        $this->countries = app()->make(CountryService::class)->getCountriesForSelectDropDown();
    }

    public function render()
    {
        return view('livewire.dashboard.country');
    }
}