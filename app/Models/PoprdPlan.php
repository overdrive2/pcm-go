<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoprdPlan extends Model
{
    use HasFactory;

    protected $fillable = ['stkplan_id', 'poprd_id', 'qty'];

    public function getPlanAttribute()
    {
        return Stkplan::where('id', $this->stkplan_id)->first();
    }

    public static function updatePoprd($model)
    {
        $planIds = self::where('poprd_id', $model->poprd_id)->pluck('stkplan_id');

        Poprd::where('id', $model->poprd_id)->update([
            'qty' => Stkplan::whereIn('id', $planIds)->sum('pqty')
        ]);   
    }

    protected static function boot()
    {
        parent::boot();

        self::saved(function($model){
            self::updatePoprd($model);
        });

        self::deleted(function($model) {
            self::updatePoprd($model);
        });

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
