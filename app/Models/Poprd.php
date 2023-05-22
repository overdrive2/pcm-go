<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Poprd extends Model
{
    use HasFactory;

    protected $table ='poprd';
    protected $fillable = ['poprh_id', 'stmas_id', 'stkcode', 'stkdes', 'stkdes2', 'qty', 'prc', 'ttamt', 'units_id', 'plan_id', 'pln_qty', 'dept_id', 'recno', 'no'];
    public $incrementing = false;
    protected $appends = ['price_for_editing'];

    public function getUnitNameAttribute()
    {
        return Unit::where('id', $this->units_id)->value('ushname');
    }

    public function getPriceForEditingAttribute()
    {
        return number_format($this->prc,'2');
    }

    public function setPriceForEditingAttribute($value)
    {
        $value = str_replace(',', '', $value);
        return $this->prc = (float)$value;
    }

    public static function updatePoprh($model)
    {
        $lastdata = self::where('poprh_id', $model->poprh_id)->selectRaw("sum(ttamt), count(*)")->first();
        
        return Poprh::where('id', $model->poprh_id)->update([
            'amount' => $lastdata ? $lastdata->sum : 0,
            'qty' => $lastdata ? $lastdata->count : 0,
            'update_at' => DB::raw('CURRENT_TIMESTAMP'),
        ]);    
    }

    protected static function boot()
    {
        parent::boot();

        self::saved(function($model){
            self::updatePoprh($model);
        });

        self::deleted(function($model) {
            self::updatePoprh($model);
        });

    }

}
