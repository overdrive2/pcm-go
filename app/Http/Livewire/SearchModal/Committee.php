<?php

namespace App\Http\Livewire\SearchModal;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Committ;
use Livewire\Component;

class Committee extends Component
{
    use WithCachedRows, WithPerPagePagination;

    public $loadData = false;
    public $search;
    public $comId;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function getRowsQueryProperty()
    {
        return Committ::Query()
            ->when($this->search, function ($query) {
                return $query->where('gname', 'like', '%' . $this->search . '%');
            })
            ->orderBy('gname');
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.search-modal.committee', [
            'rows' => $this->loadData ? $this->rows : []
        ]);
    }
}
