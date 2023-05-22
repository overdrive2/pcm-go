<?php

namespace App\Http\Livewire\SearchModal;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Itmtype as ItemType;
use Livewire\Component;

class ItmType extends Component
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

    public function setItemType($value)
    {
        $this->emit('set:item-type', $value);
    }

    public function getRowsQueryProperty()
    {
        return ItemType::where('active', true)
            ->when($this->search, function($query){
                return $query->where('iname', 'ilike', '%'.$this->search.'%');
            })->orderBy('ord','asc');
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.search-modal.itm-type',[
            'rows' => $this->loadData ? $this->rows : []
        ]);
    }
}
