<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\Traits\DBLookups;
use App\Models\Itmtype;
use App\Models\TbOject;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Objects extends Component
{
    use WithPerPagePagination, WithSorting, WithCachedRows, DBLookups;

    public $showEditModal = false;
    public $showAdvSearchModal = false;
    public $showPackageModal = false;
    public $showTransferModal = false;
    public $showSrcItmTypeModal = false;
    public $showSearchModal = false;
    public $showBrandModal = false;
    public $parentId;
    public $objectId, $item_no, $current_id;
    public $searchObject;
    public $editing;
    
    public $filters = [
        'parent_id' => null,
        'search' => '',
        'pay' => false,
        'site' => '03',
        'trh_id' => null,
        'trd_id' => null,
        'package' => null,
    ];

    public $trh_id, $trd_id;

    public $itemtype_name;

    protected $queryString = ['sorts'];

    protected $listeners = [
        'set:item-type' => 'setItemType', 
        'master:refresh' => '$refresh',
        'set:brand' => 'setBrand',
        'close:srcmodal' => 'closeSearchModal',
        'open:srcmodal' => 'openSearchModal'
    ];

    public function closeSearchModal()
    {
        $this->searchObject = null;
        $this->showSearchModal = false;
    }

    public function openSearchModal($component)
    {
        $this->searchObject = $component;
        $this->showSearchModal = true;
    }

    public function setBrand($val)
    {
        $this->editing->brn_id = $val;
        $this->showBrandModal = false;
    }

    public function setItemType($val, $prefix)
    {
        $this->editing->itmtype_id = $val;
        $this->editing->prefix = $prefix;
        $this->item_no = TbOject::where('itmtype_id', $val)->max('item_no') ?? 0 + 1;
        $this->item_no = str_pad($this->item_no, 5, '0', STR_PAD_LEFT);
        $this->showSrcItmTypeModal = false;
    }

    public function rules()
    {
        return [
            'editing.objname' => 'required',
            'editing.itmtype_id' => 'required',
            'editing.brn_id' => '',	
            'editing.sn' => '',
            'editing.trh_id' => '',
            'editing.trd_id' => '',
            'editing.buy_date' => '',
            'editing.exp_date' => '',
            'editing.item_no' => 'required',	
            'editing.eqcode' => '',	
            'editing.wy' => '',	
            'editing.wm'=> '',	
            'editing.wd'=> '',	
            'editing.model'=> '',	
            'editing.label'=> '',	
            'editing.price'=> '',	
            'editing.prefix'=> 'required',	
            'editing.parent_id'=> '',	
            'editing.ord'=> '',	
            'editing.ip_address'=> ''
        ];
    }

    public function new()
    {
        $this->showEditModal = true;
    }

    public function edit($id)
    {
        $this->editing = TbOject::find($id);
        $this->item_no = str_pad($this->editing->item_no, 5, '0', STR_PAD_LEFT);
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->editing->item_no = $this->item_no;
        $this->validate();
        $this->editing->save();
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('swal:success');
    }

    public function detail($id)
    {
        $this->objectId = $id;
        $this->showTransferModal = true;
    }

    public function searchItemType()
    {
        $this->showSrcItmTypeModal = true;
    }

    public function searchBrand()
    {
        $this->showBrandModal = true;
    }

    public function getRowsQueryProperty()
    {
        $query = TbOject::query()
            ->when($this->trh_id && $this->trd_id, function($query){
                return $query->whereRaw(sprintf("(trh_id = %d and  trd_id = %d)",
                    $this->trh_id,
                    $this->trd_id,
                ));
            })
            ->when($this->filters['parent_id'], function($query, $parent_id){
                $ids = Itmtype::where('parent_id', $parent_id)->pluck('id');
                return $query->whereIn('itmtype_id', $ids);
            })
            ->when($this->filters['pay'], function($query){
                $rows = DB::select(sprintf("select distinct(o.obj_id) as id from trds t inner join object_trans o on t.trhs_id=o.trh_id and o.trd_id = t.id
                where t.site='%s' and t.trntype='%s'", $this->filters['site'], 'O'));
                return $query->whereIn('id', collect($rows)->pluck('id'));
            })
            ->when($this->filters['package'], function($query) {
                $query->whereRaw('(select count(*) from objects o2 where o2.parent_id = objects.id) > 0');
            })
            ->when($this->filters['search'], function($query, $search) {
                if(filter_var($this->filters['search'], FILTER_VALIDATE_INT))
                    $cond = "id = " . $this->filters['search'];
                else {
                    $kw = explode('-', $search);
                    $cond = count($kw) > 1 ?
                        "(concat(prefix, '-', to_char(item_no, 'fm00000'))::varchar(50) ilike '".$search."%')"
                        :
                         "((objname ilike '".'%'.$search.'%'."')"
                        ."or(sn ilike '".'%'.$search.'%'."')"
                        ."or(label ilike '".'%'.$search.'%'."')"
                        ."or(eqcode ilike '".'%'.$search.'%'."'))";
                }
                return $query->whereRaw($cond);
            });

        return $query->orderBy('prefix', 'asc')->orderBy('item_no', 'asc');
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rows_query);
        });
    }

    public function makeBlank()
    {
        return TbOject::make();
    }

    public function mount()
    {
        $this->sortBy('id');
        $this->filters['parent_id'] = request()->input('parent_id') ? request()->input('parent_id') : null;
        $this->itemtype_name = $this->filters['parent_id'] ? Itmtype::where('id', $this->filters['parent_id'])->value('iname') : '';
        $this->editing = $this->makeBlank();
    }

    public function showPackage($id)
    {
        $this->showPackageModal = true;
        $this->parentId = $id;
    }

    public function render()
    {
        return view('livewire.objects',[
            'objects' => $this->rows,
        ]);
    }
}
