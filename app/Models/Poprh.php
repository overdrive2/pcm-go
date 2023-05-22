<?php

namespace App\Models;

use App\Helpers\FunctionDateTimes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poprh extends Model
{
    use HasFactory, FunctionDateTimes;

    protected $table = 'poprh';
    protected $fillable = ['id', 'dept_id', 'doc_ref', 'doch', 'mnt_id', 'reqdate', 'doctypes_id', 'vendors_id', 'pdate', 'ptime', 'amount', 'qty', 'paytm', 'rcpdate', 'trn_id', 'flg', 'potype', 'pnum', 'res', 'scop', 'balprc', 'fixtm', 'y', 'detail', 'prules_id', 'commit1', 'commit2', 'commit3', 'pcom1', 'pcom2', 'pcom3', 'vat', 'dispos', 'inpln', 'usercode', 'signame', 'py', 'pm', 'itmqty', 'qcqty', 'delflg', 'note', 'print_tr', 'print_po', 'mng', 'wqcqty', 'ttamt', 'delby', 'serv_id', 'stype', 'delcomment', 'no', 'res_prc', 'create_by', 'update_by', 'wday', 'wmon', 'wyear', 'project_no', 'fixqty', 'gf_mon', 'fg_prjcode', 'gf_po', 'gf_check', 'reqdate', 'apv', 'order_send'];
    protected $appends = ['reqdate_for_editing'];

    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';

    public function getReqdateForEditingAttribute()
    {
        return $this->thai_date_short_number2(Carbon::parse($this->reqdate));
    }

    public function setReqdateForEditingAttribute($value)
    {
        $this->reqdate = $this->thdate2YMD($value);
    }

    public function getDeptNameAttribute()
    {
        return Department::where('dept_id', $this->dept_id)->value('dept_name');
    }

    public function getDoctypeNameAttribute()
    {
        return Doctype::where('id', $this->doctypes_id)->value('docname');
    }

    public function getVendorNameAttribute()
    {
        return Vendor::where('id', $this->vendors_id)->selectRaw("concat(prenam, supnam) as name")->value('name');
    }
}
