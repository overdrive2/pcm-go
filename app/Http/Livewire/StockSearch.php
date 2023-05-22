<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Site;
use App\Models\TranferDetail;
use Livewire\Component;

class StockSearch extends Component
{
    use WithPerPagePagination, WithCachedRows;

    public $site, $search;

    public function mount()
    {
        $this->perPage = 10;
    }

    public function getRowsQueryProperty()
    {
        $query = TranferDetail::query()
            ->when($this->search, function($query, $search){
                return $query->where('stkdes', 'ilike', '%'.$search.'%');
            })
            ->where('site', $this->site)
            ->where('trntype', 'I');

        return $query;
    }

    public function getRowsProperty()
    {
        return $this->cache(function() {
            return $this->applyPagination($this->rows_query);
        });
    }

    public function render()
    {
        return view('livewire.stock-search',[
            'rows' => $this->rows,
            'site_name' => Site::where('id', $this->site)->value('sitename'),
        ]);
    }
}
