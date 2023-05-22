<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\Traits\DBLookups;
use App\Models\Itmtype;
use Livewire\Component;

class ObjectTypesMenu extends Component
{
    use WithSorting, WithCachedRows, WithPerPagePagination, DBLookups;

    public $filters = [
        'search' => '',
        'level' => 0,
        'ref_id' => [],
    ];

    protected $queryString = ['sorts'];

    public function mount()
    {
        $this->sortBy('ord');
        $this->filters['level'] = 0;
    }

    public function getRowsQueryProperty()
    {
        $query = Itmtype::where('level', '0')
            ->when(!$this->filters['ref_id'], function($query){
                return $query->where('level', $this->filters['level']);
            })
            ->when($this->filters['search'], function($query, $search){
                return $query->where('iname', 'ilike', $search.'%');
            });
        return $query->orderBy('ord', 'asc');
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->rows_query->get();
        });
    }

    public function render()
    {
        return view('livewire.object-types-menu',[
            'itemtypes' => $this->rows,
            'icons' => $this->icon_rows,
        ]);
    }
}
