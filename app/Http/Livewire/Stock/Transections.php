<?php

namespace App\Http\Livewire\Stock;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\Traits\DBLookups;
use App\Models\TranferDetail;
use Livewire\Component;

class Transections extends Component
{
    use WithCachedRows, WithPerPagePagination, DBLookups;

    public $filters = [
        'search' => '',
        'dept_id' => '148',
        'site' => '',
        'stkcode' => '',
    ];
    public $sites, $depts;

    public function getRowsQueryProperty()
    {
        $query = TranferDetail::query()
            ->join('trhs', 'trhs.id', 'trds.trhs_id')
            ->when($this->filters['search'], function($query, $search){
                return $query->where('trds.stkcode', $search);
            })
            ->whereBetween('trhs.trdate', ['2022-10-01', '2023-09-30'])
            ->where('trds.site', $this->filters['site'])
            ->orderBy('trhs.trdate', 'asc')
            ->orderBy('trhs.trtime', 'asc');
        return $query;
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function mount()
    {
        $this->filters['site'] = (auth()->user()->stksite != '')? auth()->user()->stksite : 'NA';
        $this->sites = $this->site_rows;
        $this->depts = $this->dept_rows;
    }

    public function render()
    {
        return view('livewire.stock.transections', [
            'collection' => $this->rows,
        ]);
    }
}
