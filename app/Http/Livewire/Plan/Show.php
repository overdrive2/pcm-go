<?php

namespace App\Http\Livewire\Plan;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\Department;
use App\Models\Stkplan;
use App\Models\StkplanMaster;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Show extends Component
{
    use DateTimeHelpers, WithCachedRows, WithPerPagePagination;

    public $showEditModal = false;
    public $dept, $current_year, $usercode;
    public $action, $modalComponent;
    public $plan_date;
    public StkplanMaster $editing;
    public $view_mode = 'master';
    public $showSearchModal = false;
    public $current_model = '';
    public $search = '';
    public $site = '03';
    public $stkcode = '';
    public $showStmassModal;
    public $user, $modalName, $dept_search, $dept_search_name = '';
    public $unit;
    public $showPlanDetailModal = false;
    public $showSearchFromPlanModal = false;
    public $showSearchDoctype = false;
    public $showEditPlanModal = false;
    public $showSearchStmass = false;
    public $showStmasOrderModal = false;
    public $master_id, $master_id_from_delete;
    public $plan_id, $stmas_id;
    public $owner;

    protected $listeners = [
            'set:fromdept' => 'setFromDept',
            'set:todept' => 'setToDept',
            'set:srcdept' => 'setSearchDept',
            'open:search-form-plan-modal' => 'openSearchFormPlanModal', 
            'set:doctype' => 'setDoctype',
            'refresh:planmaster' => '$refresh',
            'delete:master-plan' => 'delete',
            'new:stkplan' => 'newPlan',
            'edit:stkplan' => 'editPlan',
            'confirm:delete:stkplan' => 'confirmDeletePlan',
            'delete:stkplan' => 'deletePlan',
            'show:stmass-search' => 'showSearchStmass',
            'close:modal' => 'closeModal'
        ];
    
    public function showStmasOrder($id)
    {
        $this->stmas_id = $id;
        $this->showStmasOrderModal = true;
    }

    public function closeModal($modal)
    {
        $this->{$modal} = false;
    }    

    public function showSearchStmass($dept_id)
    {
        $this->dept = $dept_id;
        $this->showSearchStmass = true;
    }

    public function editPlan($id)
    {
        $this->plan_id = $id;
        $this->showEditPlanModal = true;
    }

    public function newPlan()
    {
        $this->plan_id = null;
        $this->showEditPlanModal = true;
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

    public function openSearchFormPlanModal()
    {
        $this->showSearchFromPlanModal = true;
    }  
    
    public function openSearchDoctype()
    {
        $this->showSearchDoctype = true;
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

        $this->dispatchBrowserEvent('delete:master-plan');
    }

    public function setDoctype($id)
    {
        $this->editing->doctype_id = $id;
        $this->showSearchDoctype = false;
    }

    public function setSearchDept($value)
    {
        $this->dept_search = $value;
        $this->dept_search_name = Department::where('dept_id', $this->dept_search)->value('dept_name');
        $this->showSearchModal = false;
        $this->emit('refresh:planmaster');
    }
    
    public function showPlanDetail($id)
    {
        $this->master_id = $id;
        $this->showPlanDetailModal = true;
    }

    public function searchModal($component, $action, $owner)
    {
        $this->owner = $owner;
        $this->modalComponent = $component;
        $this->modalName = 
        $this->action = $action;
        $this->showSearchModal = true;
    }    

    public function detail($code, $unit)
    {
        $this->stkcode = $code;
        $this->unit = $unit;
        $this->showStmassModal = true;
    }

    public function updatedsearch()
    {
        $this->resetPage();
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

    public function mount()
    {
        $user = auth()->user();
        $this->dept = $user->dept_id;
        $this->usercode = $user->id;
        $years = $this->years->first();
        $this->current_year = intval(date('m')) < 9 ? ($years->y -1 ) : ($years->y);
        $this->editing = $this->makeBlankStkplanMaster();
        $this->perPage = 50;
    }

    public function new()
    {
        $this->editing = $this->makeBlankStkplanMaster();
        $this->plan_date = Carbon::parse($this->getCurrentDate())->format("d/m/Y");
        $this->showEditModal = true;
    }

    public function edit($id)
    {
        $this->editing = StkPlanMaster::find($id);
        $this->showEditModal = true;
    }

    public function save()
    {
        if(!$this->editing->plan_status)
            $this->editing->plan_status = 'W';   
        if(!$this->editing->delflg)
            $this->editing->delflg = false;   
        $this->validate();
        $this->editing->save();
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('swal:success');
    }

    public function getYearsProperty()
    {

       return collect(DB::select("select i as y, (i+543) as th from generate_series(date_part('year', CURRENT_DATE)::int-1, date_part('year', CURRENT_DATE)::int+1) i order by i desc;"));
        // return collect(DB::select(sprintf("select (y+543) as th, y from stkplan where dept= '%s' group by y order by y desc", $this->dept)));
    }

    public function getRowsQueryProperty()
    {
        $query = StkplanMaster::query()
            ->where('delflg', false)
            ->when($this->dept_search, function($query){
                return $query->where('from_dept_id', $this->dept_search);
            })
            ->when($this->dept, function($query, $dept){
                return $query->where('to_dept_id', $dept);
            })
            ->when($this->current_year, function($query, $year){
                return $query->where('y', $year);
            });

        return $query->orderBy('id');
    }

    public function getDetailsQueryProperty()
    {
        $query = Stkplan::selectRaw("id, stkplan.stkcode, stkplan.stkdesc, stkplan.pqty, stkplan.prc,stkplan.pamt, stkplan.unit, stkplan.from_dept,
            plan_in_progress.qty as inprg_qty, plan_in_progress.total as inprg_total,
            plan_complete.qty as comp_qty, plan_complete.total as comp_total, plan_wait_progress.qty as wait_qty, plan_wait_progress.total as wait_total")
            ->where('stkplan.y', $this->current_year)
            ->where('stkplan.delflg', false)
            ->leftJoin('plan_in_progress', function($join){
                $join->on('plan_in_progress.y', 'stkplan.y');
                $join->on('plan_in_progress.plan_id', 'stkplan.id');
            })
            ->leftJoin('plan_complete', function($join){
                $join->on('plan_complete.y', 'stkplan.y');
                $join->on('plan_complete.plan_id', 'stkplan.id');
            })
            ->leftJoin('plan_wait_progress', function($join){
                $join->on('plan_wait_progress.y', 'stkplan.y');
                $join->on('plan_wait_progress.plan_id', 'stkplan.id');
            })
            ->where('stkplan.dept', $this->dept)
            ->when($this->dept_search, function($query){
                return $query->where('from_dept', $this->dept_search);
            })
            ->when($this->search, function($query, $search){
                return $query->whereRaw(sprintf("((stkcode like '%s')or(stkdesc like '%s'))", $search.'%', '%'.$search.'%'));
            })->orderBy('stkcode');

        return $query;

    }

    public function getDetailsSummaryQueryProperty()
    {
        $query = Stkplan::select(
                DB::raw('sum(pqty) as pqty'), 
                DB::raw('sum(pamt) as pamt'), 
                DB::raw('sum(pqty - plan_wait_progress.qty) as curqty'),
                DB::raw('sum(pamt - plan_wait_progress.total) as curamt'),
                DB::raw('sum(plan_wait_progress.qty) as wqty'),
                DB::raw('sum(plan_wait_progress.total) as wamt'),
                DB::raw('sum(plan_in_progress.qty) as prgqty'),
                DB::raw('sum(plan_in_progress.total) as prgamt'),
                DB::raw('sum(plan_complete.qty) as compqty'),
                DB::raw('sum(plan_complete.total) as compamt')
            )
            ->where('stkplan.y', $this->current_year)
            ->where('stkplan.delflg', false)
            ->leftJoin('plan_in_progress', function($join){
                $join->on('plan_in_progress.y', 'stkplan.y');
                $join->on('plan_in_progress.plan_id', 'stkplan.id');
            })
            ->leftJoin('plan_complete', function($join){
                $join->on('plan_complete.y', 'stkplan.y');
                $join->on('plan_complete.plan_id', 'stkplan.id');
            })
            ->leftJoin('plan_wait_progress', function($join){
                $join->on('plan_wait_progress.y', 'stkplan.y');
                $join->on('plan_wait_progress.plan_id', 'stkplan.id');
            })
            ->where('stkplan.dept', $this->dept)
            ->when($this->dept_search, function($query){
                return $query->where('from_dept', $this->dept_search);
            })
            ->when($this->search, function($query, $search){
                return $query->whereRaw(sprintf("((stkcode like '%s')or(stkdesc like '%s'))", $search.'%', '%'.$search.'%'));
            });

        return $query->first();

    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function getRowsDetailProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->detailsQuery);
        });
    }

    public function render()
    {
        return view('livewire.plans-home', [
            'years' => $this->years,
            'rows' => ($this->view_mode == 'master') ? $this->rows : $this->rows_detail,
            'summary' => ($this->view_mode == 'master') ? [] : $this->DetailsSummaryQuery
        ]);
    }
}
