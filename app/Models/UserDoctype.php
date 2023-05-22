<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDoctype extends Model
{
    use HasFactory;

    protected $fillable = ['usercode', 'doctype_id', 'user_id'];
}
