<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Models\Department;
use App\Models\Doctype;
use App\Models\User;
use App\Models\UserDept;
use App\Models\UserDoctype;
use App\Models\UserStatus;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class ShowUsers extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;
    
    protected $queryString = ['sorts'];

    public $showEditModal = false;
    public $showDeptModal = false;
    public $editing;
    public $selected_id, $selected_dept_id = null;
    public $doctypeSelected = [];
    public $dept_search = null;
    public $filters = [
        'search' => '',
    ];
    protected $listeners = [
        'delete:user' => 'delete',
    ];

    public function mount()
    {
        $this->perPage = 10;
    }

    public function makeBlankUser()
    {
        return User::make([
            'usercode' => '',
            'password' => '',
            'username' => '',
            'dept_id' => '',
            'active' => true,
            'status' => 'U',
        ]);
    }

    public function rules()
    {
        return [
            'editing.usercode' => 'required',
            'editing.password' => 'required',
            'editing.username' => 'required',
            'editing.dept_id' => 'required',
            'editing.active' => 'required',
            'editing.status' => 'required',
        ];
    }

    public function new()
    {
        $this->editing = $this->makeBlankUser();
    }

    public function edit($id)
    {
        $this->selected_id = $id;
        $this->editing = User::find($id);
        $this->doctypeSelected = UserDoctype::where('user_id', $id)->pluck('doctype_id');
        $this->showEditModal = true;
    }

    public function save()
    {
        // Clear UnSelected 
        UserDoctype::where('user_id', $this->selected_id)->whereNotIn('doctype_id', $this->doctypeSelected)->delete();

        // Add new Selected
        foreach($this->doctypeSelected as $docid) {
            $olddocs = UserDoctype::where('user_id', $this->selected_id)->pluck('doctype_id')->toArray();
            
            if (!in_array($docid, $olddocs)) {
                UserDoctype::create([
                    'doctype_id' => $docid,
                    'user_id' => $this->selected_id,
                    'usercode' => User::where('id', $this->selected_id)->value('usercode')
                ]);
            }
        }

        $this->dispatchBrowserEvent('swal:success');
        $this->showEditModal = false;
    }

    public function delete()
    {
        $this->dispatchBrowserEvent('swal:success');
    }

    public function deleteConfirm($id)
    {
        $this->selected_id = Crypt::decrypt($id);
            
        $options = [
            'title' => 'โปรดยืนยันคำสั่ง', 
            'text' => 'ต้องการลบรายการนี้ใช่หรือไม่!', 
            'action' => 'delete:user',
            'outside' => true,
        ];
 
        $this->dispatchBrowserEvent('delete:confirm', $options);
       // $this->dispatchBrowserEvent('deleteConfirm("delele-product-form-39")');
    }

    public function deleteDeptConfirm($id)
    {
        $this->selected_dept_id = $id;
    }

    public function addDept($id)
    {
        UserDept::make([
            "usercode" => $this->editing->usercode, 
            "depts_id" => $id,
            "user_id" => $this->editing->id
        ])->save();
    }

    public function deleteDept()
    {
        if(UserDept::find($this->selected_dept_id)->delete()){
            $this->selected_dept_id = null;
        } 
    }

    public function getRowsQueryProperty()
    {
        $query = User::query()
            ->when($this->filters['search'], function($query ,$search){
                return $query->where('username', 'like', '%'.$search.'%');
            });   
        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
       // dd($this->rowsQuery->get());
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function getDeptRowsProperty()
    {
        if($this->showDeptModal)
            return $this->cache(function(){
                return Department::where('enable', 'Y')
                    ->when($this->dept_search, function($query, $search){
                        return $query->whereRaw("((dept_name like '%".$search."%')or(dept_id = '".$search."'))");
                    })->orderBy('dept_name', 'asc')->paginate(15);
            });
        else
            return [];    
    }

    public function getDeptUserRowsProperty()
    {
        if($this->showEditModal)
            return $this->cache(function(){
                return UserDept::where('user_id', $this->editing->id)->get();
            });
        else
            return [];    
    }

    public function render()
    {
        return view('user.show',[
            'users' => $this->rows,
            'statuses' => UserStatus::all(),
            'depts' => $this->dept_rows,
            'dept_users' => $this->dept_user_rows,
            'doctypes' => Doctype::orderBy('docname', 'asc')->get()
        ]);
    }
}
