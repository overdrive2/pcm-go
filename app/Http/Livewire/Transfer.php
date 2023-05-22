<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Http\Livewire\Traits\DBLookups;
use App\Models\TranferMaster;
use Livewire\Component;

class Transfer extends Component
{
    use DateTimeHelpers, DBLookups;

    public $selectedId;
    public $editing;
    public $stkcode;

    public function rules()
    {
        return [
            'editing.trdate_for_editing' => 'required',
            'editing.docnum' => 'required',
            'editing.trdate' => 'required',
            'editing.trtime' => 'required',
            'editing.dept_id' => 'required',
            'editing.doctype_id' => 'required',
            'editing.note' => '',
            'editing.site' => 'required',
            'editing.flg' => 'required',
            'editing.usercode' => 'required',
            'editing.trnnum' => 'required',
            'editing.itmqty' => 'required',
            'editing.amount' => 'required',
            'editing.trntype' => 'required',
            'editing.useflg' => 'required',
            'editing.qch_id' => '',
            'editing.conf' => 'required',
            'editing.conf_timestamp' => '',
            'editing.conf_user' => '',
            'editing.req_day' => '',
            'editing.tel' => '',
            'editing.reqby' => '',
            'editing.reqdate' => '',
            'editing.reqtime' => '',
            'editing.ref_id' => '',
        ];
    }

    public function mount($id)
    {
        if($id != 'new') $this->edit($id);
        else $this->new();
        $this->stkcode = request()->input('stkcode') ? request()->input('stkcode') : '';
    }

    public function new()
    {
        $this->editing = $this->makeBlankTransfer();
    }

    public function edit($id)
    {
        $this->editing = TranferMaster::find($id);
    }

    public function makeBlankTransfer()
    {
        return TranferMaster::make([
            'docnum' => '62090010',
            'trdate' => $this->getCurrentDate(),
            'trtime' => $this->getCurrentTime(),
            'dept_id' => '0',
            'doctype_id' => null,
            'note' => '',
            'site' => '',
            'flg' => 'N',
            'usercode' => auth()->user()->usercode,
            'trnnum' => '',
            'itmqty' => 0,
            'amount' => 0,
            'trntype' => 'O',
            'useflg' => 'N',
            'qch_id' => NULL,
            'conf' => 'N',
            'conf_timestamp' => NULL,
            'conf_user' => NULL,
            'req_day' => NULL,
            'tel' => NULL,
            'reqby' => NULL,
            'reqdate' => NULL,
            'reqtime' => NULL,
            'ref_id' => 0
        ]);
    }

    public function render()
    {
        return view('livewire.transfer',[
            'depts' => $this->dept_rows,
            'sites' => $this->site_rows,
            'doctypes' => $this->doctype_rows,
        ])->layout('layouts.full');
    }
}
