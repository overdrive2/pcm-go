<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ItemTypeNavbar extends Component
{
    public $id;

    public function getRowsProperty()
    {
        
    }

    public function render()
    {
        return view('livewire.item-type-navbar');
    }
}
