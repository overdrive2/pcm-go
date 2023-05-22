<?php

namespace App\Models;

use App\Http\Livewire\Traits\FunctionDateTimes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TbOject extends Model
{
    use HasFactory, FunctionDateTimes;

    protected $table ='objects';

    protected $fillable = [
        'objname',
        'itmtype_id',
        'brn_id',
        'sn',
        'trh_id',
        'trd_id',
        'buy_date',
        'exp_date',
        'item_no',
        'eqcode',
        'wy',
        'wm',
        'wd',
        'model',
        'create_at',
        'update_at',
        'label',
        'price',
        'prefix',
        'parent_id',
        'ord',
        'ip_address',
        'cur_status',
        'last_status_time'
    ];

    public function getAgeAttribute()
    {
        $data = collect(DB::select(sprintf("select age(current_date, '%s'::date)", $this->buy_date)))->first();
        return $data->age;
    }

    public function getBrandNameAttribute()
    {
        return Brand::where('brandid', $this->brn_id)->value('brandname');
    }

    public function getObjectNumberAttribute()
    {
        return $this->prefix.'-'.str_pad($this->item_no, 5, '0', STR_PAD_LEFT);;
    }

    public function getItemCountAttribute()
    {
        return Obj::where('parent_id', $this->id)->count();
    }

    public function getItmtypeNameAttribute()
    {
        return Itmtype::where('id', $this->itmtype_id)->value('iname');
    }

    public function getTransCountAttribute()
    {
        return ObjectTran::where('obj_id', $this->id)->count();
    }

    public function getObjectTranAttribute()
    {
        return ObjectTran::where('obj_id', $this->id)
            ->orderBy('object_trans.trnstm', 'desc')
            ->first();
    }

    public function history()
    {
        return ObjectTran::where('obj_id', $this->id)
            ->orderBy('object_trans.trnstm', 'desc')
            ->get();   
    }

    public function getBuyDateThaiAttribute()
    {
        return $this->thai_date_fullmonth(Carbon::parse($this->buy_date));
    }

    public function getItmtypeAttribute()
    {
        return Itmtype::find($this->itmtype_id);
    }

    public function getIconAttribute()
    {
        return Itmtype::where('id', $this->itmtype_id)->value('icon');
    }

    public function getParentNumberAttribute()
    {
        return $this->parent_id ? TbOject::selectRaw("concat(prefix, '-',LPAD(item_no::text, 5, '0')) as number")->where('id', $this->parent_id)->value('number') : '-';
    }

    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';
}
