<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DirectorModal extends Component
{
    public $showModalDirector = false;
    protected $listeners = ['modal:director'=>'modalDirector'];

    public function modalDirector($value)
    {
        $this->showModalDirector = $value;
    }
    public function render()
    {
        return view('livewire.director-modal');
    }
}
