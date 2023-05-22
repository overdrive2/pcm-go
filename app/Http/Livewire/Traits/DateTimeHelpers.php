<?php

namespace App\Http\Livewire\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait DateTimeHelpers
{

    public function getCurrentDate() {
        $data = DB::select("SELECT CURRENT_DATE");
        return collect($data)->first()->current_date;
    }

    public function getCurrentSTM() {
        $data = DB::select("SELECT CURRENT_TIMESTAMP::char(19)");
        return collect($data)->first()->current_timestamp;
    }

    public function getCurrentTime() {
        $data = DB::select("select CURRENT_TIME::time(0)");
        return collect($data)->first()->current_time;
    }

    public function getCurrentYear() {
        $data = DB::select("select date_part('year', CURRENT_date) as year");
        return collect($data)->first()->year;
    }

    public function getPlanYear($value)
    {
        $y = Carbon::createFromFormat('d/m/Y', $value)->format('Y');
        $m = Carbon::createFromFormat('d/m/Y', $value)->format('m');
        return (int)$m > 9 ? $y + 1 : $y;
    }

}    