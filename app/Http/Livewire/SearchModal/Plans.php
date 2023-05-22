<?php

namespace App\Http\Livewire\SearchModal;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Department;
use App\Models\Poprd;
use App\Models\PoprdPlan;
use App\Models\PoprdPlanCache;
use App\Models\Poprh;
use App\Models\Stkplan;
use App\Models\Stmas;
use App\Models\StmasGroup;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Plans extends Component
{
    use WithCachedRows, WithPerPagePagination;

    public $loadData = false;
    public $search;
    public $po_id;
    public $stmas_id;
    public $doctype_id;
    public $selectedId = [];
    public $deptSelected = [];
    public $dept_id;
    public $selectAll = false;
    public $year;
    public $qty;

    protected $listeners = ['send:selected-plan' => 'sendSelectedPlan'];


    public function mount()
    {
        $this->perPage = 15;
        /*
        $this->selectedId = $this->pod_id ? 
            PoprdPlan::where('poprd_id', $this->pod_id)->pluck('stkplan_id') : [];

        $this->qty = Stkplan::whereIn('id', $this->selectedId)->sum('pqty');   */ 
    }

    public function updatedselectedId()
    {
        $this->qty = Stkplan::whereIn('id', $this->selectedId)->sum('pqty');
    } 

    public function updatedselectAll($value)
    {
        $this->selectedId = $value ? $this->rowsQuery->pluck('id') : [];
    }

    public function sendSelectedPlan()
    {
        $this->emit('set:cache-plan', $this->selectedId);
       // dd($this->selectedId);
      /*  $sessionId = session()->getId();

        foreach($this->selectedId as $planId)
        {
            PoprdPlanCache::insert([
                'session_id' => $sessionId,
                'stkplan_id' => $planId,
                'qty' => Stkplan::where('id', $planId)->value('pqty'),
                'created_at' => DB::raw('CURRENT_TIMESTAMP'),
                'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
            ]);    
        }

        $row = Stkplan::selectRaw("stmas_id, stkcode, sum(pqty) as pqty, min(prc) as prc, json_agg (id) as plan_ids")
            ->whereIn('id', $this->selectedId)
            ->groupBy('stmas_id', 'stkcode')
            ->get();
        */
      //  $this->emit('close:plan:modal');
    }

    public function updatedsearch()
    {
        $this->resetPage();
    }

    public function setItemType($value)
    {
        $this->emit('set:item-type', $value);
    }

    public function getRowsQueryProperty()
    {
        $master = Poprh::where('id', $this->po_id)->first();

        return Stkplan::where('stmas_id', $this->stmas_id)
            ->where('y', $master->y)
            ->whereRaw("(select count(*) from poprd_plans where stkplan_id = stkplan.id) = 0")
            ->when(count($this->deptSelected) > 0, function($query) {
                return $query->whereIn('from_dept', $this->deptSelected);
            })->orderBy('stkdesc','asc');

        /*if($this->pod_id) 
            return Stkplan::where('stkcode', Poprd::where('id', $this->pod_id)->value('stkcode'))
                ->where('y', $this->year)
                ->when(count($this->deptSelected) > 0, function($query) {
                    return $query->whereIn('from_dept', $this->deptSelected);
                })->orderBy('stkdesc','asc');

        return Stkplan::where('y', $this->year)  //where('approved', true)
            ->when($this->search, function($query) {
                return $query->whereRaw(sprintf("((stkdesc like '%s')or(stkcode like '%s'))", '%'.$this->search.'%', $this->search.'%'));
            })
            ->when(count($this->deptSelected) > 0, function($query) {
                return $query->whereIn('from_dept', $this->deptSelected);
            })
            ->when($this->doctype_id, function($query) {
                $groups = StmasGroup::where('doctype_id', $this->doctype_id)->pluck('id');
                $stmasIds = Stmas::whereIn('stkgrp', $groups)->pluck('id');
                return $query->whereIn('stmas_id', $stmasIds);
            })->orderBy('stkdesc','asc');*/
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function getDeptsProperty()
    {
        return $this->cache(function(){
            $master = Poprh::where('id', $this->po_id)->first();
            return Department::whereIn('dept_id', 
                StkPlan::where('dept', $master->dept_id)
                    ->where('y', $master->y)
                    ->where('stmas_id', $this->stmas_id)
                    ->pluck('from_dept'))->get();
        });
    }

    public function render()
    {
        return view('livewire.search-modal.plan',[
            'rows' => $this->loadData ? $this->rows : [],
            'depts' => $this->depts
        ]);
    }
}
