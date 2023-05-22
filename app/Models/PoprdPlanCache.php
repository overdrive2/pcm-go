<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoprdPlanCache extends Model
{
    use HasFactory;

    public function getPlanAttribute()
    {
        return Stkplan::where('id', $this->stkplan_id)->first();
    }

    public function getFromDeptNameAttribute()
    {
        $data = Stkplan::select('from_dept')->where('id', $this->stkplan_id)->first();
        return $data->from_dept_name;
    }

    public function getUnitNameAttribute()
    {
        return Stkplan::where('id', $this->stkplan_id)->value('unit');
    }

}
