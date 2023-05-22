<?php

namespace App\Http\Livewire\SearchModal;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\TbOject;
use Livewire\Component;

class Objects extends Component
{
    use WithCachedRows, WithPerPagePagination;

    public $loadData = false;
    public $search;
    public $itmtypeId;
    
    public function mount()
    {
        $this->perPage = 15;
    }

    public function searchupdated()
    {
        $this->resetPage();
    }

    public function setObject($value)
    {
        $this->emit('set:object', $value);
    }

    public function getRowsQueryProperty()
    {
        return TbOject::where('active', true)
            ->when($this->search, function($query){
                return $query->where('label', 'ilike', '%'.$this->search.'%');
            })->orderBy('label','asc');
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.search-modal.objects',[
            'rows' => $this->loadData ? $this->rows : []
        ]);
    }
}
