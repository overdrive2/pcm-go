<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Helpers\FunctionDateTimes;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\Traits\CashOrderDetails;
use App\Http\Livewire\Traits\DBLookups;
use App\Http\Livewire\Traits\Serials;
use App\Models\Committ;
use App\Models\Poprd;
use App\Models\PoprdPlan;
use App\Models\Poprh;
use App\Models\Stkplan;
use App\Models\Stmas;
use App\Models\StmasPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditOrder extends Component
{
    use DateTimeHelpers, WithCachedRows, FunctionDateTimes, CashOrderDetails, DBLookups, Serials, WithPerPagePagination, WithFileUploads;

    public $orderId;
    public $dept_id;
    public $editing, $editingDetail, $podetail;
    public $deptShowModal = false;
    public $showPlanModal = false;
    public $showModalDirector = false;
    public $showModalStmass = false;
    public $showAdvSearchModal = false;
    public $showSearchModal = false;
    public $showDetailModal = false;
    public $showModalStmassPlan = false;
    public $reqdate;
    public $podetails;
    public $pod_id = null;
    public $detail_mode = '';
    public $delete_ids = [];
    public $mode = 'new';
    public $director_search;
    public $current_comtype = 1;
    public $docfile;
    public $searchObject = null;
    public $modal_title = '';
    public $current_id_name;
    public $stmas_id;

    protected $listeners = [
        'editOrder' => 'edit', 
        'set:reqdate' => 'setReqdate',
        'set:dept' => 'setDept', 
        'set:vendor' => 'setVendor', 
        'set:stkcode' => 'setStkcode',
        'set:doctype' => 'setDocument', 
        'save:order' => 'save',         
        'delete:detail' => 'delDetail',
        'close:detail' => 'closeDetail',
        'close:srcmodal' => 'closeSearchModal',
        'open:srcmodal' => 'openSearchModal',
        'open:srcplan:modal' => 'openSearchPlanModal',
        'open:stmasplan:modal' => 'openSearchStmassPlanModal',
        'close:stmasplan:modal' => 'closeSearchStmassPlanModal',
        'show:plan:modal' => 'openPlanModal',
        'close:plan:modal' => 'closePlanModal'
    ];

    public function openPlanModal($id)
    {
        $this->stmas_id = $id;
        $this->showPlanModal = true;
    }

    public function closePlanModal()
    {
        $this->stmas_id = null;
        $this->showPlanModal = false;
    }

    public function closeDetail()
    {
        $this->showDetailModal = false;
    }

    public function openSearchPlanModal()
    {
       $this->showModalStmassPlan = true; 
    }

    public function openSearchStmassPlanModal()
    {
        $this->showModalStmassPlan = true;
    }

    public function closeSearchStmassPlanModal()
    {
        $this->showModalStmassPlan = false;
    }

    public function openAdvSearchModal()
    {
        $this->showAdvSearchModal = true;
    }

    public function closeSearchModal()
    {
        $this->searchObject = null;
        $this->showSearchModal = false;
    }

    public function openSearchModal($component, $value)
    {
        if($component == 'search-modal.stmas') {
            return $this->showModalStmass = true;
        }

        $this->searchObject = $component;
        $this->current_id_name = $value;
        $this->showSearchModal = true;
    }

    public function setReqdate($val)
    {
        return $this->editing->reqdate = $val;
    }

    public function setDept($value)
    {
        $this->editing->dept_id = $value;
        $this->closeSearchModal();
    }

    public function setVendor($value)
    {
        $this->editing->vendors_id = $value;
        $this->closeSearchModal();
    }

    public function setStkcode($data)
    {
       /* if(count($data) == 0) {
            return $this->dispatchBrowserEvent('swal:error',[
                'text' => 'โปรดเลือกรายการที่ต้องการสินค้า'     
             ]);
        } 
        
        if($this->pod_id) { // Edit Mode
            foreach($data as $row) { 
                $plan_ids = json_decode($row['plan_ids']);
                PoprdPlan::where('poprd_id', $this->pod_id)->whereNotIn('stkplan_id', $plan_ids)->delete();
                $data = $this->packPlans($this->pod_id, $plan_ids);
                PoprdPlan::insert($data);
                $pod = Poprd::where('id', $this->pod_id)->first();
                $pod->qty = $row['pqty'];
                $pod->prc = $row['prc'];
                $pod->ttamt = $row['pqty'] * $row['prc'];
                $pod->save();
            }

            return $this->showPlanModal = false;
        }

        foreach($data as $row) { // New Mode
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
            PoprdPlan::insert($data);
        }
        
        $this->showPlanModal = false;*/
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

    public function setDocument($value)
    {
        $this->editing->doctypes_id = $value;
        $this->closeSearchModal();
    }

    public function makeBlankOrder()
    {
        $id = $this->getSerial('poid');
        $id = collect($id)->first()->id;

        return Poprh::make([
            "id"         => $id,
            "doch"       => 'PO',
            "reqdate"    => $this->getCurrentDate(),
            "detail"     => '',
            "dept_id"    => $this->dept_id,
            "inpln"      => 'Y',
            "res"        => '',
            "apv"        => false, //false = รออนุมัติ, true = อนุมัติ
            "order_send" => false,
            "fixqty"     => 'Y',
            "vendors_id"  => 0,
            "doctypes_id" => NULL,
            "note"       => '',
            "fixtm"      => 45,
            "create_by"  => auth()->user()->usercode,
            "dispos"     => '0.00',
            "amount"     => '0.00',
            "potype"     => '1',
            "qty"        => 0,
            "delflg"     => 'N',
            "order_send" => false,
            'flg'        => 'Q',
            'y'          => date('Y'),
            'mnt_id'     => 0,
        ]);
    }

    public function searchStmass()
    {
        $this->showModalStmass = true;
    }

    public function saveDetail()
    {
      /*  $this->editingDetail->ttamt = ($this->editingDetail->qty*$this->editingDetail->prc);
        $this->validate($this->detailRules(), [], $this->attributes());
        $this->editingDetail->save();
        $this->detail_mode = 'add';
        $this->editingDetail = $this->makeBlankDetail();*/

    }

    public function delDetail()
    {
        Poprd::where('id', $this->pod_id)->delete();
        PoprdPlan::where('poprd_id', $this->pod_id)->delete();
        $this->dispatchBrowserEvent('swal:success');
    }

    public function delDetailConfirm($no)
    {
        $this->pod_id = $no;

        $options = [
            'title' => 'โปรดยืนยันคำสั่ง', 
            'text' => 'ต้องการลบรายการนี้ใช่หรือไม่!', 
            'action' => 'delete:detail',
            'outside' => true,
        ];
        
        return $this->dispatchBrowserEvent('delete:confirm', $options);
    }

    public function updatededitingDetail($val, $name){
        if($name == 'dept_id') $this->search['dept_id'] = $val;
        else if($name == 'qty'){
            $this->editingDetail->ttamt = $val * $this->editingDetail->prc;
        }else if($name == 'price_for_editing'){
            $this->editingDetail->ttamt = $this->editingDetail->prc * $this->editingDetail->qty;
        }

    }

    public function updatedreqdate($value)
    {
        $this->editing->y = $this->getPlanYear($value);
    }

    public function updatedediting($val, $name){
        switch ($name) {
            case 'reqdate':
              break;
            default:
              return 0;
          }
      /*  if($name == 'mnt_id'){
            $this->editing->y = Mnyear::where('id', $val)->value('y');
        }*/
    }

    public function detailRules()
    {
        return [
            "editingDetail.poprh_id"          => 'required',
            "editingDetail.stkcode"           => 'required',
            "editingDetail.stkdes"            => 'required',
            "editingDetail.stkdes2"           => '',
            "editingDetail.qty"               => 'required',
            "editingDetail.prc"               => 'required',
            "editingDetail.ttamt"             => 'required',
            "editingDetail.units_id"          => 'required',
            "editingDetail.pln_qty"           => '',
            "editingDetail.plan_id"           => 'required',
            "editingDetail.dept_id"           => 'required',
            "editingDetail.recno"             => 'required',
            "editingDetail.no"                => 'required',
            "editingDetail.price_for_editing" => 'required',
        ];
    }

    public function masterRules()
    {
        return [
            "editing.id"                      => 'required',
            "editing.reqdate"                 => 'required',
            "editing.detail"                  => 'required',
            "editing.dept_id"                 => 'required',
            "editing.inpln"                   => 'required',
            "editing.res"                     => 'required',
            "editing.apv"                     => 'required',
            "editing.order_send"              => 'required',
            "editing.fixqty"                  => 'required',
            "editing.note"                    => '',
            "editing.fixtm"                   => 'required',
            "editing.create_by"               => 'required',
            "editing.amount"                  => 'required',
            "editing.dispos"                  => '',
            "editing.ttamt"                   => '',
            "editing.potype"                  => 'required',
            "editing.qty"                     => 'required',
            "editing.delflg"                  => 'required',
            "editing.order_send"              => 'required',
            "editing.reqdate_for_editing"     => '',
            "editing.doctypes_id"             => 'required',
            "editing.vendors_id"              => 'required',
            "editing.flg"                     => 'required',
            "editing.y"                       => 'required',
            "editing.mnt_id"                  => '',
        ];
    }

    public function rules()
    {
        return [
            "editing.id"                      => 'required',
            "editing.reqdate"                 => 'required',
            "editing.detail"                  => 'required',
            "editing.dept_id"                 => 'required',
            "editing.inpln"                   => 'required',
            "editing.res"                     => 'required',
            "editing.apv"                     => 'required',
            "editing.order_send"              => 'required',
            "editing.fixqty"                  => 'required',
            "editing.note"                    => '',
            "editing.fixtm"                   => 'required',
            "editing.create_by"               => 'required',
            "editing.ttamt"                   => '',
            "editing.dispos"                  => '',
            "editing.amount"                  => 'required',
            "editing.potype"                  => 'required',
            "editing.qty"                     => 'required',
            "editing.delflg"                  => 'required',
            "editing.order_send"              => 'required',
            "editing.reqdate_for_editing"     => '',
            "editing.doctypes_id"             => 'required',
            "editing.vendors_id"              => 'required',
            "editing.flg"                     => 'required',
            "editing.y"                       => 'required',
            "editing.mnt_id"                  => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'editing.res'         => 'เหตุผล',
            "editing.doctypes_id" => 'ประเภทเอกสาร',
            "editing.detail"      => 'รายละเอียด',
            "editing.vendors_id"  => 'ผู้ขาย',
            "editing.amount"  => 'ยอดรวม',
        ];
    }

    public function new()
    {
        $this->editing = Poprh::where("create_by", auth()->user()->id)->where('order_send', false)->first();
        
        if(!$this->editing)
        {
            $this->editing = $this->makeBlankOrder();
            $this->editing->save();
        }
        $this->reqdate = Carbon::parse($this->editing->reqdate)->format("d/m/Y");
        //$this->editing->reqdate_th =  $this->thai_date_short_number2(Carbon::parse($this->editing->reqdate));
        $this->podetails = Poprd::select('no', 'stkcode', 'stkdes', 'qty', 'prc', 'ttamt', 'units_id', 'plan_id')
            ->where('poprh_id', $this->editing->id)
            ->get();
        $this->search['dept_id'] = $this->editing->dept_id;
       // $this->editingDetail = $this->makeBlankDetail();
    }

    public function addDetail()
    {
        if(!$this->editing->doctypes_id) 
            return $this->dispatchBrowserEvent('swal:error',[
               'text' => 'โปรดเลือกประเภทเอกสาร'     
            ]);

        $this->pod_id = null;  
        $this->showDetailModal = true;
    }

    public function editDetail($id)
    {
        $this->pod_id = $id;

        $this->showDetailModal = true;
    }

    public function deleteDetail()
    {
        Poprd::whereIn('id', $this->delete_ids)->delete();
    }

    public function updateSummary()
    {
        $summary = Poprd::selectRaw("sum(ttamt) as ttamt, count(*) as cnt")->where('poprh_id', $this->editing->id)->first();
        $this->editing->amount = $summary->ttamt;
        $this->editing->dispos = 0;
        $this->editing->qty = $summary->cnt;
    }

    public function save()
    {
        /*$this->editing->doch = 'PO';
        $this->editing->order_send = true;
        $this->deleteDetail();
        $this->updateSummary();
*/
        $this->editing->update_by  = auth()->user()->usercode;
        $this->validate($this->masterRules(), [], $this->attributes());
        $saved = $this->editing->save();
        $saved = true;
        if($saved){
            $this->emit('confetti');
            $this->dispatchBrowserEvent('swal:success');
        }else{
            $this->dispatchBrowserEvent('swal:error');
        }
    }

    public function edit($id)
    {
        $this->orderId = $id;
        $this->editing = Poprh::find($id);
        //$this->editing->reqdate_th = $this->thai_date_short_number2(Carbon::parse($this->editing->reqdate));
    }

    public function mount($id)
    {
        $this->dept_id = auth()->user()->dept_id;

        if($id == 'new')
        {
            $this->new();
            $this->mode = 'new';
        }
        else{
            $this->edit($id);
            $this->mode = 'edit';
            $this->search['dept_id'] = $this->editing->dept_id;
        }

        $this->detail_mode = 'add';
    }

    /*public function edit($id)
    {
        $this->editingDetail = Poprd::where('id', $id)->first();
        $this->detail_mode = 'edit';
    }*/

    public function setEditingDetail($id){
        if(!$this->editingDetail){
            $this->editingDetail = $this->makeBlankDetail();
            $this->detail_mode = 'add';
        }

        if($this->editing->inpln == 'Y') {
            $stmas = StmasPlan::selectRaw("stkplan.id, stkplan.stkcode as stkcod, stkplan.stkdesc as stkdes,
                stkplan.prc as unitpr, stkplan.pqty as qty, stmas.pqucod")
                ->join('stmas', 'stmas.stkcod', 'stkplan.stkcode')
                ->where('stkplan.id', $id)->first();
        }
        else {
            $stmas = Stmas::where('id', $id)->where('status', 'A')->first();
        }

        $this->editingDetail->stkcode = $stmas->stkcod;
        $this->editingDetail->stkdes = $stmas->stkdes;

        if($this->editing->inpln == 'Y') {
            $this->editingDetail->plan_id = $stmas->id;
            $this->editingDetail->pln_qty = $stmas->pqty;
        }

        $this->editingDetail->qty = 1;
        $this->editingDetail->units_id = $stmas->pqucod;
        $this->editingDetail->prc = $stmas->unitpr;
        $this->editingDetail->ttamt = $this->editingDetail->qty * $this->editingDetail->prc;
    }


    public function getDetailRowsProperty()
    {
        return  Poprd::where('poprh_id', $this->editing->id)
            ->when($this->delete_ids,
                function($query, $ids){
                    return $query->whereNotIn('id', $ids);
                }
            )
            ->get();
    }

    public function getDirectorQueryProperty()
    {
        return Committ::query()
            ->when($this->director_search, function($query, $search){
                return $query->whereRaw("(gfname like '" . $search . "%')or(glname like '" . $search . "%')");
            });
    }

    public function getDirectorRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->director_query);
        });
    }

    public function render()
    {
        return view('order.edit', [
            'depts' => $this->dept_rows,
            'directors' => ($this->showModalDirector) ? $this->director_rows : [],
            'doctypes' => $this->doctype_rows,
            'stmass' => $this->stmas_rows,
            'monies' => $this->money_rows,
            'vendors' => $this->vendor_rows,
            'details' => $this->detail_rows,
        ]);
    }
}
