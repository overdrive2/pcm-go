<?php

namespace App\Http\Livewire\SearchModal;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Doctype;
use App\Models\UserDoctype;
use Livewire\Component;

class DocumentType extends Component
{
    use WithPerPagePagination;

    public $search;
    public $loadData = false;
    public $userId;

    public function mount()
    {
        $this->perPage = 15;
        $this->userId = auth()->user()->id;
    }

    public function getRowsQueryProperty()
    {
        return Doctype::query()
            ->whereIn('id', UserDoctype::where('user_id', $this->userId)->pluck('doctype_id'))
            ->when($this->search, function($query, $search){
                return $query->where('docname', 'like', '%'.$search.'%');
            });
    }

    public function getRowsProperty()
    {
        return $this->applyPagination($this->rowsQuery);
    }

    public function render()
    {
        return view('livewire.search-modal.document-type',[
            'rows' => $this->rows
        ]);
    }
}
