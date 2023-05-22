<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Stkplan;
use App\Models\StkplanMaster;
use Livewire\Component;

class StkPlans extends Component
{
    use WithPerPagePagination, WithCachedRows;

    protected $listeners = [
        'set:plan-id' => 'setPlanId',
        'refresh:stkplan' => '$refresh',
    ];

    public $master_id;
    public $search = '';
    public $loadData = false;

    public function mount()
    {
        $this->perPage = 10;
    }

    public function setPlanId($id)
    {
        $master = StkplanMaster::where('id', $this->master_id)->first();

        Stkplan::where('id', $id)->update([
            'stkplan_master_id' => $this->master_id,
            'from_dept' => $master->from_dept_id
        ]);
    }

    public function getRowsQueryProperty()
    {
        return Stkplan::where('stkplan_master_id', $this->master_id)
        ->where('delflg', false)
        ->when($this->search, function($query) {
            return $query->whereRaw(sprintf("((stkcode like '%s')or(stkdesc ilike '%s')or(stkcode like '%s'))", 
                $this->search.'%', 
                '%'.$this->search.'%',
                $this->search.'%'
            ));
        })
        ->orderBy('no');
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.stk-plans', [
            'rows' => ($this->loadData) ? $this->rows : []
        ]);
    }
}
