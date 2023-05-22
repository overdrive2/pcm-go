<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\Traits\DBLookups;
use App\Models\Itmtype;
use Livewire\Component;

class ItemsTypeShow extends Component
{
    use WithSorting, WithCachedRows, WithPerPagePagination, DBLookups;

    public $filters = [
        'level' => null,
        'ref_id' => [],
    ];

    public Itmtype $editing;
    public $showEditModal = false;

    public function mount()
    {
        $this->sortBy('ord');
        //$this->filters['ref_id'] = array("0");
        $this->filters['ref_id'] = explode(',', (request()->input('ref_id') ?? '0'));
    }

    public function setRefId($id)
    {

    }

    public function rules()
    {
        return [
            'editing.iname'      => 'required',
            'editing.level'      => 'required',
            'editing.icon'       => '',
            'editing.ref_id'     => '',
            'editing.prefix'     => '',
            'editing.objcount'   => '',
            'editing.doctype_id' => '',
            'editing.label'      => '',
            'editing.ord'        => '',
            'editing.imgindex'   => '',
            'editing.parent_id'  => '',
        ];
    }

    public function makeBlankItemType()
    {
        return Itmtype::make([
                'iname'      => '',
                'level'      => '0',
                'icon'       => '',
                'ref_id'     => $this->filters['ref_id'][count($this->filters['ref_id'])-1],
                'prefix'     => '',
                'objcount'   => 0,
                'doctype_id' => null,
                'label'      => '',
                'ord'        => '',
                'imgindex'   => '0'
            ]);
    }

    public function getParentItemProperty()
    {
        return Itmtype::whereIn('id', $this->filters['ref_id'])->orderBy('level')->get();
    }

    public function getRowsQueryProperty()
    {
        $query = Itmtype::query()
            ->when($this->filters['level'] != null, function($query){
                return $query->where('level', $this->filters['level']);
            })
            ->when(count($this->filters['ref_id']) > 0, function($query){
                return $query->where('ref_id', $this->filters['ref_id'][count($this->filters['ref_id'])-1]);
            });
        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rows_query);
        });
    }

    public function new()
    {
        $this->showEditModal = true;
        $this->editing = $this->makeBlankItemType();
    }

    public function edit($id)
    {
        $this->editing = Itmtype::find($id);
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->editing->save();
        $this->dispatchBrowserEvent('swal:success');
        $this->showEditModal = false;
    }

    public function render()
    {
        return view('livewire.items-type-show',[
            'itemtypes' => $this->rows,
            'icons' => $this->icon_rows,
            'itemparents' => $this->parent_item,
        ]);
    }
}
