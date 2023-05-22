<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\FunctionDateTimes;

class PoreqH extends Model
{
    use HasFactory, FunctionDateTimes;

    protected $table = 'poreq_h';

    protected $appends = ['date_for_editing', 'plan_for_editing'];

    protected $fillable = ['reqdate', 'title', 'dept_id', 'inplan', 'res', 'po_id', 'apv', 
        'apres', 'vendor_id', 'doctype_id', 'note', 'fixtm', 'create_by', 'ttamt', 'apprv_by', 
        'apprv_at', 'potype', 'phone', 'com1_id', 'com2_id', 'ref_num', 'ms_po_id', 'cmp', 'y', 
        'update_by', 'delflg', 'saved'];

    public function getReqDateThaiAttribute()
    {
        return $this->thai_date_short_number2(Carbon::parse($this->reqdate));
    }

    public function getDeptNameAttribute()
    {
        return Department::where('dept_id', $this->dept_id)->value('dept_name');
    }

    public function getQtyAttribute()
    {
        return PoreqD::where('poreq_id', $this->id)->count();
    }

    public function getCom1NameAttribute()
    {
        return Committ::where('id', $this->com1_id)->value('gname'); 
    }

    public function getCom2NameAttribute()
    {
        return Committ::where('id', $this->com2_id)->value('gname');
    }

    public function getDateForEditingAttribute()
    {
        return $this->thai_date_short_number2(Carbon::parse($this->reqdate));
    }

    public function setDateForEditingAttribute($value)
    {
        $this->reqdate = $this->thdate2YMD($value);
    }

    public function getPlanForEditingAttribute()
    {
        return $this->inplan == 'Y' ? true : false;
    }

    public function setPlanForEditingAttribute($value)
    {
        $this->inplan = $value ? 'Y':'N';
    }

    public function getPlanNameAttribute()
    {
        return $this->inplan == 'Y' ? 'ในแผน' : 'นอกแผน';
    }

    public function getCreateByNameAttribute()
    {
        return User::where('usercode', $this->create_by)->value('username');
    }

    public function getVendorNameAttribute()
    {
        return $this->vendor_id ? 
            Vendor::selectRaw("concat(prenam, ' ', supnam)::varchar(255) as fullname")->find($this->vendor_id)->fullname
            :
            '';
    }

    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';
}
