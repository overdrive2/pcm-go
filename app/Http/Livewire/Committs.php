<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Committ;
use Livewire\Component;

class Committs extends Component
{
    use WithCachedRows, WithPerPagePagination, WithSorting;
    public $gname_search;

    public function getRowsQueryProperty()
    {
        $query = Committ::query()
                ->when($this->gname_search, function($query, $kw){
                    return $query->whereRaw("(gname like '%".$kw."%')")->orderBy('gname', 'asc');
                });
        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.committs', [
            'committs' => $this->rows,
        ]);
    }
}
