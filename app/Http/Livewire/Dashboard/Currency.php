<?php

namespace App\Http\Livewire\Dashboard;

use App\Services\CurrencyService;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class Currency extends Component
{
    public Collection|\Illuminate\Support\Collection $currencies;
    public $selected_currency = null;
    public $field_name = 'currency_id';

    public $status = null;
    
    public function mount()
    {
        $this->currencies = app()->make(CurrencyService::class)->getCurrenciesForSelectDropDown();
    }

    public function render()
    {
        return view('livewire.dashboard.currency');
    }
}