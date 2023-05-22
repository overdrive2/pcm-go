<?php

namespace App\Http\Livewire\SearchModal;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Vendor;
use Livewire\Component;

class Vendors extends Component
{
    use WithCachedRows, WithPerPagePagination;

    public $loadData = false;
    public $search;
    public $current_id;
    
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
        $this->emit('set:vendor', $value);
    }

    public function getRowsQueryProperty()
    {
        return Vendor::query()
            ->when($this->search, function($query){
                return $query->where('supnam', 'ilike', '%'.$this->search.'%');
            })->orderBy('supnam','asc');
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.search-modal.vendor',[
            'rows' => $this->loadData ? $this->rows : []
        ]);
    }
}
