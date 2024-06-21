<?php

namespace App\Http\Livewire\Dashboard;

use App\Services\DepartmentService;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class Department extends Component
{
    public Collection|\Illuminate\Support\Collection $departments;
    public $selected_department = null;
    public $field_name = 'department_id';

    public $status = null;
    
    public function mount()
    {
        $this->departments = app()->make(DepartmentService::class)->getDepartmentsForSelectDropDown();
    }

    public function render()
    {
        return view('livewire.dashboard.department');
    }
}