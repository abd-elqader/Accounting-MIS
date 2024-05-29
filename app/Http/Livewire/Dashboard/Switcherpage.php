<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Switcherpage extends Component
{
    public function render()
    {
        return view('livewire.dashboard.switcherpage')
        ->layout('layouts.dashboard.switcher');
    }
}
