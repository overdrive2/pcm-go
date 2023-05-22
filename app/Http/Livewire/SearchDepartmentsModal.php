<?php

namespace App\Http\Livewire;

use App\Models\Department;
use Livewire\Component;

class SearchDepartmentsModal extends Component
{
    public $search;

    public function getRowsProperty()
    {
        return Department::where('enable', 'Y')
            ->when($this->search, function($query, $search) {
                return $query->where('dept_name', 'like', '%'.$search.'%');
            })->orderBy('dept_name', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.search-departments-modal',[
            'rows' => $this->rows,
        ]);
    }
}
