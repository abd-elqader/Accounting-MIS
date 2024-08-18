<?php

namespace App\Http\Livewire\Dashboard;

use App\Services\IndustryService;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class Industry extends Component
{
    public Collection|\Illuminate\Support\Collection $industries;
    public $selected_industry = null;
    public $field_name = 'industry_id';

    public $status = null;

    public function mount()
    {
        $this->industries = app()->make(IndustryService::class)->getIndustriesForSelectDropDown();
    }

    public function render()
    {
        return view('livewire.Dashboard.Industry');
    }
}
