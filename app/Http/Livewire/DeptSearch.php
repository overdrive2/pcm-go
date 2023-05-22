<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Department;
use App\Models\UserDept;
use Livewire\Component;

class DeptSearch extends Component
{
    use WithCachedRows, WithPerPagePagination;
    public $search;
    public $action;
    public $owner = false;

    public function mount()
    {
        $this->perPage = 20;
    }

    public function getRowsProperty()
    {
        return $this->cache( function() {
                    return $this->applyPagination(
                            Department::where('enable', 'Y')
                                ->when($this->owner, function($query){
                                    $deptIds = UserDept::where('usercode', auth()->user()->usercode)->pluck('depts_id');
                                    return $query->whereIn('dept_id', $deptIds);
                                })
                                ->when($this->search, function($query) {
                                    return $query->where('dept_name', 'like', '%'.$this->search.'%');
                                })->orderBy('dept_name', 'asc')
                        );
                });
    }

    public function setDept($value)
    {
        $this->emit($this->action, $value);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.dept-search', [
            'rows' => $this->rows
        ]);
    }
}
