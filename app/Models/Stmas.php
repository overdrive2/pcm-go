<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stmas extends Model
{
    use HasFactory;

    protected $table = 'stmas';

    public function getUnitNameAttribute()
    {
        return Unit::where('id', $this->pqucod)->value('udesc');
    }

    public function getGroupNameAttribute()
    {
        return StmasGroup::where('id', $this->stkgrp)->value('shname');
    }

    public function getTypeNameAttribute()
    {
        return StmasSubGroup::where('id', $this->stksubgrp)->where('groups_id', $this->stkgrp)->value('tname');
    }

    public function getPlanQty($dept_id, $y)
    {
        return Stkplan::selectRaw("sum(pqty) as pqty, sum(pamt) as pamt")->where('stmas_id', $this->id)->where('y', $y)->where('dept', $dept_id)->first();
    }

    public function getPlanAmount($dept_id, $y)
    {
        return (!$dept_id || !$y ) ? 0 : Stkplan::where('stmas_id', $this->id)->where('y', $y)->where('dept', $dept_id)->sum('pamt');
    }

    public function getRequestQty($dept_id, $y, $plan)
    { 
        return 
            PoreqD::whereRaw(sprintf("poreq_id in (select id from poreq_h WHERE dept_id = '%s' and inplan='%s' and y = %d)", $dept_id, $plan, $y))
                ->where('stmas_id', $this->id)
                ->sum('qty');
    }

    public function getOrderQty($dept_id, $y, $plan)
    {
        return Poprd::whereRaw(sprintf("poprh_id in (select id from poprh where dept_id = '%s' and y=%d and inpln ='%s')", $dept_id, $y, $plan))
            ->where('stmas_id', $this->id)
            ->sum('qty');
    }

    public function getTranQty($site, $y, $trntype)
    {
        $sym = ($y-1).'10';
        $lym = $y.'09';
        $sdate = ($y-1).'-10-01';
        $ldate = $y.'-09-30';
        return TranferDetail::where('trntype', $trntype)
            ->whereBetween('ym', [$sym, $lym])
            ->whereRaw(sprintf("trhs_id in (select id from trhs where site = '%s' and trntype ='%s' and trdate between '%s' and '%s')", $site, $trntype, $sdate, $ldate))
            ->where('stmas_id', $this->id)
            ->sum('qty');
    }
}
