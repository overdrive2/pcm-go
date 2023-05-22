<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    
    protected $table = 'dept';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['dept_id', 'dept_name'];

    public function isUse($uid)
    {
        return (UserDept::where('user_id', $uid)->where('depts_id', $this->dept_id)->count() > 0);
    }
}
