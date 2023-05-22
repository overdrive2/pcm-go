<?php

namespace App\Http\Livewire;

use App\Models\CpuStat;
use App\Models\Diskstat;
use Livewire\Component;

class Monitoring extends Component
{
    public $dataPoints;
    public $x;

    protected $listenners = [
        'refresh:data' => 'getCpuData'
    ];
    
    public function getCpuData()
    {
        $this->x = rand(1, 100);

        $rows = CpuStat::selectRaw("cpu_use, to_char(created_at::time, 'HH24:MI') as tm")
            ->whereRaw('created_at::date = CURRENT_DATE')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        $this->dataPoints = array();

        foreach($rows->reverse() as $row) {
            array_push($this->dataPoints, array("label"=> $row->tm, "y"=> $row->cpu_use));
        }
    }

    public function mount()
    {
        $this->getCpuData();
    }

    public function render()
    {
        return view('livewire.monitoring');
    }
}
