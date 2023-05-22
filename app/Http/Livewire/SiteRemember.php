<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class SiteRemember extends Component
{
    public $site;

    protected $listeners = ['refreshSiteRemember' => '$refresh'];

    public function mount()
    {
       // $this->site = auth()->user()->stksite;
    }

    public function remember()
    {
        User::where('id', auth()->user()->id)->update(['stksite' => $this->site]);
        $this->emit('refreshSiteRemember');
    }

    public function render()
    {
        return view('livewire.site-remember');
    }
}
