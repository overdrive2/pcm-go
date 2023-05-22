<?php

namespace App\Http\Livewire\SearchModal;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Department;
use Livewire\Component;

class Departments extends Component
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
        $this->emit('set:item-type', $value);
    }

    public function getRowsQueryProperty()
    {
        return Department::query()
            ->when($this->search, function($query){
                return $query->where('dept_name', 'ilike', '%'.$this->search.'%');
            })->orderBy('dept_name','asc');
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.search-modal.department',[
            'rows' => $this->loadData ? $this->rows : []
        ]);
    }
}
