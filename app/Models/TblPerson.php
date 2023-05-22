<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblPerson extends Model
{
    use HasFactory;
    
    protected $table        = 'tbl_persons';
    protected $primaryKey   = 'pid';
    protected $connection   = 'person';
}
