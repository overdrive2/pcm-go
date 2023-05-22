<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use Illuminate\Support\Facades\Crypt;
use App\Models\Committ;
use App\Models\Pocom;
use Livewire\Component;

class PoCommittee extends Component
{
    use WithPerPagePagination, WithSorting, WithCachedRows;

    public $po_id, $comtype;
    public $comtype_name = ['กรรมการจัดซื้อ/จัดจ้าง', 'กรรมการตรวจรับ', 'กรรมการอื่น ๆ'];
    public $showModalDirector = false;
    public $director_search = '';
    public $editing;
    public $selected_id;

    /*protected $listeners = [
        'refreshPoCommitts' => '$refresh',
        'set:director' => 'setDirector',
        'delete:director' => 'deleteDirector',
    ];*/

    protected function getListeners()
    {
        return  
        [
            'refresh:director'.$this->comtype => '$refresh',
            'set:director'.$this->comtype => 'setDirector',
            'delete:director'.$this->comtype => 'deleteDirector',
        ];
            
    }

    public function setDirector($com_id)
    {
        $director = PoCom::where('po_id', $this->po_id)->where('com_id', $com_id)->where('comtype', $this->comtype)->first();
        
        if(!$director)
        {
            $committee = Committ::where('id', $com_id)->first();
            $pocom = PoCom::make([
                'comname' => $committee->gname,
                'posname' => $committee->position_name,
                'com_id' => $com_id,
                'po_id' => $this->po_id,
                'no' => PoCom::where('po_id', $this->po_id)->where('comtype', $this->comtype)->max('no')+1 ?? 1,
                'comtype' => $this->comtype,

                ]);
            $pocom->save();
        }

    }

    public function getRowsQueryProperty()
    {
        return Pocom::where('po_id', $this->po_id)
            ->where('comtype', $this->comtype)->orderBy('no', 'asc');
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function srcDirector()
    {
        $this->showModalDirector = true;
    }

    public function deleteConfirm($id)
    {
        $this->selected_id = $id;
        $options = [
            'title' => 'โปรดยืนยันคำสั่ง', 
            'text' => 'ต้องการลบรายการนี้ใช่หรือไม่!', 
            'action' => 'delete:director'.$this->comtype,
            'outside' => true,
        ];
 
        return $this->dispatchBrowserEvent('delete:confirm', $options);
       // $this->dispatchBrowserEvent('deleteConfirm("delele-product-form-39")');
    }
    
    public function deleteDirector()
    {
        $delected =  Pocom::where('id', Crypt::decrypt($this->selected_id))->delete();
       // $delected = true;
        if($delected) 
            return $this->dispatchBrowserEvent('swal:success');
        else 
            return $this->dispatchBrowserEvent('swal:error');
    }

    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.po-committee', [
            'committs' => $this->rows,
        ]);
    }
}
