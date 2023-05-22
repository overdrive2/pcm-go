<?php

namespace App\Http\Livewire\Object;

use Livewire\Component;
use App\Models\ObjectDetail;
use App\Models\ObjectDetailStatus;
use App\Models\TbOject;
use Carbon\Carbon;

class Detail extends Component
{
    public $user_id, $parent_id;
    public ObjectDetail $editing;
    public $mode = '';
    public $selectedId;
    public $object_number;
    public $pack_date;
    public $child;
    public $status = 'N';

    protected $listeners = [
        'set:object' => 'setObject',
        'delete:confirm' => 'delete',
    ];

    public function mount()
    {
        $this->user_id = auth()->user()->id;
    }

    public function rules()
    {
        return [        
            'editing.parent_id'=>'required',
            'editing.child_id'=>'required',
            'editing.pack_date'=>'required',
            'editing.status'=>'required',
            'editing.created_by'=>'required',
            'editing.updated_by'=>'required'
        ];
    }

    public function add()
    {
        $this->resetChild();
        $this->mode = 'new';
        $this->editing = $this->makeBlank();
        $this->pack_date = date("d/m/Y");
      //  $this->emit('open:srcmodal', 'search-modal.objects');
    }

    public function edit($id)
    {
        $this->editing = ObjectDetail::find($id);
        $this->pack_date = Carbon::parse($this->editing->pack_date)->format("d/m/Y");
        $this->child = $this->editing->child;
        $this->object_number =  $this->child->object_number;
        $this->mode = 'edit';
    }

    public function delete()
    {
        $obj = ObjectDetail::find($this->selectedId);
        $obj->delete();
    }

    public function cancel()
    {
        $this->mode = '';
        $this->resetChild();
    }

    public function resetChild()
    {
        $this->child = [];
        $this->object_number = '';
    }

    public function save()
    {
       // Carbon::parse(DateTime::createFromFormat('d/m/Y', $this->admit_date))->format("Y-m-d")
        $this->editing->pack_date = Carbon::createFromFormat('d/m/Y', $this->pack_date)->format('Y-m-d');
        $this->validate();
        $this->editing->save();
        $this->dispatchBrowserEvent('swal:success');
        $this->mode = '';
    }

    public function setObject($val)
    {
        $this->editing->child_id = $val;
        $this->child = $this->editing->child;
        $this->object_number =  $this->child->object_number;
        $this->emit('close:srcmodal');
    }

    public function makeBlank()
    {
        return ObjectDetail::make([
          'parent_id' => $this->parent_id,
          'pack_date' => date("d/m/Y"),
          'created_by' => $this->user_id,
          'updated_by' => $this->user_id, 
          'status' => 'N',
          'child_id' => null
        ]);
    }

    public function updatedObjectNumber($value)
    {
        $code = explode("-", $value);
        $child_id = count($code) == 2 ? TbOject::where('prefix', $code[0])->where('item_no', (int)$code[1])->value('id') : null;
        if($child_id) 
            $this->setObject($child_id);
        else {
            $this->resetChild();
        }
        //$this->child;
    }

    public function confirmDelete($id)
    {
        $this->selectedId = $id;
        $options = [
            'title' => 'โปรดยืนยันคำสั่ง', 
            'text' => 'ต้องการลบรายการนี้ใช่หรือไม่!', 
            'action' => 'delete:stkplan',
            'outside' => true,
        ];
        
        return $this->dispatchBrowserEvent('delete:confirm', $options);

    } 

    public function getRowsProperty()
    {
        return ObjectDetail::where('parent_id', $this->parent_id)->get();
    }

    public function render()
    {
        return view('livewire.object.detail', [
            'statuses' => ObjectDetailStatus::all(),
            'rows' => $this->rows
        ]);
    }
}
