<?php

namespace App\Http\Livewire;

use App\Models\TranferDetail;
use Livewire\Component;

class TransferDetails extends Component
{
    public $editing;
    public $transfer_id, $current_detail_id;
    public $showModalStmass = false;
    public $showGenerateModal = false;
    public $site;
    public $src_stkcode;

    protected $listeners = ['set:stkcode' => 'setStkCode'];

    public function rules()
    {
        return [
            'editing.id' => 'required',
            'editing.trhs_id' => 'required',
            'editing.stkcode' => 'required',
            'editing.stkdes' => 'required',
            'editing.qty' => 'required',
            'editing.unit' => 'required',
            'editing.prc' => 'required',
            'editing.ttamt' => 'required',
            'editing.remqty' => 'required',
            'editing.remamt' => 'required',
            'editing.ym' => 'required',
            'editing.lprc' => 'required',
            'editing.lotnum' => 'required',
            'editing.lotno' => 'required',
            'editing.lotref' => 'required',
            'editing.trntype' => 'required',
            'editing.site' => 'required',
            'editing.curqty' => 'required',
            'editing.expdate' => 'required',
            'editing.lst_trh_id' => 'required',
            'editing.lst_id' => 'required',
            'editing.curunit' => 'required',
            'editing.curprc' => 'required',
            'editing.unitqty' => 'required',
            'editing.stkget' => 'required',
            'editing.max_req' => 'required',
            'editing.ref_no' => 'required',
            'editing.ref_id' => 'required',
            'editing.wqty' => 'required',
            'editing.reqqty' => 'required',
            'editing.trdate' => 'required',
            'editing.trtime' => 'required',
        ];
    }

    public function mount()
    {

    }

    public function setStkCode($code)
    {

    }

    public function generate($id)
    {
        $this->current_detail_id = $id;
        $this->showGenerateModal = true;
    }

    public function showSearchModal()
    {
        return $this->showModalStmass = true;
    }

    public function getRowsProperty()
    {
        return TranferDetail::where('trhs_id',$this->transfer_id)->get();
    }

    public function render()
    {

        return view('livewire.transfer-details',[
            'details' => $this->rows,
        ]);
    }
}
