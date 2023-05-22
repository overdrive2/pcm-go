<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = ['prenam', 'supnam', 'addr01', 'addr02', 'addr03', 'telnum', 'gov_id'];
}
