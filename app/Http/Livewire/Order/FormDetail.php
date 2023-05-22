<?php

namespace App\Http\Livewire\Order;

use App\Models\PoreqD;
use App\Models\PoreqDetailPlan;
use App\Models\PoreqH;
use App\Models\Stkplan;
use App\Models\Stmas;
use Livewire\Component;
use Ramsey\Uuid\Rfc4122\UuidV4;

class FormDetail extends Component
{
    public $detail_id, $poreq_id;
    public PoreqD $editing;

    protected $listeners = [
        'update:qty' => 'updateQty',
        'save:poreqd' => 'save',
        'set:stmassid' => 'setStmass',
    ];

    public function setStmass($id)
    {
        $stmas = Stmas::select('stkcod', 'stkdes', 'pqucod')->find($id);
        $ph = PoreqH::where('id', $this->poreq_id)->select('inplan', 'y')->first();

        $this->editing->stmas_id = $id;
        $this->editing->stkcode = $stmas->stkcod;
        $this->editing->stkdes = $stmas->stkdes;
        $this->editing->unit_id = $stmas->pqucod;
        if($ph->inplan == 'Y')
            $this->editing->prc = Stkplan::where('stmas_id', $this->editing->stmas_id)->min('prc');
        if(!$this->editing->id) {
            $this->editing->uid = UuidV4::uuid4()->toString();
            $this->editing->save();
        } 
        
        if($ph->inplan == 'Y')
        {
            $selectedIds = Stkplan::where('stmas_id', $this->editing->stmas_id)
                ->whereRaw("(select case when sum(qty) is null then 0 else sum(qty) end  from poreq_detail_plans where stkplan_id = stkplan.id) < pqty")
                ->where('y', $ph->y)->pluck('id'); 
            $this->emit('set:stkplan:miltuple', $selectedIds); 
        }
          
        return $this->emit('close:stmasplan');
    }

    public function updateQty()
    {
        $this->editing->qty = PoreqDetailPlan::where('poreq_d_uid', $this->editing->uid)->sum('qty');
        if($this->editing->prc == 0) {
            $this->editing->prc = Stkplan::whereIn('stmas_id', PoreqDetailPlan::where('poreq_d_uid', $this->editing->uid)->pluck('stkplan_id'))->min('prc');
        }
        $this->editing->ttamt = $this->editing->qty * $this->editing->prc;
        $this->dispatchBrowserEvent('swal.toast');
        $this->emitSelf('$refresh');
        //$this->emit('close:one:stmas');
    }

    public function rules()
    {
        return [
            'editing.poreq_id' => 'required',	
            'editing.stmas_id' => 'required',	
            'editing.stkcode' => 'required',	
            'editing.stkdes' => 'required',	
            'editing.qty' => 'required',	
            'editing.unit_id' => 'required',	
            'editing.prc' => 'required',	
            'editing.ttamt' => 'required',	
            'editing.lastprc' => '',	
            'editing.plan_id' => '',	
            'editing.plan_no' => '',	
            'editing.plnqty' => '',
            'editing.price_for_editing' => 'required',
            'editing.ttamt_for_editing' => 'required',
            'editing.uid' => '',
        ];
    }

    public function makeBlank()
    {
        return PoreqD::make([
            'poreq_id' => $this->poreq_id
        ]);
    }

    public function save() {
        $this->validate();
        $this->editing->save();
        $this->emit('close:detail');
        $this->dispatchBrowserEvent('swal.toast');
    }

    public function mount()
    {
        $this->editing = $this->detail_id ? PoreqD::where('uid', $this->detail_id)->first() : $this->makeBlank();
    }

    public function updatedEditing($value, $name) {
        switch ($name) {
            case 'ttamt_for_editing':
              $this->editing->prc = $this->editing->ttamt / $this->editing->qty;
              break;
            case 'price_for_editing':
              $this->editing->ttamt = $this->editing->prc * $this->editing->qty;
              break;
            default:
                return 0;
          }
    }

    public function render()
    {
        return view('livewire.order.form-detail');
    }
}
