<?php

namespace App\Http\Livewire\Traits;

use Illuminate\Support\Facades\DB;

trait Serials
{
    public function getSerial($seq)
    {
        $data = collect(DB::select("select nextval('".$seq."') as id"))->first();
        return $data->id;
    }

}
