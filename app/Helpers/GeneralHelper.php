<?php


namespace App\Helpers;

class GeneralHelper
{
    public static function dateIndoConverter($datetime) {
        list($dates, $times) = explode(' ', $datetime);
        list($year, $month, $date) = explode('-', $dates);

        $arrMonth = array("01"=>"Januari", "02"=>"Februari", "03"=>"Maret", "04"=>"April", "05"=>"Mei", "06"=>"Juni", "07"=>"Juli", "08"=>"Agustus", "09"=>"September", "10"=>"Oktober", "11"=>"November", "12"=>"Desember","x"=>"undefine");

        $result = $date. " " .$arrMonth[$month]. " " .$year;
        return $result;
    }

    public static function dateOnlyIndoConverter($date) {
        list($date, $month, $year) = explode('-', $date);

        $arrMonth = array("01"=>"Januari", "02"=>"Februari", "03"=>"Maret", "04"=>"April", "05"=>"Mei", "06"=>"Juni", "07"=>"Juli", "08"=>"Agustus", "09"=>"September", "10"=>"Oktober", "11"=>"November", "12"=>"Desember","x"=>"undefine");

        $result = $date. " " .$arrMonth[$month]. " " .$year;
        return $result;
    }

    public static function dateOnlyIndoRevertConverter($date) {
        list($year, $month, $date) = explode('-', $date);

        $arrMonth = array("01"=>"Januari", "02"=>"Februari", "03"=>"Maret", "04"=>"April", "05"=>"Mei", "06"=>"Juni", "07"=>"Juli", "08"=>"Agustus", "09"=>"September", "10"=>"Oktober", "11"=>"November", "12"=>"Desember","x"=>"undefine");

        $result = $date. " " .$arrMonth[$month]. " " .$year;
        return $result;
    }

    public static function dateTimeIndoConverter($datetime) {
        list($dates, $times) = explode(' ', $datetime);
        list($year, $month, $date) = explode('-', $dates);
        list($hours, $minutes, $seconds) = explode(':', $times);

        $arrMonth = array("01"=>"Januari", "02"=>"Februari", "03"=>"Maret", "04"=>"April", "05"=>"Mei", "06"=>"Juni", "07"=>"Juli", "08"=>"Agustus", "09"=>"September", "10"=>"Oktober", "11"=>"November", "12"=>"Desember","x"=>"undefine");

        $result = $date. " " .$arrMonth[$month]. " " .$year. " " .$hours. ":" .$minutes;
        return $result;
    }

    public static function monthIndoConverter($month) {
        $arrMonth = array("1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei", "6" => "Juni",
                          "7" => "Juli", "8" => "Agustus", "9" => "September", "10" => "Oktober", "11" => "November",
                          "12" => "Desember", null => "-");

        $result = $arrMonth[$month];
        return $result;
    }

    public static function epocTodates($date) {
        $result = date("Y-m-d H:i:s", substr($date, 0, 10));
        return $result;
    }

    public static function idnMoney($number, $prefix = 0, $suffix = 0) {
        if ($prefix == 1) {
            $money = "Rp".number_format($number,$suffix,',','.');
        } else {
            $money = number_format($number,$suffix,',','.');
        }
        return $money;
    }

    public static function thblConverter($thbl) {
        $tahun = substr($thbl, 0, 4);
        $bulan = substr($thbl, 4, 2);

        $arrMonth = array("01"=>"Januari", "02"=>"Februari", "03"=>"Maret", "04"=>"April", "05"=>"Mei", "06"=>"Juni", "07"=>"Juli", "08"=>"Agustus", "09"=>"September", "10"=>"Oktober", "11"=>"November", "12"=>"Desember","x"=>"undefine");
        $result = $arrMonth[$bulan]. " " .$tahun;

        return $result;
    }
    public static function nextMonthThbl($year, $month) {
        $month = intval($month);
        if($month == '12') {
            return ($year+1).'01';
        } else {
            return strlen($month) < 2 ? $year.'0'.($month+1) : $year.($month+1);
        }
    }

    public static function prevMonthThbl($year, $month) {
        $month = intval($month);

        if($month == '1') {
            return ($year-1).'12';
        } else {
            return strlen($month) < 2 ?  $year.'0'.($month-1) : $year.($month-1);
        }
    }

    public static function clockConverter($time) {
        $times = explode(":", $time);

        $hour = (strlen($times[0]) == 1) ? '0'.$times[0] : $times[0];
        $minute = (strlen($times[1]) == 1) ? '0'.$times[1] : $times[1];

        return $hour.':'.$minute;
    }

    public static function triwulanCapaianKinerjaBulanan($tahun, $triwulan) {
        if ($triwulan == '1') {
            $bulan_cek = [10, 11, 12];
            $triwulan_cek = 4;
            $tahun_cek = $tahun - 1;
        } else if ($triwulan == '2') {
            $bulan_cek = [1, 2, 3];
            $triwulan_cek = 1;
            $tahun_cek = $tahun;
        } else if ($triwulan == '3') {
            $bulan_cek = [4, 5, 6];
            $tahun_cek = $tahun;
            $triwulan_cek = 2;
        } else if ($triwulan == '4') {
            $bulan_cek = [7, 8, 9];
            $triwulan_cek = 3;
            $tahun_cek = $tahun;
        }

        $result = array('bulan' => $bulan_cek,
                        'triwulan' => $triwulan_cek,
                        'tahun' => $tahun_cek);
        return $result;
    }

    // public static function triwulanCapaianKinerjaTriwulan($tahun, $triwulan) {
    //     if ($triwulan == '1') {
    //         $bulan_cek = [10, 11, 12];
    //         $tahun_cek = $tahun - 1;
    //     } else if ($triwulan == '2') {
    //         $bulan_cek = [1, 2, 3];
    //         $tahun_cek = $tahun;
    //     } else if ($triwulan == '3') {
    //         $bulan_cek = [4, 5, 6];
    //         $tahun_cek = $tahun;
    //     } else if ($triwulan == '4') {
    //         $bulan_cek = [7, 8, 9];
    //         $tahun_cek = $tahun;
    //     }

    //     $result = array('bulan' => $bulan_cek, 'tahun' => $tahun_cek);
    //     return $result;
    // }
}
