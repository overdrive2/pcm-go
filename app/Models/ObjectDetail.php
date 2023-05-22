<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ObjectDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id' ,
        'child_id' ,
        'pack_date' ,
        'status',
        'created_by',
        'updated_by'
    ];

    public function getChildAttribute()
    {
        return $this->child_id ? TbOject::find($this->child_id) : [];
    }

    public function getStatusNameAttribute()
    {
        return ObjectDetailStatus::where('id', $this->status)->value('obstatus');
    }

    public static function updateObject($model)
    {
        $lastdata = self::where('child_id', $model->child_id)->orderByRaw('pack_date desc, created_at desc')->first();
        
        return TbOject::where('id', $model->child_id)->update([
            'parent_id' => $lastdata ? $lastdata->parent_id : 0,
            'cur_status' => $lastdata ? $lastdata->status : 'N',
            'last_status_time' => DB::raw('CURRENT_TIMESTAMP'),
        ]);    
    }

    protected static function boot()
    {
        parent::boot();

        self::saved(function($model){
            self::updateObject($model);
        });

        self::deleted(function($model) {
            self::updateObject($model);
        });

    }
}
