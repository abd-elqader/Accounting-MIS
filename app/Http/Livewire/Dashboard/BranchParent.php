<?php

namespace App\Http\Livewire\Dashboard;

use App\Services\BranchService;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class BranchParent extends Component
{
    public Collection|\Illuminate\Support\Collection $branches;
    public $selected_branch = null;
    public $field_name = 'parent_id';

    public $status = null;
    
    public function mount()
    {
        $this->branches = app()->make(BranchService::class)->getBranchesForSelectDropDown();
    }

    public function render()
    {
        return view('livewire.dashboard.branch');
    }
}