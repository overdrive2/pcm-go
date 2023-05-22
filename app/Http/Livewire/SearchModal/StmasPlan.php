<?php

namespace App\Http\Livewire\SearchModal;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Poprh;
use App\Models\PoreqH;
use App\Models\Stkplan;
use App\Models\Stmas;
use App\Models\StmasGroup;
use Livewire\Component;

class StmasPlan extends Component
{
    use WithPerPagePagination, WithCachedRows;
    
    public $pod_id, $po_id;
    public $poh;
    public $search;
    public $loadData = false;
    //public $selectedId = [];
   
    public function rules()
    {
        return [
            'poh.doctype_id' => '',
            'poh.inplan' => '',
            'poh.y' => '',
            'poh.dept_id' => ''
        ];
    }

    public function mount()
    {
        $this->poh = PoreqH::select('doctype_id', 'inplan', 'y', 'dept_id')->where('id', $this->po_id)->first();
    }

    public function getRowsQueryProperty()
    {
        return Stmas::where('status', 'A')
            ->when($this->search, function($query, $search){
                return $query->whereRaw(sprintf("((stkdes ilike '%s')or(stkcod like '%s'))", '%'.$search.'%', $search.'%'));
            })
            ->when($this->poh->doctype_id, function($query, $doctype_id) {
                $groups = StmasGroup::where('doctype_id', $doctype_id)->pluck('id');
                return $query->whereIn('stkgrp', $groups);
            })
            ->when($this->poh->inpln == 'Y', function($query){
                $ids = Stkplan::selectRaw('distinct(stmas_id) as id')->where('y', $this->poh->y)->pluck('id');
                return $query->whereIn('id', $ids);
            })
            ->orderBy('stkdes');
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.search-modal.stmas-plan',[
            'rows' => $this->loadData ? $this->rows : []
        ]);
    }
}
