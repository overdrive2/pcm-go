<?php

namespace App\Http\Livewire\Plan;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Doctype;
use App\Models\Stkplan;
use App\Models\Stmas;
use App\Models\StmasGroup;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Movement extends Component
{
    use WithPerPagePagination;

    public $dept_id = '148';
    public $year = 2023;
    public $site = '03';
    public $search = '';
    public $doctype_ids;
    public $doctype_id;
    public $showEditModal = false;
    public Stmas $editing;

    public function rules()
    {
        return [
            'editing.stkcod' => 'required',
            'editing.stkdes' => 'required',
            'editing.stkdes_eng' => 'required',
            'editing.stkdes_site' => 'required',
            'editing.stkgrp' => 'required',
            'editing.stksubgrp' => 'required',
            'editing.stkdes' => 'required',
            'editing.unitpr' => 'required',
            'editing.status' => 'required',
            'editing.stktype' => 'required',
            'editing.creby' => 'required',
            'editing.userid' => 'required'
        ];
    }

    public function edit($id)
    {
        $this->editing = Stmas::find($id);
        $this->showEditModal = true;
    }

    public function mount()
    {
        $this->doctype_ids = auth()->user()->documents->pluck('doctype_id');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDoctypeId()
    {
        $this->resetPage();
    }

    public function updatingYear()
    {
        $this->resetPage();
    }

    public function getYearsProperty()
    {
       return collect(DB::select("select i as y, (i+543) as th from generate_series(date_part('year', CURRENT_DATE)::int-1, date_part('year', CURRENT_DATE)::int+1) i order by i desc;"));
    }

    public function getRowQueryProperty()
    {
        /*$query = Stkplan::where('dept', $this->dept_id)
            ->where('y', $this->year)
            ->when($this->search, function($query) {
                return $query->where('stkdesc', 'like', '%'.$this->search.'%');
            });
        $query = Stmas::where('status', 'A')
            ->whereIn('stkgrp', StmasGroup::whereIn('doctype_id', $this->doctype_ids)->pluck('id'))
            ->when($this->doctype_id, function($query) {
                return $query->whereRaw(sprintf("stkgrp in (select id from stkgrps where doctype_id=%d)", $this->doctype_id));
            })
            ->when($this->search, function($query, $search){
                return $query->whereRaw(sprintf("((stkcod like '%s')or(stkdes ilike '%s'))", $search.'%', '%'.$search.'%'));
            })->orderBy('stkcod');

        return $query;*/
        $query = Stkplan::selectRaw('stkcode, y, sum(pqty) as qty, sum(pamt) as amount')
            ->where('dept', $this->dept_id)
            ->where('y', $this->year)
            ->groupBy(DB::raw('stkcode, y order by sum(pamt) desc'));

        return $query;
    }

    public function getRowsProperty()
    {
        return $this->applyPagination($this->rowQuery);
    }

    public function render()
    {
        return view('livewire.plan.movement', [
            'rows' => $this->rows,
            'documents' => Doctype::whereIn('id', $this->doctype_ids)->get(),
            'years' => $this->years,
        ]);
    }
}
