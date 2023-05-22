<?php

namespace App\Http\Livewire\Plan;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\Department;
use App\Models\Stkplan;
use App\Models\StkplanMaster;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Request extends Component
{
    use WithPerPagePagination, WithCachedRows, DateTimeHelpers, WithSorting;

    public $dept_search, $dept, $year, $current_year, $master_id, $master_id_from_delete; 
    public $showPlanDetail;
    public $showPlanDetailModal = false;
    public $showEditModal = false;
    public $usercode;
    public $plan_date;
    public $step = 1;
    public StkplanMaster $editing;
    public $plan_id;
    public $showEditPlanModal = false;
    public $showSearchDoctype = false;
    public $showSearchModal = false;
    public $showSearchStmass = false;
    public $owner, $modalComponent, $modalName, $action; 
    public $search = '';
    public $deptIds = [];

    protected $queryString = ['sorts'];

    protected $listeners = [
        'set:doctype' => 'setDoctype',
        'set:fromdept' => 'setFromDept',
        'set:todept' => 'setToDept',
        'new:stkplan' => 'newPlan',
        'edit:stkplan' => 'editPlan',
        'confirm:delete:stkplan' => 'confirmDeletePlan',
        'close:modal' => 'closeModal',
        'show:stmass-search' => 'showSearchStmass',
        'delete:master-plan' => 'delete',
        'delete:stkplan' => 'deletePlan',
    ];

    public function updateddeptIds()
    {
        $this->resetPage();
    }

    public function showSearchStmass($dept_id)
    {
        $this->dept = $dept_id;
        $this->showSearchStmass = true;
    }

    public function searchModal($component, $action, $owner)
    {
        $this->owner = $owner;
        $this->modalComponent = $component;
        $this->modalName = 
        $this->action = $action;
        $this->showSearchModal = true;
    } 

    public function setFromDept($value)
    {
        $this->editing->from_dept_id = $value;
        $this->showSearchModal = false;
    }

    public function setToDept($value)
    {
        $this->editing->to_dept_id = $value;
        $this->showSearchModal = false;
    }

    public function setDoctype($id)
    {
        $this->editing->doctype_id = $id;
        $this->showSearchDoctype = false;
    }


    public function closeModal($modal)
    {
        $this->{$modal} = false;
    }    

    public function openSearchDoctype()
    {
        $this->showSearchDoctype = true;
    }

    public function mount()
    {
        $user = auth()->user();
        $this->dept = $user->dept_id;
        $this->usercode = $user->id;
        $years = $this->years->first();
        $this->current_year = intval(date('m')) < 9 ? ($years->y -1 ) : ($years->y);
        $this->editing = $this->makeBlank();
        $this->sorts = ['id' => 'desc'];
        $this->dispatchBrowserEvent('alpine:init');
    }

    public function new()
    {
        $this->editing = $this->makeBlankStkplanMaster();
        $this->master_id = null;
        $this->plan_date = Carbon::parse($this->getCurrentDate())->format("d/m/Y");
        $this->showEditModal = true;
    }

    public function makeBlankStkplanMaster()
    {
        return StkplanMaster::make([
            'plan_date' => $this->getCurrentDate(),
            'y' => $this->current_year,
            'to_dept_id' => $this->dept,
            'qty' => 0,
            'amount' => 0,
            'created_by' => $this->usercode,
            'updated_by' => $this->usercode,
            'plan_status' => 'W',
            'delflg' => false
        ]);
    }

    public function newPlan()
    {
        $this->plan_id = null;
        $this->showEditPlanModal = true;
    }

    public function editPlan($id)
    {
        $this->plan_id = $id;
        $this->showEditPlanModal = true;
    }

    public function rules()
    {
        return [
            'editing.plan_date' => 'required',
            'editing.title' => 'required',
            'editing.note' => 'required',
            'editing.y' => 'required',
            'editing.from_dept_id' => 'required',
            'editing.to_dept_id' => 'required',
            'editing.qty' => 'required',
            'editing.amount' => 'required',
            'editing.created_by' => 'required',
            'editing.updated_by' => 'required',
            'editing.plan_date_for_editing' => 'required',
            'editing.plan_status' => 'required',
            'editing.doctype_id' => 'required',
            'editing.delflg' => 'required',
        ];
    }


    public function makeBlank()
    {
        return StkplanMaster::make([
            'plan_date' => $this->getCurrentDate(),
            'y' => $this->current_year,
            'to_dept_id' => $this->dept,
            'qty' => 0,
            'amount' => 0,
            'created_by' => $this->usercode,
            'updated_by' => $this->usercode,
            'plan_status' => 'W',
            'delflg' => false
        ]);
    }

    public function edit($id)
    {
        $this->editing = StkPlanMaster::find($id);
        $this->plan_date = Carbon::parse($this->editing->plan_date)->format("d/m/Y");
        $this->master_id = $this->editing->id;
        $this->showEditModal = true;
    }

    public function prev()
    {
        $this->step--;
    }

    public function next()
    {
        if($this->step == 1 && !$this->editing->id)
        {
            $this->validate();
            $this->editing->save();
            $this->master_id = $this->editing->id;
            $this->dispatchBrowserEvent('swal.toast');
        }

        $this->step++;
        /*if(!$this->editing->plan_status)
            $this->editing->plan_status = 'W';   
        if(!$this->editing->delflg)
            $this->editing->delflg = false;   
        $this->validate();
        $this->editing->save();
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('swal:success');*/
    }

    public function save()
    {
        $this->validate();
        $this->editing->save();
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('swal:success');
    }

    public function getRowsQueryProperty()
    {
        $query = StkplanMaster::query()
            ->where('delflg', false)
            ->where('to_dept_id', $this->dept)
            ->when($this->search, function($query){
                return $query->whereRaw(sprintf("((title ilike '%s')or(note ilike '%s'))", '%'.$this->search.'%', '%'.$this->search.'%'));
            })
            ->when(count($this->deptIds), function($query){
                return $query->whereIn('from_dept_id', $this->deptIds);
            })
            ->when($this->current_year, function($query, $year){
                return $query->where('y', $year);
            });

        return $this->applySorting($query);
    }
    
    public function showPlanDetail($id)
    {
        $this->master_id = $id;
        $this->editing = StkPlanMaster::find($this->master_id);
        $this->showPlanDetailModal = true;
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function ConfirmDeleteMasterPlan($id)
    {
        $this->master_id_from_delete = $id;

        $options = [
            'title' => 'โปรดยืนยันคำสั่ง', 
            'text' => 'ต้องการลบรายการนี้ใช่หรือไม่!', 
            'action' => 'delete:master-plan',
            'outside' => true,
        ];
    
        return $this->dispatchBrowserEvent('delete:confirm', $options);
    }

    public function delete()
    {
        StkplanMaster::where('id', $this->master_id_from_delete)->update([
            'delflg' => true
        ]);

        Stkplan::where('stkplan_master_id', $this->master_id_from_delete)->update([
            'delflg' => true
        ]);

        $this->dispatchBrowserEvent('swal:success');
    }

    public function confirmDeletePlan($id)
    {
        $this->plan_id = $id;
        
        $options = [
            'title' => 'โปรดยืนยันคำสั่ง', 
            'text' => 'ต้องการลบรายการนี้ใช่หรือไม่!', 
            'action' => 'delete:stkplan',
            'outside' => true,
        ];
        
        return $this->dispatchBrowserEvent('delete:confirm', $options);

    }  

    public function deletePlan()
    {
        Stkplan::where('id', $this->plan_id)
        ->update([
            'delflg' => true
        ]);
        $this->emit('refresh:stkplan');
        $this->dispatchBrowserEvent('refresh:planmaster');
    }

    public function getYearsProperty()
    {

       return collect(DB::select("select i as y, (i+543) as th from generate_series(date_part('year', CURRENT_DATE)::int-1, date_part('year', CURRENT_DATE)::int+1) i order by i desc;"));
    }

    public function getRowsDeptProperty()
    {
        $deptIds = StkplanMaster::query()
            ->where('delflg', false)
            ->where('to_dept_id', $this->dept)
            ->where('y', $this->current_year)
            ->groupBy('from_dept_id')
            ->pluck('from_dept_id');

        return Department::whereIn('dept_id', $deptIds)
            ->orderBy('dept_name', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.plan.request', [
            'rows' => $this->rows,
            'years' => $this->years,
            'depts' => $this->rowsDept
        ])->layout('layouts.index');
    }
}
