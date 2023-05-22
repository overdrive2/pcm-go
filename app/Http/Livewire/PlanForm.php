<?php

namespace App\Http\Livewire;

use App\Models\Stkplan;
use App\Models\StkplanMaster;
use App\Models\Stmas;
use App\Models\Unit;
use Livewire\Component;

class PlanForm extends Component
{
    public $master_id;

    public Stkplan $editing;

    public $user_id;
    public $y;
    public $plan_id;
    public $master;

    protected $listeners = [
        'save:stkplan' => 'save',
        'set:stkcode' => 'setStkcode'
    ];

    public function save()
    {
        if(!$this->editing->creby) 
            $this->editing->creby = $this->user_id;
        if(!$this->editing->updby) 
            $this->editing->updby = $this->user_id;
        if(!$this->editing->id)
        {
            $this->editing->updby = $this->user_id;    
        }      
        $this->validate();
        $this->editing->save();
        $this->emit('close:modal', 'showEditPlanModal');
        $this->emit('refresh:stkplan');
        $this->dispatchBrowserEvent('swal:success');
    }

    public function rules()
    {
        return [
            "editing.y" => 'required', 
            "editing.stkcode" => 'required', 
            "editing.pqty" => 'required', 
            "editing.bqty" => '', 
            "editing.dept" => 'required', 
            "editing.pamt" => 'required', 
            "editing.stkdesc" => 'required', 
            "editing.q1" => '', 
            "editing.q2" => '', 
            "editing.q3" => '', 
            "editing.q4" => '', 
            "editing.creby" => 'required', 
            "editing.bamt" => '', 
            "editing.prc" => 'required', 
            "editing.unit" => 'required', 
            "editing.plntype" => 'D', 
            "editing.doctype_id" => '', 
            "editing.updby" => 'required', 
            "editing.no" => 'required', 
            "editing.note" => '', 
            "editing.resplan" => '', 
            "editing.last_prc" => '', 
            "editing.dep_req" => '', 
            "editing.conf" => 'required', 
            "editing.stkdesc2" => '', 
            "editing.from_dept" => 'required', 
            "editing.stkplan_master_id" => 'required', 
            "editing.approved" => 'required'
        ];
    }

    public function setStkcode($value)
    {
        $stmas = Stmas::select('stkdes', 'stkcod', 'pqucod', 'unitpr')->where('stkcod', $value)->first();
        $this->editing->stkcode = $value;
        $this->editing->stkdesc = $stmas->stkdes;
        $this->editing->unit = Unit::where('id', $stmas->pqucod)->value('udesc');
    }

    public function resetStmas()
    {
        $this->editing->pqty = 0;
        $this->editing->prc = 0.00;
        $this->editing->pamt = 0;
        $this->editing->q1 = 0;
        $this->editing->q2 = 0;
        $this->editing->q3 = 0;
        $this->editing->q4 = 0;
    }

    public function updatedEditing($val, $nm)
    {
        if($nm == 'pqty')
            $this->editing->pamt =  $val * $this->editing->prc;
        if($nm == 'prc')
            $this->editing->pamt =  $val * $this->editing->pqty; 
    }

    public  function makeBlank() 
    {
        return Stkplan::make([
            'stkplan_master_id' => $this->master_id,
            'dept' => $this->master->to_dept_id ?? '',
            'from_dept' => $this->master->from_dept_id ?? '',
            'y' => $this->master->y ?? date('Y'),
            'q1' => 0,
            'q2' => 0,
            'q3' => 0,
            'q4' => 0,
            'conf' => 'Y',
            'no' => Stkplan::where('y', $this->master->y ?? date('Y'))->where('dept', $this->master->to_dept_id ?? '')->max('no') + 1,
            'creby' => $this->user_id,
            'updby' => $this->user_id,
            'approved' => true
        ]);
    }

    public function mount()
    {
        $this->user_id = auth()->user()->id;
        $this->master = StkplanMaster::find($this->master_id);
        if($this->plan_id) {
            $this->editing = Stkplan::where('id', $this->plan_id)->first();
            $this->editing->updby = $this->user_id;
            $this->master_id = $this->editing->stkplan_master_id;
        }
        else
            $this->editing = $this->makeBlank();
            //dd($this->editing);
    }

    public function render()
    {
        return view('livewire.plan-form');
    }
}
