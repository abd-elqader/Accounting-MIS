<?php

namespace App\Http\Livewire\Dashboard;

use App\Services\CompanyService;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class Company extends Component
{
    public Collection|\Illuminate\Support\Collection $companies;
    public $selected_company = null;
    public $field_name = 'company_id';
    
    public function mount()
    {
        $this->companies = app()->make(CompanyService::class)->getCompaniesForSelectDropDown();
    }

    public function render()
    {
        return view('livewire.dashboard.company');
    }
}