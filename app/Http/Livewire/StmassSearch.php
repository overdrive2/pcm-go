<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Stmas;
use App\Models\TranferDetail;
use Livewire\Component;

class StmassSearch extends Component
{
    use WithSorting, WithCachedRows, WithPerPagePagination;

    public $filters = [
        'search' => '',
        'group_id' => '',
        'subgroup_id' => '',
    ];

    public $site, $site_name, $trntype;

    public $loadData = true;

    protected $queryString = ['sorts'];

    public function mount()
    {
        $this->perPage = 15;
    }

    public function getRowsQueryProperty()
    {
        $query = Stmas::query()
            ->when(($this->filters['group_id'] != '*')&&($this->filters['group_id']), function($query){
                return $query->where('stkgrp', $this->filters['group_id']);
            })
            ->when(($this->filters['subgroup_id'] != '*')&&($this->filters['subgroup_id']), function($query){
                return $query->where('stksubgrp', $this->filters['subgroup_id']);
            })
            ->when($this->filters['search'], function($query, $search){
                return $query->whereRaw("((stkcod ilike '%".$search."%')or(stkdes ilike '%".$search."%'))");
            })
            ->when($this->site, function($query, $site){
                $stkcodes = TranferDetail::selectRaw("stkcode")->where('site', $site)->groupBy('stkcode')->pluck('stkcode');
                return $query->whereIn('stkcod', $stkcodes);
            });

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rows_query);
        });
    }

    public function render()
    {
        return view('livewire.stmass-search',[
            'stmass' => ($this->loadData) ? $this->rows : [],
        ]);
    }
}
