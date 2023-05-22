<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\Traits\DBLookups;
use App\Models\StmasGroup;

class StmasGroups extends Component
{
    use WithPerPagePagination, WithSorting, WithCachedRows, DBLookups;

    public $editing;
    public $showEditModal = false;
    public $showSearchModal = false;
    public $searchObject = null;
    public $current_id_name;
    public $modal_title = '';

    public $filters = [
        'search' => '',
    ];

    protected $listeners = [
        'set:doctype' => 'setDocument', 
        'set:site' => 'setSite',       
        'close:srcmodal' => 'closeSearchModal',
        'open:srcmodal' => 'openSearchModal'
    ];

    protected $queryString = ['sorts'];

    public function closeSearchModal()
    {
        $this->searchObject = null;
        $this->showSearchModal = false;
    }

    public function openSearchModal($component, $value)
    {
        $this->searchObject = $component;
        $this->modal_title = config('component.'.$component);
        $this->current_id_name = $value;
        $this->showSearchModal = true;
    }


    public function getRowsQueryProperty()
    {
        $query = StmasGroup::query()
            ->when($this->filters['search'], function($query, $search) {
                $cond = "(shname ilike '".'%'.$search.'%'."')or(flname ilike '".'%'.$search.'%'."')or(id ilike '".$search.'%'."')";
                return $query->whereRaw($cond);
            })
            ->when((auth()->user()->status != 'A'), function($query) {
                return $query->whereIn('id', auth()->user()->group_ids);
            });

        return $this->applySorting($query);
    }

    public function rules()
    {
        return [
            'editing.id' => 'required',
            'editing.shname' => 'required', 
            'editing.flname' => 'required', 
            'editing.isoth' => '', 
            'editing.def_site' => '', 
            'editing.doctype_id' => 'required', 
            'editing.imidx' => '', 
            'editing.code_format' => '', 
            'editing.age_y' => '', 
            'editing.is_duty' => ''
        ];
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rows_query);
        });
    }

    public function makeBlank()
    {
        return StmasGroup::make();
    }

    public function edit($id)
    {
        $this->editing = StmasGroup::find($id);
        $this->showEditModal = true;
    }

    public function mount()
    {
        $this->sortBy('id');
        $this->editing = $this->makeBlank();
    }

    public function render()
    {
        return view('livewire.stmas-groups', [
            'stkgropus' => $this->rows,
        ]);
    }
}
