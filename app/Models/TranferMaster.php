<?php

namespace App\Models;

use App\Helpers\FunctionDateTimes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranferMaster extends Model
{
    use HasFactory, FunctionDateTimes;

    protected $table = "trhs";
    protected $fillable = ["id", "docnum", "trdate", "trtime", "dept_id", "doctype_id", "note", "site", "flg", "usercode", "trnnum", "itmqty", "amount", "trntype", "useflg", "qch_id", "conf", "conf_timestamp", "conf_user", "req_day", "tel", "reqby", "reqdate", "reqtime", "ref_id"];
    protected $appends = ['trdate_for_editing'];

    const CREATED_AT = "create_at";
    const UPDATED_AT = "update_at";

    public function getDepartmentAttribute()
    {
        if($this->trntype == 'O')
            return Department::where('dept_id', $this->dept_id)->value('dept_name');
        else
            return Vendor::where('id', $this->dept_id)->value('supnam');
    }

    public function getDetailCountAttribute()
    {
        return TranferDetail::where('trhs_id', $this->id)->count();
    }

    public function getTrdateForEditingAttribute()
    {
        return $this->thai_date_short_number2(Carbon::parse($this->trdate));
    }

    public function getDoctypeNameAttribute()
    {
        return Doctype::where('id', $this->doctype_id)->value('docname');
    }

    public function setTrdateForEditingAttribute($value)
    {
        $this->trdate = $this->thdate2YMD($value);
    }

}
