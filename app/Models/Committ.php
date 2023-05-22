<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Committ extends Model
{
    use HasFactory;

    public function getPositionNameAttribute()
    {
        return Position::where('id', $this->pos_id)->value('posname');
    }

    public function getPhotoUrlAttribute()
    {
        $cardid = TblPerson::where('pid', $this->pid)->value('card_id');
        return env('BACKOFFICE_IMAGE').base64_encode(env('IMG_KEY').base64_encode($cardid));
    }

    public function getAgencyNameAttribute()
    {
        $unitjob_id = TblPerson::where('pid', $this->pid)->value('unitjob_id');
        return Agency::where('unitjob_id', $unitjob_id)->value('unitjob_name');
    }
}
