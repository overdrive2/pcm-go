<?php

namespace App\Models;

use App\Http\Livewire\Traits\FunctionDateTimes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ObjectTran extends Model
{
    use HasFactory, FunctionDateTimes;

    protected $filable = ['trh_id',	'trd_id',	'obj_id',	'trnstm',	'dept_id',	'trn_status_id',	'detail',	'frm_trh_id',	'frm_trd_id',	'note',	'dept_to',	'date_to',	'create_by',	'update_by',	'delflg', 'obj_parent_id',	'username'];

    public function getDeptNameAttribute()
    {
        return Department::where('dept_id', $this->dept_id)->value('dept_name');
    }

    public function getTranDateTimeThaiAttribute()
    {
        return $this->thai_date_and_time_short(Carbon::parse($this->trnstm));
    }

    public function getAgeAttribute()
    {
        $data = collect(DB::select(sprintf("select age(current_date, '%s'::timestamp)", $this->trnstm)))->first();
        return $data->age;
    }

}
