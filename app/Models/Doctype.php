<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctype extends Model
{
    use HasFactory;

    protected $fillable = ['docname', 'ord', 'po_prefix', 'pr_prefix'];
}
