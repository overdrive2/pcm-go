<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StmasGroup extends Model
{
    use HasFactory;

    protected $table = "stkgrps";
    protected $keyType = "string";
    public $incrementing = false;
    protected $fillable = ['shname', 'flname', 'isoth', 'def_site', 'doctype_id', 'imidx', 'code_format', 'age_y', 'is_duty'];

    public function getSubgroupCountAttribute()
    {
        return StmasSubGroup::selectRaw('count(*)')->where('groups_id', $this->id)->value('count');
    }

    public function getDoctypeNameAttribute()
    {
        return Doctype::where('id', $this->doctype_id)->value('docname');
    }

    public function getSiteNameAttribute()
    {
        return Site::where('id', $this->def_site)->value('sitename');
    }    
}
