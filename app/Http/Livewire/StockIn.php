<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\Traits\DBLookups;
use App\Models\Site;
use App\Models\TranferMaster;
use App\Models\Vendor;

class StockIn extends Component
{
    use WithPerPagePagination, WithSorting, WithCachedRows, DBLookups;

    public $showAdvSearch = false;
    public $showStmassModal = false;
    public $vendor_name;
    public $vendorIds;

    public $filters = [
        'search' => '',
        'dept_id' => '',
        'site' => '',
        'stkcode' => '',
        'vendors_id' => '',
    ];

    protected $listeners = [
        'set:stkcode' => 'setStkcode',
    ];

    protected $queryString = ['sorts'];

    public function updatedfilters($val, $name)
    {
        if(($name == 'vendors_id')&&($val != '')) $this->vendor_name = Vendor::where('id', $val)->value('supnam');
    }

    public function setStkcode($val)
    {
        $this->filters['stkcode'] = $val;
    }

    public function advSearch()
    {
        $this->showAdvSearch = true;
    }

    public function getCondition($query)
    {
        return $query->where('trntype', 'I')
            ->when($this->filters['dept_id'], function($query, $dept_id) {
                return $query->where('dept_id', $dept_id);
            })
            ->when($this->filters['site'], function($query, $site) {
                return $query->where('site', $site);
            })
            ->when($this->filters['search'], function($query, $search) {
                return $query->where('docnum', 'ilike', $search.'%');
            })
            ->when($this->filters['vendors_id'], function($query, $vendors_id) {
                return $query->where('dept_id', $vendors_id);
            })
            ->when($this->filters['stkcode'], function($query, $stkcode) {
                return $query->whereRaw("(id in(select trhs_id from trds where stkcode ='".$stkcode."' and trntype='I'))");
            });
    }

    public function getRowsQueryProperty()
    {
        $query = $this->getCondition(TranferMaster::query());

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
        $this->filters['site'] = auth()->user()->stksite;
        $this->vendorIds = TranferMaster::select('dept_id')->where('site', $this->filters['site'])
            ->where('trntype', 'I')
            ->groupBy('dept_id')
            ->pluck('dept_id');
        $this->perPage = 15;
    }

    public function getVendorByTranRowsProperty()
    {
        return $this->cache(function () {
            $query = Vendor::selectRaw("id, prenam, supnam, flg")
                ->where('flg', 'Y')
                ->whereIn('id', $this->vendorIds)
                ->when($this->search['vendor_kw'],
                    function($query, $kw){
                        return $query->whereRaw("supnam like '%".$kw."%'");
                })->orderBy('supnam', 'asc');

            return $query->get();
        });

    }

    public function render()
    {
        return view('livewire.stock-in', [
            'transfers' => $this->rows,
            'sites' => $this->site_rows,
            'vendors' => $this->vendor_by_tran_rows,
            'site_name' => Site::where('id', auth()->user()->stksite)->value('sitename'),
        ]);
    }
}
