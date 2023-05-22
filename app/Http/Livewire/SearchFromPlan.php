<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Stkplan;
use App\Models\UserDept;
use Livewire\Component;

class SearchFromPlan extends Component
{
    use WithPerPagePagination;

    public $master_id;
    public $loadData = false;
    public $y = 2023; // year of plan
    public $search;

    public function mount()
    {
        $this->perPage = 25;
    }

    public function setPlanId($id)
    {
        $this->emit('set:plan-id', $id);
    }

    public function getRowsQueryProperty()
    {
        $deptIds = UserDept::where('usercode', auth()->user()->usercode)->pluck('depts_id');

        return Stkplan::whereNull('stkplan_master_id')
            ->when($this->search, function ($query, $search){
                return $query->whereRaw("((stkdesc like '%".$search."%')or(stkcode like '".$search."%'))");
            })
            ->whereIn('dept', $deptIds)
            ->where('y', $this->y);
    }

    public function getRowsProperty()
    {
        return $this->applyPagination($this->rowsQuery);
    }

    public function render()
    {
        return view('livewire.search-from-plan',[
            'rows' => ($this->loadData) ? $this->rows : []
        ]);
    }
}
