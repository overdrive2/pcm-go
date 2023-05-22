<?php

namespace App\Http\Livewire\Order;

use App\Models\PoprdPlan;
use App\Models\PoreqD;
use App\Models\PoreqDetailPlan;
use App\Models\PoreqH;
use App\Models\Stmas;
use Livewire\Component;

class Detail extends Component
{
    public $order_id;
    public $delId;

    protected $listeners = [
        'refresh:detail:table' => '$refresh',
        'delete:detail' => 'delete'
    ];

    public function add()
    {
        $this->emit('new:detail');
    }

    public function delete()
    {
        PoreqD::where('uid', $this->delId)->delete();
        PoreqDetailPlan::where('poreq_d_uid', $this->delId)->delete();
        $this->emitSelf('$refresh');
        return $this->dispatchBrowserEvent('swal:success');
    }

    public function deleteConfirm($id)
    {
        $this->delId = $id;

        $options = [
            'title' => 'โปรดยืนยันคำสั่ง', 
            'text' => 'ต้องการลบรายการนี้ใช่หรือไม่!', 
            'action' => 'delete:detail',
            'outside' => true,
        ];
        
        return $this->dispatchBrowserEvent('delete:confirm', $options);
    }

    public function getRowsProperty()
    {
        return PoreqD::where('poreq_id', $this->order_id)->get();
    }

    public function render()
    {
        return view('livewire.order.detail',[
            'rows' => $this->rows
        ]);
    }
}
