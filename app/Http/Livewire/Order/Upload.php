<?php

namespace App\Http\Livewire\Order;

use App\Models\PoDocscan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Upload extends Component
{
    use WithFileUploads;

    public $file;
    public $order_id;
    public $docname = 'ใบเสนอราคา';
    public $scanType = 'PQ';
    public $selectedId;

    protected $listeners = [
        'delete:docsan' => 'delete'
    ];

    public function preview($url)
    {
        $exurl = explode(".", $url);
        return $exurl[1] == 'pdf' ? $this->redirect(route('poscan.preview', $url)) : 
            $this->dispatchBrowserEvent('modal:show', [
                'src' => route('poscan.preview', $url)
            ]);
    }

    public function deleteConfirm($id)
    {
        $this->selectedId = $id;

        $options = [
            'title' => 'โปรดยืนยันคำสั่ง', 
            'text' => 'ต้องการลบรายการนี้ใช่หรือไม่!', 
            'action' => 'delete:docsan',
            'outside' => true,
        ];
        
        return $this->dispatchBrowserEvent('delete:confirm', $options);
    }

    public function delete()
    {
        PoDocscan::where('id', $this->selectedId)->delete();
        $this->emitSelf('$refresh');
        $this->dispatchBrowserEvent('notice', ['type' => 'delete', 'text' => 'Item moved successfully.']);
    }

    public function updatedFile($value)
    {
        $this->validate([
            'file' => 'image|max:1024', // 1MB Max
        ]);

        $allowed =  array('gif','png' ,'jpg','pdf');

        if($value) {
            $path = $this->file->getRealPath();

            $ext = pathinfo($path, PATHINFO_EXTENSION);
            
            if(!in_array($ext, $allowed)) {
                $this->dispatchBrowserEvent('swal:error', [
                    'text' => "รูปแบบไฟล์ไม่ถูกต้อง ('gif','png' ,'jpg','pdf')"     
                ]);

                $this->emitSelf('$refresh');
            }

            $fp = fopen($path,"r");

            $ReadBinary = fread($fp,filesize($path));

            $FileData = pg_escape_bytea($ReadBinary);
            
            fclose($fp);
            
            $sql = sprintf("INSERT INTO po_docscans(docname, docfile, doctype_id, po_id, filetype, scantype, update_at) 
           		VALUES ('%s', '%s', %d, %d,  '%s', '%s', CURRENT_TIMESTAMP)", $this->docname, $FileData, 3, $this->order_id, $ext, 'PQ');
            DB::select($sql);

            $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => 'Item moved successfully.']);
        }
    }

    public function getRowsProperty()
    {
        return PoDocscan::selectRaw('id, docname, filetype, pg_size_pretty(pg_column_size(docfile)::numeric(11, 2)) as size')
            ->where('po_id', $this->order_id)
            ->where('scantype', $this->scanType)
            ->orderBy('id', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.order.upload', [
            'rows' => $this->rows
        ]);
    }
}
