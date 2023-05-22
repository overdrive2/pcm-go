<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StmasSubGroup extends Model
{
    use HasFactory;

    protected $table = "stksubgrps";
    protected $keyType = "string";
    public $incrementing = false;

    public function getStmasCountAttribute()
    {
        return Stmas::where('stkgrp', $this->groups_id)->where('stksubgrp', $this->id)->count();
    }

    public function getGroupNameAttribute()
    {
        return StmasGroup::where('id', $this->groups_id)->value('flname');
    }

}
