<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Itmtype;
use App\Models\Obj;
use App\Models\ObjectTran;
use Livewire\Component;

class ObjectTranDepts extends Component
{
    use WithCachedRows, WithPerPagePagination;

    public $parent_id = 2, $search, $itemtype, $current_id;

    protected $queryString = ['parent_id'];

    public function getAllProperty()
    {
        return Obj::join('itmtypes', 'itmtypes.id', 'objects.itmtype_id')
            ->where('itmtypes.ref_id', $this->parent_id)
            ->count();
    }

    public function getSumFromType($type)
    {
        $query = ObjectTran::selectRaw('count(distinct(object_trans.obj_id))')
            ->join('objects', 'objects.id', 'object_trans.obj_id')
            ->join('itmtypes', 'itmtypes.id', 'objects.itmtype_id')
            ->where('itmtypes.ref_id', $this->parent_id)
            ->where('object_trans.trn_status_id', $type)
            ->when($this->search, function($query, $search){
                return $query->whereRaw("object_trans.dept_id in (select dept_id from dept where dept_name like '%".$search."%')");
            })
            ->first();
        return $query->count ?? 0;

    }

    public function getRowsQueryProperty()
    {
        $query = ObjectTran::selectRaw('object_trans.dept_id, dept.dept_name, count(distinct(object_trans.obj_id))')
            ->join('objects', 'objects.id', 'object_trans.obj_id')
            ->join('itmtypes', 'itmtypes.id', 'objects.itmtype_id')
            ->join('dept', 'dept.dept_id', 'object_trans.dept_id')
            ->where('itmtypes.ref_id', $this->parent_id)
            ->where('object_trans.trn_status_id', 'O')
            ->when($this->current_id, function($query, $id){
                return $query->where('itmtypes.id', $id);
            })
            ->when($this->search, function($query, $search){
                return $query->where('dept.dept_name', 'like', '%'.$search.'%');
            })
            ->groupBy('object_trans.dept_id', 'dept.dept_name')
            ->orderBy('dept.dept_name');

        return $query;
    }

    public function getRowsCountProperty()
    {
        $query = ObjectTran::selectRaw('count(distinct(object_trans.obj_id))')
            ->join('objects', 'objects.id', 'object_trans.obj_id')
            ->join('itmtypes', 'itmtypes.id', 'objects.itmtype_id')
            ->join('dept', 'dept.dept_id', 'object_trans.dept_id')
            ->where('itmtypes.ref_id', $this->parent_id)
            ->where('object_trans.trn_status_id', 'O')
            ->when($this->current_id, function($query, $id){
                return $query->where('itmtypes.id', $id);
            })
            ->when($this->search, function($query, $search){
                return $query->where('dept.dept_name', 'like', '%'.$search.'%');
            });

        return $query->value('count');
    }

    public function getRowsItemtypesProperty()
    {
        return ObjectTran::selectRaw('itmtypes.id, itmtypes.iname, itmtypes.unit_name, count(distinct(object_trans.obj_id))')
            ->join('objects', 'objects.id', 'object_trans.obj_id')
            ->join('itmtypes', 'itmtypes.id', 'objects.itmtype_id')
            ->join('dept', 'dept.dept_id', 'object_trans.dept_id')
            ->where('itmtypes.ref_id', $this->parent_id)
            ->where('object_trans.trn_status_id', 'O')
            ->when($this->search, function($query, $search){
                return $query->where('dept.dept_name', 'like', '%'.$search.'%');
            })
            ->groupBy('itmtypes.id', 'itmtypes.iname', 'itmtypes.unit_name')
            ->orderBy('itmtypes.iname')->get();
    }

    public function mount()
    {
        $this->itemtype = Itmtype::where('id', $this->parent_id)->first();
        $this->perPage = 25;
       // $this->filters['parent_id'] = request()->input('parent_id') ? request()->input('parent_id') : null;
       // $this->itemtype_name = $this->filters['parent_id'] ? Itmtype::where('id', $this->filters['parent_id'])->value('iname') : '';
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.object-tran-depts', [
            'rows' => $this->rows,
            'total' => $this->rows_count,
            'itemtypes' => $this->rowsItemtypes,
            'all' => $this->all,
            'tran' => $this->getSumFromType('O'),
            'disc' => $this->getSumFromType('D'),
        ]);
    }
}
