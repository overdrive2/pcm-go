<?php

namespace App\Http\Livewire\Plan;

use Livewire\Component;

class Home extends Component
{
    public $component = 'plan.request';
    
    public function render()
    {
        return view('livewire.plan.home');
    }
}
