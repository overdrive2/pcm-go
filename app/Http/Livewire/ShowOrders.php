<?php

namespace App\Http\Livewire;

use App\Models\PoreqH;
use Livewire\Component;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Poprh;
use Illuminate\Support\Facades\Auth;

class ShowOrders extends Component
{
    use WithPerPagePagination, WithSorting, WithCachedRows;

    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $editingOrder = false;
    public $orderId = null;
    public Poprh $editing;
    public $search;

    protected $queryString = ['sorts'];

    protected $listeners = ['refreshOrders' => '$refresh'];

    public function edit($id)
    {
        $this->orderId = $id;
        $this->emit('editOrder', $id);
        $this->editingOrder = true;
    }

    public function getRowsQueryProperty()
    {
        $deptsId = json_decode(session()->get('dept_selected'));
        $query = Poprh::query()
                ->where('order_send', true)
                ->when(auth()->user()->status != 'A', function($query){
                    return $query->where('usercode', auth()->user()->usercode);
                })
                ->when($deptsId, function($query, $deptId){
                    return $query->whereIn('dept_id', $deptId);
                })
                ->when($this->search, function($query){
                    return $query->where('detail', 'like', '%'.$this->search.'%');
                })
                ->orderBy('id', 'desc');
        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function checkDept($id)
    {
        $selectedId = json_decode(session()->get('dept_selected'));

        if(in_array($id, $selectedId)){
            array_splice($selectedId, array_search($id, $selectedId ), 1);
        }else{
            array_push($selectedId, $id);
        }
        if(count($selectedId)>0)
            session()->put('dept_selected', json_encode($selectedId)) ;
    }

    public function mount()
    {
        $deptId = Auth::user()->depts->pluck('depts_id');
        session()->put('dept_selected', $deptId) ;
       // $this->sortBy('update_at');
        $this->sorts['update_at'] = 'desc';
    }

    public function getDrafCountProperty()
    {
        return Poprh::selectRaw("count(*)")->where("create_by", auth()->user()->id)->where('order_send', false)->value('count');
    }

    public function render()
    {
        return view('order.show',[
            'orders' => $this->rows,
            'draft' => $this->draf_count,
        ]);
    }
}
