<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Committ;

class CommitteeSearch extends Component
{
    use WithCachedRows, WithPerPagePagination;

    public $search, $comtype;

    public function getRowsQueryProperty()
    {

        return Committ::query()
            ->when($this->search, function($query, $search){
                return $query->whereRaw("((gfname like '" . $search . "%')or(glname like '" . $search . "%'))");
            });
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rows_query);
        });
    }

    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.committee-search',[
            'directors' => $this->rows,
        ]);
    }
}
