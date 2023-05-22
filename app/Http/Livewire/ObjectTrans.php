<?php

namespace App\Http\Livewire;

use App\Models\ObjectTran;
use App\Models\TbOject;
use Livewire\Component;

class ObjectTrans extends Component
{
    public $objectId;
    public $object;

    public function getRowsProperty()
    {
        return ObjectTran::where('obj_id', $this->objectId)
            ->orderBy('object_trans.trnstm', 'desc')
            ->get();    
    }

    public function getChildsProperty()
    {
        return ($this->object) ? TbOject::where('parent_id', $this->object->id)
            ->orderBy('ord', 'asc')->get() : [];
    }

    public function mount()
    {
        $this->object = TbOject::where('id', $this->objectId)->first();
    }

    public function render()
    {
        return view('livewire.object-trans',[
            'rows' => $this->rows,
            'childs' => $this->childs
        ]);
    }
}
