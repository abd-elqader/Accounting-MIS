<?php

namespace App\Http\Livewire\Dashboard;

use App\Services\CategoryService;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class Category extends Component
{
    public Collection|\Illuminate\Support\Collection $categories;
    public $selected_category = null;
    public $field_name = 'category_id';

    public $status = null;
    
    public function mount()
    {
        $this->categories = app()->make(CategoryService::class)->getCategoriesForSelectDropDown();
    }

    public function render()
    {
        return view('livewire.dashboard.category');
    }
}