<?php

namespace App\Http\Livewire\SearchModal;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Brand;
use Livewire\Component;

class Brands extends Component
{
    use WithCachedRows, WithPerPagePagination;

    public $loadData = false;
    public $search;
    public $brandId;
    
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
        return Brand::query()
            ->when($this->search, function($query){
                return $query->where('brandname', 'ilike', '%'.$this->search.'%');
            })->orderBy('brandname','asc');
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.search-modal.brand',[
            'rows' => $this->loadData ? $this->rows : []
        ]);
    }
}
