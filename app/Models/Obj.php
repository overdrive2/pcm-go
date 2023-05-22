<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obj extends Model
{
    use HasFactory;

    protected $table = 'objects';

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
    ];

    public function getItemCountAttribute()
    {
        return Obj::where('parent_id', $this->id)->count();
    }

    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';
}
