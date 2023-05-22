<?php

namespace App\Http\Livewire\Order;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Http\Livewire\Traits\Serials;
use App\Models\Doctype;
use App\Models\PoreqD;
use App\Models\PoreqH;
use App\Models\Stmas;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use DateTimeHelpers, WithCachedRows, WithFileUploads, Serials;

    public $editing;
    public $order_id, $detail_id, $stmas_id, $stmas_name, $usercode;
    public $showSearchVendor = false;
    public $showEditDetail = false;
    public $showStmasPlan = false;
    public $showOneStmasPlan = false;
    public $showCommittee = false;
    public $saveConfirmModal = false;
    public $comVar, $comId;

    protected $queryString = ['order_id' => ['except' => null, 'as' => 'id']];

    protected $listeners = [
        'search:stmasplan' => 'searchStmasPlan',
        'close:stmasplan' => 'closeStmasPlan',
        'search:one:stmasplan' => 'searchOneStmasPlan',
        'set:vendor' => 'setVendor',
        'set:commit' => 'setCommittee',
        'edit:detail' => 'editDetail',
        'new:detail' => 'newDetail',
        'close:detail' => 'closeDetailModal',
        'close:one:stmas' => 'closeOneStmasPlan'
    ];

    public function delCommitee($id)
    {
        if($id == '1')
          $this->editing->com1_id = null;
        elseif($id == '2')
          $this->editing->com2_id = null;      
    }

    public function srcComm($pos)
    {
        $this->comVar = 'com' . $pos . '_id';
        $this->comId = $pos == 1 ? $this->editing->com1_id : $this->editing->com2_id;
        $this->showCommittee = true;
    }

    public function setCommittee($value)
    {
        $this->editing->{$this->comVar} = $value;
        $this->showCommittee = false;
    }

    public function searchStmasPlan()
    {
        $this->showStmasPlan = true;
    }

    public function closeStmasPlan()
    {
        $this->showStmasPlan = false;
    }

    public function searchOneStmasPlan($value)
    {
        $this->stmas_id = $value;
        $this->stmas_name = Stmas::where('id', $this->stmas_id)->value('stkdes');
        $this->showOneStmasPlan = true;
    }

    public function closeOneStmasPlan()
    {
        $this->showOneStmasPlan = false;
    }

    public function setVendor($value)
    {
        $this->editing->vendor_id = $value;
        $this->showSearchVendor = false;
    }

    public function editDetail($id)
    {
        $this->detail_id = $id;
        $this->showEditDetail = true;
    }

    public function newDetail()
    {
        $this->detail_id = null;
        $this->showEditDetail = true;
    }    

    public function closeDetailModal()
    {
        $this->detail_id = null;
        $this->showEditDetail = false;
    }

    public function rules()
    {
        return [
            'editing.date_for_editing' => 'required',
            'editing.reqdate' => 'required',
            'editing.title' => 'required',
            'editing.dept_id' => 'required',
            'editing.inplan' => 'required',
            'editing.plan_for_editing' => 'required',
            'editing.res' => 'required',
            'editing.apv' => 'required',
            'editing.apres' => '',
            'editing.vendor_id' => 'required',
            'editing.doctype_id' => 'required',
            'editing.note' => '',
            'editing.fixtm' => 'required',
            'editing.create_by' => 'required',
            'editing.ttamt' => 'required',
            'editing.potype' => 'required',
            'editing.phone' => 'required',
            'editing.com1_id' => 'required',
            'editing.com2_id' => '',
            'editing.ref_num' => '',
            'editing.cmp' => 'required',
            'editing.update_by' => 'required',
            'editing.delflg' => 'required',
            'editing.y' => ''
        ];
    }

    public function mount()
    {
        $this->usercode = auth()->user()->usercode;

        if($this->order_id)
            return $this->editing = PoreqH::find($this->order_id);

        $this->editing = PoreqH::where('create_by', $this->usercode)
            ->where('saved', false)
            ->first();

        if(!$this->editing)
            $this->editing = $this->makeBlank();
  
    }

    public function makeBlank()
    {
        $user = auth()->user();

        $poreq = PoreqH::make([
            'title' => '-',
            'dept_id' => $user->dept_id,
            'inplan' => 'Y',
            'reqdate' => $this->getCurrentDate(),
            'saved' => false,
            'create_by' => $user->usercode
        ]);

        $poreq->save();

        return $poreq;
    }

    public function saveConfirm()
    {
        $this->editing->ttamt = PoreqD::where('poreq_id', $this->editing->id)->sum('ttamt');
        $this->saveConfirmModal = true;
    }

    public function save()
    {
        if(PoreqD::where('poreq_id', $this->editing->id)->count() == 0)
            return $this->dispatchBrowserEvent('swal:error', ['text' => 'ไม่มีรายการในใบคำขอนี้ !']);
        $this->editing->update_by = $this->usercode;
        $this->validate();
        $this->editing->save();
        $this->saveConfirmModal = false;
        $this->dispatchBrowserEvent('swal:success');
    }

    public function getDocumentsProperty()
    {
        return $this->cache(function () {
            $user = auth()->user();
            return Doctype::whereIn('id', $user->documents()->pluck('doctype_id'))->get();
        });
    }

    public function render()
    {
        return view('livewire.order.form', [
            'documents' => $this->documents
        ]);
    }
}
