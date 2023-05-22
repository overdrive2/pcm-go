<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Itmtype;
use App\Models\TranferDetail;
use Livewire\Component;

class ObjectGenerator extends Component
{
    use WithSorting, WithCachedRows, WithPerPagePagination;

    public $filters = [
        'level' => '0'
    ];

    public $trh_id, $trd_id;
    public $item_type_id = null;

    public function getRowsQueryProperty()
    {
        $query = Itmtype::query()
            ->when(($this->filters['level'] != '*')&&($this->filters['level']), function($query){
                return $query->where('level', $this->filters['level']);
            });
        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rows_query);
        });
    }

    public function getTranDetailProperty()
    {
        return TranferDetail::where('trhs_id', $this->trh_id)->where('id', $this->trd_id)->first();
    }

    public function render()
    {
        return view('livewire.object-generator',[
            'tran_detail' => $this->tran_detail,
        ]);
    }
}
