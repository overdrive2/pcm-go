<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpuStat extends Model
{
    use HasFactory;

    protected $connection = 'monitor';
    protected $fillable = ['cpu_use',	'cpu_nice',	'cpu_system',	'cpu_iowait',	'cpu_steal',	'cpu_idle',	'slot_stat'];
    
    protected function serializeDate(DateTimeInterface $date){
        return $date->format('Y-m-d h:i:s');
    }
}
