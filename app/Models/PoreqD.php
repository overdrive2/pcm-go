<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoreqD extends Model
{
    use HasFactory;

    protected $table = 'poreq_d';
    
    protected $primaryKey = 'uid';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['poreq_id',	'stmas_id',	'stkcode',	'stkdes',	'qty',	'unit_id',	'prc',	'ttamt',	'lastprc',	'plan_id',	'plan_no',	'plnqty', 'uid'];
    protected $appends = ['price_for_editing', 'ttamt_for_editing'];

    public function getUnitNameAttribute()
    {
        return Unit::where('id', $this->unit_id)->value('ushname');
    }

    public function getPriceForEditingAttribute()
    {
        return number_format($this->prc, 2);
    }

    public function setPriceForEditingAttribute($value)
    {
        $value = str_replace(',', '', $value);
        return $this->prc = (float)$value;
    }

    public function getTtamtForEditingAttribute()
    {
        return number_format($this->ttamt, 2);
    }

    public function setTtamtForEditingAttribute($value)
    {
        $value = str_replace(',', '', $value ?? '0');
        return $this->ttamt = (float)$value;
    }
}
