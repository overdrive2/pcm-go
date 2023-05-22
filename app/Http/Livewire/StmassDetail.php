<?php

namespace App\Http\Livewire;

use App\Models\TranferDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StmassDetail extends Component
{
    public $readyToLoad = false;
    public $loadData = false;
    public $stkcode = '';
    public $site = '';
    public $inQty = 0;
    public $outQty = 0;
    public $unit_name = '';

    public function loadDetail()
    {
        $this->readyToLoad = true;
    }

    public function getQty($type)
    {
        return TranferDetail::where('stkcode', $this->stkcode)
            ->where('site', $this->site)
            ->where('trntype', $type)
            ->sum('qty');
    }

    public function getTranDetailProperty()
    {
        return [
            'qty_in' => $this->getQty('I') ?? 0,
            'qty_out' => $this->getQty('O') ?? 0,
        ];
    }

    public function render()
    {
        return view('livewire.stmass-detail', [
            'details' => ($this->readyToLoad && $this->loadData) ? $this->tranDetail : [
                'qty_in' => 0,
                'qty_out' => 0,
            ]
        ]);
    }
}
