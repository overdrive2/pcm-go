<?php

namespace App\Http\Livewire\Order;

use App\Models\PoreqD;
use App\Models\PoreqDetailPlan;
use App\Models\Stkplan;
use Livewire\Component;

class DetailPlan extends Component
{
    public $poreq_d_uid;
    public $stmas_id;
    public $selectedId;
    public $qty, $editId;

    protected $listeners = [
        'set:stkplan' => 'setStkplan',
        'set:stkplan:miltuple' => 'setStkplanMultiple',
        'delete:detail:plan' => 'delete',
    ];

    public function deleteConfirm($id)
    {
        $this->selectedId = $id;

        $options = [
            'title' => 'โปรดยืนยันคำสั่ง', 
            'text' => 'ต้องการลบรายการนี้ใช่หรือไม่!555', 
            'action' => 'delete:detail:plan',
            'outside' => true,
        ];
        
        return $this->dispatchBrowserEvent('delete:confirm', $options);
    } 

    public function delete()
    {
        PoreqDetailPlan::where('id', $this->selectedId)->delete();
        $this->emit('update:qty');
        //$this->emitSelf('$refresh');
        
       // $this->dispatchBrowserEvent('notice', ['type' => 'delete', 'text' => 'Item moved successfully.']);
    }

    public function cancel()
    {
        $this->editId = null;
        $this->qty = null;
    }

    public function edit($id) 
    {
        $this->editId = $id;
        $this->qty = PoreqDetailPlan::find($id)->qty;
    }

    public function save()
    {
        $reqd = PoreqDetailPlan::find($this->editId);

        $oqty = PoreqDetailPlan::where('id', '<>', $reqd->id)
            ->where('stkplan_id', $reqd->stkplan_id)->sum('qty');
        $pqty = Stkplan::where('id', $reqd->stkplan_id)->value('pqty');

        if(($oqty + $this->qty) > $pqty)
            return $this->dispatchBrowserEvent('swal:error',[
                'text' => 'จำนวนเกินแผน ' . $pqty 
            ]);


        PoreqDetailPlan::where('id', $this->editId)->update([
            'qty' => $this->qty
        ]);

        $this->emit('update:qty');
        $this->editId = null;
    }

    public function setStkplan($id, $qty) {
        PoreqDetailPlan::create([
            'poreq_d_uid' =>  $this->poreq_d_uid,
            'stkplan_id' => $id,
            'qty' => $qty
        ]);
        $this->emitSelf('$refresh');
        $this->emit('close:one:stmas');
        $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => 'Item added successfully.']);
    }

    public function setStkplanMultiple($ids)
    {
        foreach(Stkplan::whereIn('id', $ids)->get() as $item)
        {
            PoreqDetailPlan::create([
                'poreq_d_uid' =>  $this->poreq_d_uid,
                'stkplan_id' => $item->id,
                'qty' => $item->pqty
            ]);
        }
        $this->emit('update:qty');
        $this->emit('close:one:stmas');
        /*$this->emit('close:one:stmas');
        $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => 'Item added successfully.']);
        $this->emitSelf('$refresh');*/
    }

    public function getRowsProperty()
    {
        $this->stmas_id = PoreqD::where('uid', $this->poreq_d_uid)->value('stmas_id');
        return PoreqDetailPlan::where('poreq_d_uid', $this->poreq_d_uid)->get();
    }

    public function render()
    {
        return view('livewire.order.detail-plan',[
            'rows' => $this->rows
        ]);
    }
}
