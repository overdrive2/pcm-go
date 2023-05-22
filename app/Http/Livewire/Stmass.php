<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Stmas;

class Stmass extends Component
{

    use WithSorting, WithCachedRows, WithPerPagePagination;

    public $filters = [
        'search' => '',
        'group_id' => '',
        'subgroup_id' => '',
    ];

    protected $queryString = ['sorts'];

    public function mount()
    {

        $this->filters['group_id'] = request('group_id');
        $this->filters['subgroup_id'] = request('id');
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
                return $query->whereRaw("tname ilike '%".$search."%'");
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
        return view('livewire.stmass',[
            'stmass' => $this->rows,
        ]);
    }
}
