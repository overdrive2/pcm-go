<?php

namespace App\Http\Livewire\Request;

use App\Http\Livewire\Traits\Serials;
use App\Models\Poprd;
use App\Models\PoprdPlan;
use App\Models\PoprdPlanCache;
use App\Models\Poprh;
use App\Models\Stkplan;
use App\Models\Stmas;
use App\Models\StmasPlan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Detail extends Component
{
    use Serials;
    
    public $pod_id;
    public $editing;
    public $doctypes_id;
    public $inpln;
    public $plan = true;
    public $planIds = [];
    public $selectedId;
    public $selectedPlanId;
    public $po_id;
    public $qty = 0;
    public $sessionId;

    public $master = [
        'doctypes_id' => '',
        'inpln' => '',
        'year' => '',
    ];

    protected $listeners = [
        'delete:poprdplan' => 'delete',
        'delete:cache' => 'deleteCache',
        'refresh:detail' => '$refresh',
        'set:stmassid' => 'setStmass',
        'save:poprd' => 'save',
        'set:cache-plan' => 'setCachePlan'
    ];

    public function setCachePlan($planIds)
    {
        $data = $this->packPlanCache($planIds);
        PoprdPlanCache::insert($data);
        $this->editing->qty = PoprdPlanCache::where('session_id', $this->sessionId)->sum('qty');
        $this->planIds = PoprdPlanCache::where('session_id', $this->sessionId)->pluck('stkplan_id');
        $this->emit('close:plan:modal');
        //dd($planIds);
    }

    public function save()
    {
        $this->validate();

        if(!$this->editing->id) { // is new detail
            // save po detail
            $this->pod_id = $this->getSerial('poprd_id_seq');
            $this->editing->id =  $this->pod_id;
        }

        if($this->plan) {
            // Load Plan from Session
            $plans = PoprdPlanCache::where('session_id', $this->sessionId)->get();
            
            // Delete compare Plan cache
            PoprdPlan::whereNotIn('stkplan_id', PoprdPlanCache::where('session_id', $this->sessionId)->pluck('stkplan_id'))->delete();

            // Transfer plan cache to plans
            foreach($plans as $plan) {
                $podplan = PoprdPlan::where('poprd_id', $this->pod_id)->where('stkplan_id', $plan->stkplan_id)->first();
                
                if($podplan) {
                    $podplan->qty = $plan->qty;
                    $podplan->save(); 
                }
                else {
                    PoprdPlan::create([
                        'poprd_id' => $this->pod_id,
                        'stkplan_id' => $plan->stkplan_id,
                        'qty' => $plan->qty,
                    ]);
                }
            }
        }
        $this->editing->save();
        PoprdPlanCache::where('session_id', $this->sessionId)->delete();
        $this->dispatchBrowserEvent('swal:success');
        return $this->emit('close:detail');
    }

    public function setStmass($id)
    {
        $stmas = Stmas::select('stkcod', 'stkdes', 'pqucod')->find($id);
        
        if(!$stmas)
            return $this->dispatchBrowserEvent('swal:error',[
                'text' => 'ไม่พบรายการ!'     
            ]);

        if(Poprd::where('stkcode', $stmas->stkcod)->where('poprh_id', $this->po_id)->count() > 0)
            return $this->dispatchBrowserEvent('swal:error',[
                'text' => 'พบรหัสซ้ำ!'     
            ]);

        $master = Poprh::select('inpln', 'y')->where('id', $this->po_id)->first();
           
        $this->plan = $master->inpln == 'Y' ? true : false;
        // get plan by stmass_id
        if($this->plan) { 
            $plan = Stkplan::selectRaw("stmas_id, stkcode, sum(pqty) as pqty, min(prc) as prc, json_agg (id) as plan_ids")
            ->where('stmas_id', $id)
            ->where('y', $master->y)
            ->where('cmp', false)
            ->groupBy('stmas_id', 'stkcode')
            ->first();
            
            $this->planIds = json_decode($plan->plan_ids);

            $data = $this->packPlanCache($this->planIds);
            
            PoprdPlanCache::where('session_id', $this->sessionId)->delete();
            PoprdPlanCache::insert($data);
          
            //$this->pod_id = $this->getSerial('poprd_id_seq');
            //$this->editing->id =  $this->pod_id;
            $this->editing->stmas_id = $id;
            $this->editing->stkcode = $plan->stkcode;
            $this->editing->stkdes = $stmas->stkdes;
            $this->editing->qty = PoprdPlanCache::where('session_id', $this->sessionId)->sum('qty');
            $this->editing->prc = $plan->prc;
            $this->editing->ttamt = $plan->pqty * $plan->prc;
            $this->editing->units_id = $stmas->pqucod;

          //  $data = $this->packPlans($this->pod_id, json_decode($plan->plan_ids));
           // PoprdPlan::insert($data);
           // $this->editing->save();
            /*dd($plans);
            $pod_id = $this->getSerial('poprd_id_seq');
            $plan_ids = json_decode($row['plan_ids']);
            $stmas = Stmas::select('stkdes', 'pqucod')->where('id', $row['stmas_id'])->first();
            $pod = $this->makeBlankDetail();
            $pod->id = $pod_id;
            $pod->stkcode = $row['stkcode'];
            $pod->stkdes = $stmas->stkdes;
            $pod->qty = $row['pqty'];
            $pod->prc = $row['prc'];
            $pod->ttamt = $row['pqty'] * $row['prc'];
            $pod->units_id = $stmas->pqucod;
            $pod->pln_qty = $row['pqty'];
            $pod->save();

            $data = $this->packPlans($pod_id, $plan_ids);
            PoprdPlan::insert($data);*/

        }


     //   $this->dispatchBrowserEvent('swal:success');
        $this->emit('close:stmasplan:modal');
    }

    public function updatedEditing($value, $name)
    {
        if($name == 'prc')
        {
            $this->editing->ttamt = $value * $this->editing->qty;
        }
    }

    public function packPlans($pod_id, $planIds)
    {
        $data = array();

        foreach($planIds as $id)
        {
            if(PoprdPlan::where('poprd_id', $pod_id)->where('stkplan_id', $id)->count() == 0)
                array_push($data, [
                    'poprd_id' => $pod_id,
                    'stkplan_id' => $id,
                    'qty' => Stkplan::where('id', $id)->value('pqty'),
                    'created_at' => DB::raw('CURRENT_TIMESTAMP'),
                    'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
                ]);
        }

        return $data;
    }

    public function packPlanCache($planIds)
    {
        $data = array();

        foreach($planIds as $id)
        {
            array_push($data, [
                'stkplan_id' => $id,
                'qty' => Stkplan::where('id', $id)->value('pqty'),
                'created_at' => DB::raw('CURRENT_TIMESTAMP'),
                'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
                'session_id' => $this->sessionId
            ]);
        }

        return $data;
    }

    public function rules()
    {
        return [
            'editing.poprh_id' => 'required',
            'editing.stmas_id' => 'required',
            'editing.stkcode' => 'required',
            'editing.stkdes' => 'required',
            'editing.qty' => 'required',
            'editing.prc' => 'required',
            'editing.ttamt' => 'required',
            'editing.units_id' => 'required',
            "editing.plan_id" => '',
            "editing.dept_id" => '',
            "editing.recno" => 'required',
            "editing.no" => 'required',
        ];
    }

    public function makeBlank()
    {
        return Poprd::make([
            'poprh_id' => $this->po_id,
            'stkcode' => '',
            'stkdes' => '',
            'qty' => 0,
            'prc' => 0,
            'ttamt' => 0,
            'units_id' => '',
            'pln_qty' => 0,
            'dept_id' => Poprh::where('id', $this->po_id)->value('dept_id'),
            'recno' => Poprd::where('poprh_id', $this->po_id)->max('recno')+1,
            'no' => Poprd::where('poprh_id', $this->po_id)->max('no')+1,
        ]);
    }

    public function initMaster()
    {
        $master = Poprh::select('inpln', 'y', 'doctypes_id')->where('id', $this->po_id)->first();

        return [
            'inpln' => $master->inpln == 'Y' ? true : false,
            'doctypes_id' => $master->doctypes_id,
            'year' => $master->y
        ];  
    }

    public function mount()
    {
        $this->sessionId = session()->getId();
        $this->master = $this->initMaster();
        
        $this->editing = $this->pod_id ? Poprd::where('id', $this->pod_id)->first() : $this->makeBlank();

        $this->planIds = ($this->master['inpln'] && $this->pod_id) ? PoprdPlan::where('poprd_id', $this->pod_id)->pluck('stkplan_id') : [];

        if(count($this->planIds) > 0) {
            $data = $this->packPlanCache($this->planIds);
            PoprdPlanCache::where('session_id', $this->sessionId)->delete();
            PoprdPlanCache::insert($data);
        }
    }

    public function delCacheConfirm($id)
    {
        $this->selectedPlanId = $id;

        $options = [
            'title' => 'โปรดยืนยันคำสั่ง', 
            'text' => 'ต้องการลบรายการนี้ใช่หรือไม่!', 
            'action' => 'delete:cache',
            'outside' => true,
        ];
        
        return $this->dispatchBrowserEvent('delete:confirm', $options);
    }

    public function add()
    {
        $this->emit('show:plan:modal',
            $this->editing->stmas_id
        );
    }

    public function editCache($id)
    {
        $this->selectedPlanId = $id;
        $this->qty = PoprdPlanCache::where('id', $this->selectedPlanId)->value('qty');
       // $this->emit('open:srcmodal', 'search-modal.plans', $this->pod_id);
    }

    public function deleteCache()
    {
        PoprdPlanCache::where('id', $this->selectedPlanId)->delete();
        $this->editing->qty = PoprdPlanCache::where('session_id', $this->sessionId)->sum('qty');
        $this->dispatchBrowserEvent('swal:success');
    }

    public function delete()
    {
        $ppln = PoprdPlan::where('id', $this->selectedId)->first();
        $ppln->delete();
        $this->dispatchBrowserEvent('swal:success');
        $this->emit('refresh:detail');
    }

    public function getRowsPlanProperty()
    {
      //  PoprdPlanCache::where('session_id', $this->sessionId)->orderBy('id')->get();

     //   if($this->editing->id)
     //       return PoprdPlan::where('poprd_id', $this->editing->id)->get();// Stkplan::whereIn('id', PoprdPlan::where('poprd_id', $this->editing->id)->pluck('stkplan_id'))->get();
        if(count($this->planIds) > 0) {
            return  PoprdPlanCache::where('session_id', $this->sessionId)->orderBy('id')->get();
        }
        return [];    
    }

    public function updatedqty($val)
    {
        if($val <= 0) 
            return $this->dispatchBrowserEvent('swal:error',[
                'text' => 'ค่ามากกว่า 0 เท่านั้น!'     
            ]);
        
        $curQty = PoprdPlan::where('stkplan_id', $this->selectedPlanId)->sum('qty');
        $pqty = Stkplan::where('id', PoprdPlanCache::where('id', $this->selectedPlanId)->value('stkplan_id'))->value('pqty');

        if(($val + $curQty) > (int)$pqty)
            return $this->dispatchBrowserEvent('swal:error',[
                'text' => 'จำนวนมากกว่าที่กำหนดในแผน! (ระบุไว้ ' . $pqty .')'     
            ]);

        PoprdPlanCache::where('id', $this->selectedPlanId)->update(['qty' => $val]);
            
        $this->editing->qty = PoprdPlanCache::where('session_id', $this->sessionId)->sum('qty');
        return $this->selectedPlanId = null;
    }

    public function getSummaryProperty()
    {

        $plan = Stkplan::selectRaw("sum(pqty) as pqty, sum(pamt) as ttamt")
            ->where('stmas_id', $this->editing->stmas_id)
            ->where('y', $this->master['year'])
            ->whereRaw("(select count(*) from poprd_plans where stkplan_id = stkplan.id) = 0")
            ->where('cmp', false)
            ->first();
       
        return [
            'qty' => $plan ? $plan->pqty : 0,
            'amount' => $plan ? $plan->ttamt : 0
        ];
    }

    public function render()
    {
        return view('livewire.request.detail',[
            'plans' => $this->rowsPlan,
            'summary' => $this->master['inpln'] ? $this->summary : [ 'qty' => 0, 'amount' => 0]
        ]);
    }
}
