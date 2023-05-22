<?php

namespace App\Models;

use App\Helpers\FunctionDateTimes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StkplanMaster extends Model
{
    use HasFactory, FunctionDateTimes;
    
    protected $appends = ['plan_date_for_editing'];

    protected $fillable = ['plan_date',	'y', 'from_dept_id',	'to_dept_id', 'qty',	'amount', 'note', 'title',	'created_by',	'updated_by', 'plan_status', 'doctype_id', 'delflg'];


    public function getFromDeptNameAttribute()
    {
        return Department::where('dept_id', $this->from_dept_id)->value('dept_name');
    }

    public function getToDeptNameAttribute()
    {
        return Department::where('dept_id', $this->to_dept_id)->value('dept_name');
    }

    public function getPlanDateForEditingAttribute()
    {
        return $this->thai_date_short_number2(Carbon::parse($this->plan_date));
    }

    public function setPlanDateForEditingAttribute($value)
    {
        $this->plan_date = $this->thdate2YMD($value);
    }

    public function getDateForHumanAttribute()
    {
        return $this->thai_date_short_number2(Carbon::parse($this->plan_date));
    }

    public function getDeptNameAttribute()
    {
        return Department::where('dept_id', '=', $this->dept_id)->value('dept_name');
    }

    public function getDoctypeNameAttribute()
    {
        return Doctype::where('id', $this->doctype_id)->value('docname');
    }

    public function getItemCountAttribute()
    {
        return Stkplan::where('stkplan_master_id', $this->id)->where('delflg', false)->count();
    }

}
