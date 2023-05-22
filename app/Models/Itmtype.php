<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itmtype extends Model
{
    use HasFactory;

    protected $fillable = ['iname',	'level',	'icon',	'ref_id',	'prefix',	'objcount',	'doctype_id',	'label',	'ord',	'imgindex', 'parent_id'];

    CONST CREATED_AT = 'create_at';
    CONST UPDATED_AT = 'update_at';

    public function getIconNameAttribute()
    {
        return Icon::where('id', $this->icon_id)->value('icon');
    }

    public function getItemCountAttribute()
    {
        return Itmtype::where('ref_id', $this->id)->count();
    }

    public function getParentAttribute()
    {
        return Itmtype::where('ref_id', $this->id)->first();
    }

    public function getRefNameAttribute()
    {
        return Itmtype::where('id', $this->ref_id)->value('iname');
    }
}
