<?php

namespace App\Http\Livewire;

use App\Models\WebMenu;
use Livewire\Component;

class StockHome extends Component
{
    public $menus;
    public $menu_group_id = 2;

    public function mount()
    {
        $this->menus = WebMenu::where('menu_group_id', $this->menu_group_id)->orderBy('no', 'asc')->get();
    }
    
    public function render()
    {
        return view('livewire.stock-home');
    }
}
