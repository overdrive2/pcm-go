<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\StmasGroup;
use App\Models\StmasSubGroup;
use Illuminate\Support\Facades\Auth;

class StmasSubGroups extends Component
{
    use WithSorting, WithCachedRows, WithPerPagePagination;

    public $filters = [
        'search' => '',
        'group_id' => '',
    ];

    protected $queryString = ['sorts'];

    public function mount($id)
    {
        $this->filters['group_id'] = $id;
        $this->sortBy('id');
    }

    public function getRowsQueryProperty()
    {
        $query = StmasSubGroup::query()
            ->when(($this->filters['group_id'] != '*')&&($this->filters['group_id']), function($query){
                return $query->where('groups_id', $this->filters['group_id']);
            })
            ->when($this->filters['search'], function($query, $search){
                return $query->whereRaw("tname ilike '%".$search."%'");
            });

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rows_query);
        });
    }

    public function getGroupsProperty()
    {
        return StmasGroup::orderBy('id', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.stmas-sub-groups',    [
            'subgroups' => $this->rows,
            'groups' => $this->groups,
            'group_name' => StmasGroup::where('id', $this->filters['group_id'])->value('shname'),
        ]);
    }
}
