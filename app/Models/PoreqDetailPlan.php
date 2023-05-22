<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoreqDetailPlan extends Model
{
    use HasFactory;
    
    protected $fillable = ['stkplan_id', 'poreq_d_uid', 'qty'];

    public function stkplan()
    {
        return Stkplan::find($this->stkplan_id);
    }
}
