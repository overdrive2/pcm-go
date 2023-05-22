<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoDocscan extends Model
{
    use HasFactory;
    protected $fillable = ['docname',	'docfile',	'doctype_id',	'po_id',	'filetype',	'scantype', 'filepath'];

    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';
}
