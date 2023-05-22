<?php

namespace App\Http\Livewire\SearchModal;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Doctype;
use Livewire\Component;
use App\Models\Stmas as Stkmas;
use App\Models\StmasGroup;

class Stmas extends Component
{
    use WithCachedRows, WithPerPagePagination;

    public $search, $doctype_id;

    public $loadData = false;

    public function getRowsQueryProperty()
    {
        return Stkmas::select('stkcod', 'stkdes')
            ->where('status', 'A')
            ->when($this->doctype_id, function($query) {
                return $query->whereRaw(sprintf("stkgrp in (select id from stkgrps where doctype_id=%d)", $this->doctype_id));
            })
            ->when($this->search, function($query, $search){
                return $query->whereRaw(sprintf("((stkcod like '%s')or(stkdes ilike '%s'))", $search.'%', '%'.$search.'%'));
            })->orderBy('stkcod');
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    }
 
    public function render()
    {
        return view('livewire.search-modal.stmas',[
            'rows' => $this->rows,
            'document' => $this->doctype_id ? Doctype::where('id', $this->doctype_id)->value('docname') : ''
        ]);
    }
}
