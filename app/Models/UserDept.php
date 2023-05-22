<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDept extends Model
{
    use HasFactory;

    protected $fillable = ["usercode", "depts_id", "id", "user_id"];

    public function getDeptNameAttribute()
    {
        return Department::where('dept_id', $this->depts_id)->value('dept_name');
    }
}
