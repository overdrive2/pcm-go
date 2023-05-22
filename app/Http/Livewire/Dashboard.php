<?php

namespace App\Http\Livewire;

use App\Models\WebMenu;
use Livewire\Component;

class Dashboard extends Component
{
    public $menus;

    public function mount()
    {
        $this->menus = WebMenu::where('menu_group_id', 1)->orderBy('no', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
