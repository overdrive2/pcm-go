<?php

namespace App\Http\Livewire\Order;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\PoreqH;
use Carbon\Carbon;
use Livewire\Component;

class Show extends Component
{
    use WithCachedRows, WithPerPagePagination, DateTimeHelpers;

    public $editing;
    public $dept_id = '148';
    public $year;
    public $deleteId;
    public $search;

    protected $listeners = [
        'delete:order' => 'deleteOrder',
        'refresh:order' => '$refresh'
    ];

    public function deleteOrder()
    {
        PoreqH::where('id', $this->deleteId)->update(['delflg' => 'Y']);
        $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => 'Item moved successfully.']);
        $this->emit('refresh:order');
    }

    public function mount()
    {
        $date = $this->getCurrentDate();
        $y = Carbon::createFromFormat('Y-m-d', $date)->format('Y');
        $m = Carbon::createFromFormat('Y-m-d', $date)->format('m');
        $this->year = (int)$m > 9 ? $y + 1 : $y;
    }

    public function getRowsQueryProperty()
    {
        return PoreqH::query()
            ->where('delflg', 'N')
            ->when($this->dept_id, function($query) {
                return $query->where('dept_id', $this->dept_id);
            })
            ->when($this->search, function($query, $search) {
                return is_numeric($search) ? $query->where('id', (int)$search) : $query->where('title', 'like', '%'.$search.'%');
            })
            ->orderBy('create_at', 'desc');
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    } 

    public function deleteConfirm($id)
    {
        $this->deleteId = $id;
        $this->dispatchBrowserEvent('delete:confirm', ['action' => 'delete:order']);
    }

    public function render()
    {
        return view('livewire.order.show', [
            'rows' => $this->rows
        ]);
    }
}
