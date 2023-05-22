<?php

namespace App\Http\Livewire;

use App\Models\PoDocscan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PoDocuments extends Component
{
    use WithFileUploads;

    public $po_id;
    public $showModalUpload = false;
    public $editing;
    public $file;
    public $selected_id;

    protected $listeners = [
        'delete:docscan' => 'delete',
    ];
    
    public function rules()
    {
        return [
            'editing.docname'    => 'required',
            'editing.docfile'    => '',
            'editing.doctype_id' => 'required',
            'editing.po_id'      => 'required',
            'editing.filetype'   => 'required',
            'editing.scantype'   => 'required',
            'editing.filepath'   => 'required',
        ];
    }

    public function makeBlankPoDocscan()
    {
        return PoDocscan::make([
            'docname' => '',
            'doctype_id' => 1,
            'po_id' => $this->po_id,
            'filetype' => '',
            'scantype' => 'PQ',
        ]);
    }

    public function uploadModal()
    {
        $this->dispatchBrowserEvent('file-pond-clear', ['id' => $this->id]);
        $this->showModalUpload = true;
    }

    public function mount()
    {
        $this->editing = $this->makeBlankPoDocscan();    
    }

    public function save()
    {
        if (!$this->file)
            return $this->dispatchBrowserEvent('swal:error');

       // $path       =   $this->file->getRealPath();
       // $content    =   file_get_contents($path);
       // $imgdta = base64_encode($content);
       // $img = fopen($path, 'r') or die("cannot read image\n");
       // $data = fread($img, filesize($path));
       // $imgdta = pg_escape_string(bin2hex($data));
        $storage = $this->file->store('public/documents');
        $this->editing->docname;
        $this->editing->filetype = $this->file->getClientOriginalExtension();
        $this->editing->filepath = basename($storage);
        $this->validate();
        $this->editing->save();

      /* DB::select('SET bytea_output = "escape"');
        $query = "INSERT INTO po_docscans(docname, docfile, doctype_id, po_id, filetype, scantype)";
        $query .= "values('".$this->editing->docname."', encode('".$content."', 'base64'), ".$this->editing->doctype_id.", ".$this->editing->po_id;
        $query .= ",'".$this->file->getClientOriginalExtension()."', 'PQ')";
      //  $inserted = DB::insert($query);
        dd($imgdta);
        if($inserted)
        {
            $tmpFilePath = 'livewire-tmp/'.$this->file->getFilename();
            Storage::disk('local')->delete($tmpFilePath);

            $this->showModalUpload = false;
        }    
        else*/
        $this->showModalUpload = false;
        $this->dispatchBrowserEvent('swal:success');

    }

    public function deleteConfirm($id)
    {
        $this->selected_id = $id;
        $options = [
            'title' => 'โปรดยืนยันคำสั่ง', 
            'text' => 'ต้องการลบรายการนี้ใช่หรือไม่!', 
            'action' => 'delete:docscan',
            'outside' => true,
        ];
 
        return $this->dispatchBrowserEvent('delete:confirm', $options);
       // $this->dispatchBrowserEvent('deleteConfirm("delele-product-form-39")');
    }

    public function showImage($docId)
    {
        $pod = PoDocscan::find($docId);
        $this->dispatchBrowserEvent('modal:show', [
            'src' => asset('storage/documents/'.$pod->filepath)
        ]);
    }

    public function delete()
    {
        return PoDocscan::where('id', Crypt::decrypt($this->selected_id))->delete();
    }

    public function getRowsProperty()
    {
        return PoDocscan::selectRaw('po_docscans.id, po_docscans.docname, po_docscans.filetype, mn_docscantypes.doctypename')
            ->join('mn_docscantypes', 'mn_docscantypes.id', 'po_docscans.doctype_id')
            ->where('po_docscans.po_id', $this->po_id)
            ->orderBy('po_docscans.id', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.po-documents', ['docscans' => $this->rows]);
    }
}
