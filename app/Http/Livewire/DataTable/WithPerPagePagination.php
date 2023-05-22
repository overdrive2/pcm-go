<?php

namespace App\Http\Livewire\DataTable;

use Livewire\WithPagination;

trait WithPerPagePagination
{
    use WithPagination;

    public function paginationView()
    {
        return 'vendor.livewire.flowbite';
    }

    public $perPage = 15;

    public function mountWithPerPagePagination()
    {
        $this->perPage = session()->get('perPage', $this->perPage);
    }

    public function updatedPerPage($value)
    {
        session()->put('perPage', $value);
    }

    public function getTotal($query)
    {
        return $query->count();
    }

    public function applyPagination($query)
    {
        return $query->paginate($this->perPage);
    }
}
