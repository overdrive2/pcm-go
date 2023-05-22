<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Pocom extends Model
{
    use HasFactory;

    protected $fillable = ['po_id',	'comname',	'posname',	'no',	'comtype',	'com_id'];

    public function getIdCryptAttribute()
    {
        return Crypt::encrypt($this->id);
    }
}
