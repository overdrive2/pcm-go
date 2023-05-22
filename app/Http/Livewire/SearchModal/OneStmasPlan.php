<?php

namespace App\Http\Livewire\SearchModal;

use App\Models\Stkplan;
use App\Models\StmasPlan;
use Livewire\Component;

class OneStmasPlan extends Component
{
    public $stmas_id, $y, $dept_id;
    public $loadData = false;
    public $checkAll = false;
    public $selectedIds = [];

    protected $listeners = [
        'post:selected:plan' => 'post'
    ];

    public function post()
    {
        $this->emit('set:stkplan:miltuple', $this->selectedIds);
    }

    public function updatedCheckAll($value)
    {
        $this->selectedIds = $value ? $this->rowsQuery->pluck('id') : [];
    }

    public function getRowsQueryProperty()
    {
        return Stkplan::where('stmas_id', $this->stmas_id)
            ->whereRaw("(select case when sum(qty) is null then 0 else sum(qty) end  from poreq_detail_plans where stkplan_id = stkplan.id) < pqty")
            ->where('y', $this->y);
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->get();
    }

    public function render()
    {
        return view('livewire.search-modal.one-stmas-plan', [
            'rows' => $this->loadData ? $this->rows : [],
            'summary' => count($this->selectedIds) > 0 ? Stkplan::selectRaw("sum(pqty) as qty, sum(pamt) as amount")->whereIn('id', $this->selectedIds)->first() : null
        ]);
    }
}
