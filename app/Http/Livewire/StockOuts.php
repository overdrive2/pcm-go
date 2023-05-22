<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\Traits\DBLookups;
use App\Models\TranferDetail;
use App\Models\TranferMaster;
use Livewire\Component;

class StockOuts extends Component
{
    use WithPerPagePagination, WithSorting, WithCachedRows, DBLookups;

    public $filters = [
        'search' => '',
        'dept_id' => '',
        'site' => '',
        'stkcode' => '',
    ];

    public $showAdvanceSearch = false;
    public $showStmassModal = false;

    protected $queryString = ['sorts'];

    public function getRowsQueryProperty()
    {
        $query = TranferMaster::query()
            ->where('trntype', 'O')
            ->when($this->filters['stkcode'], function($query, $stkcode){
                return $query->whereRaw(sprintf("id in (select trhs_id from trds where stkcode='%s')", $stkcode));
            })
            ->when($this->filters['dept_id'], function($query, $dept_id) {
                return $query->where('dept_id', $dept_id);
            })
            ->when($this->filters['site'], function($query, $site) {
                return $query->where('site', $site);
            });
        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function() {
            return $this->applyPagination($this->rows_query);
        });
    }

    public function mount()
    {
        $this->filters['site'] = (auth()->user()->stksite != '')? auth()->user()->stksite : 'NA';
        $this->perPage = 15;
    }

    public function toggleModal($id)
    {
        $this->showStmassModal = true;
    }

    public function render()
    {
        return view('livewire.stock-outs', [
            'transfers' => $this->rows,
            'sites' => $this->site_rows,
            'vendors' => $this->vendor_rows,
        ]);
    }
}
