<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stkplan extends Model
{
    use HasFactory;

    protected $table = 'stkplan';

    protected $fillable = ['y',	'stkcode', 'stmas_id',	'pqty',	'bqty',	'dept',	'pamt',	'tax', 'stkdesc',	'q1',	'q2',	'q3',	'q4',	'creby',	'bamt',	'prc',	'unit',	'plntype',	'doctype_id', 'updby',	'no',	'note',	'resplan',	'last_prc',	'dep_req', 'conf',	'stkdesc2',	'from_dept', 'stkplan_master_id', 'approved'];

    public static function updateMaster($model)
    {
        $lastdata = self::where('stkplan_master_id', $model->stkplan_master_id)->selectRaw("sum(pamt) as amount, count(*) as qty")->first();
        return StkplanMaster::where('id', $model->stkplan_master_id)->update($lastdata->toArray());
    }

    protected static function boot()
    {
        parent::boot();

        self::saved(function($model){
            self::updateMaster($model);
        });

        self::deleted(function($model) {
            self::updateMaster($model);
        });

    }

    public function getCompleteAttribute()
    {
        $ssql = DB::select(sprintf("select sum(poprd.qty) as qty, sum(poprd.ttamt::numeric(12, 2))as total from poprd inner join poprh on poprh.id=poprd.poprh_id
            inner join qchs on qchs.po_id=poprh.id
            where poprd.plan_id=%d and qchs.conf='Y' and poprh.delflg='N'", $this->id));

        $data = collect($ssql)->first();

        return $data;
    }

    public function getWaitAttribute()
    {
        $ssql = DB::select(sprintf("select sum(poprd.qty) as qty, sum(poprd.ttamt::numeric(12, 2))as total from poprd inner join poprh on poprh.id=poprd.poprh_id
            where poprh.delflg='N' and poprd.plan_id=%d and (select count(*) from qchs where po_id = poprh.id) = 0", $this->id));

        $data = collect($ssql)->first();

        return $data;
    }

    public function getBlankAttribute()
    {
        $ssql = DB::select(sprintf("select %d - sum(poprd.qty) as qty, %d - sum(poprd.ttamt::numeric(12, 2))as total from poprd inner join poprh on poprh.id=poprd.poprh_id
        where poprd.plan_id=%d and (select count(*) from qchs where po_id = poprh.id) = 0",$this->pqty ?? 0, $this->pamt ?? 0, $this->id));
        $data = collect($ssql)->first();

        return $data;
    }

    public function getFromDeptNameAttribute()
    {
        return Department::where('dept_id', $this->from_dept)->value('dept_name');
    }

    public function getStmasNameAttribute()
    {
        return Stmas::where('stkcod', $this->stkcode)->value('stkdes');
    }

    public function getUnitNameAttribute()
    {
        $stmas = Stmas::select('pqucod')->where('stkcod', $this->stkcode)->first();
        return $stmas->unit_name;
    }

    public function getPlanRequest($dept, $year)
    {
        return PoreqH::selectRaw("sum(qty) as qty, sum(poreq_d.ttamt) as amount")
            ->join('poreq_d', 'poreq_d.poreq_id','poreq_h.id')
            ->where('dept_id', $dept)
            ->where('poreq_h.y', $year)
            ->where('stkcode', $this->stkcode)
            ->first();
    }

    public function getTransfer($site, $year)
    {

    }

    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';
}
