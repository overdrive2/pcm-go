<?php

namespace App\Http\Livewire\Traits;

use Carbon\Carbon;

trait FunctionDateTimes
{
    public   $dayTH = ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'];
    public   $monthTH = [null,'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฏาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
    public   $monthTH_brev = [null,'ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
    public   $thMonth = [
                'มกราคม'     => '01',
                'กุมภาพันธ์'   => '02',
                'มีนาคม'     => '03',
                'เมษายน'    => '04',
                'พฤษภาคม'  => '05',
                'มิถุนายน'    => '06',
                'กรกฏาคม'    => '07',
                'สิงหาคม'    => '08',
                'กันยายน'    => '09',
                'ตุลาคม'     => '10',
                'พฤศจิกายน'  => '11',
                'ธันวาคม'    => '12'
            ];

    public function thai_date_and_time($time){   // 19 ธันวาคม 2556 เวลา 10:10:43
        $thai_date_return = date("j",$time);
        $thai_date_return.=" ".$this->monthTH[$time->format("n")];
        $thai_date_return.= " ".(date("Y",$time)+543);
        $thai_date_return.= " เวลา ".date("H:i:s",$time);
        return $thai_date_return;
    }

    public function thai_date_and_time_short($time){   // 19  ธ.ค. 2556 10:10:4
        $thai_date_return = $time->format("j");
        $thai_date_return.=" ".$this->monthTH_brev[intval($time->format("n"))];
        $thai_date_return.= " ".($time->format("Y")+543);
        $thai_date_return.= " ".$time->format("H:i:s");
        return $thai_date_return;
    }

    public function thai_date_short($time){   // 19  ธ.ค. 2556a
        $thai_date_return = $time->format("j");
        $thai_date_return.=" ".$this->monthTH_brev[$time->format("n")];
        $thai_date_return.= " ".($time->format("Y")+543);
        return $thai_date_return;
    }

    public function thai_date_fullmonth($time){   // 19 ธันวาคม 2556
        $thai_date_return = $time->format("j");
        $thai_date_return.=" ".$this->monthTH[$time->format("n")];
        $thai_date_return.= " ".($time->format("Y")+543);
        return $thai_date_return;
    }

    public function thai_date_short_number($time){   // 19-12-56
        $thai_date_return = date("d",$time);
        $thai_date_return.="-".date("m",$time);
        $thai_date_return.= "-".substr((date("Y",$time)+543),-2);
        return $thai_date_return;
    }

    public function thdate2YMD($value)
    {
        $d = explode("/",$value);
		$d = ($d[2]-543).'-'.str_pad(($d[1]*1), 2, '0', STR_PAD_LEFT).'-'.$d[0];
		return $d;
    }

    public function YMD2ThaiDate($value)
    {
        $d = explode("-",$value);
		$d = $d[2].'/'.$d[1].'/'.$d[0];
		return $d;
    }

    public function thdatefull2YMD($value)
    {
        $d = explode("  ",$value);
		$d = ($d[2]-543).'-'.$this->thMonth[$d[1]].'-'.$d[0];
		return $d;
    }
}
