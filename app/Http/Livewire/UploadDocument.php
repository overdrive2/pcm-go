<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadDocument extends Component
{
    use WithFileUploads;

    public $files = [];

    public function updatedFiles()
    {
        //dd($this->files);
    }

    public function render()
    {
        return view('livewire.upload-document');
    }
}
