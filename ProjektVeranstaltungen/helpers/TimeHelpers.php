<?php

class HelperFunctionTime{


private static $Weekdays = [
    1 => "Montag",
    2 => "Dienstag",
    3 => "Mittwoch",
    4 => "Donnerstag",
    5 => "Freitag",
    6 => "Samstag",
    7 => "Sonntag"
];

private static $Months = [
    "01" => "Januar",
    "02" => "Februar",
    "03" => "März",
    "04" => "April",
    "05" => "Mai",
    "06" => "Juni",
    "07" => "Juli",
    "08" => "August",
    "09" => "September",
    "10" => "Oktober",
    "11" => "November",
    "12" => "Dezember"
];


private static $shortWeekdays = [
    1 => "Mo",
    2 => "Di",
    3 => "Mi",
    4 => "Do",
    5 => "Fr",
    6 => "Sa",
    7 => "So"
];

private static $nummberMonths =[
    "Januar" => "01",
    "Jan" =>"01",
    "Februar" => "02",
    "Feb" => "02",
    "März" => "03",
    "Mrz"=>"03",
    "April" => "04",
    "Apr"=> "04",
    "Mai" => "05",
    "Juni" => "06",
    "Jun" => "06",
    "Juli" => "07",
    "Jul" => "07",
    "August" => "08",
    "Aug" => "08",
    "September" => "09",
    "Sept"=>"09",
    "Sep"=>"09",
    "Oktober" => "10",
    "Okt"=>"10",
    "November" => "11",
    "Nov"=>"11",
    "Dezember" => "12",
    "Dez"=>"12"
];


public static function weekdayConverter($Weekday)
{
$date = new Datetime($Weekday);
$date = $date->format("N");

return self::$Weekdays[$date];
}


public static function shortWeekdayConverter($Weekday)
{
$date = new Datetime($Weekday);
$date = $date->format("N");

return self::$shortWeekdays[$date];
}


public static function monthConverter($Month)
{
$date = new Datetime($Month);
$date = $date->format("m");

return self::$Months[$date];
}

public static function secondDelter($time)
{
$date = new Datetime($time);
$date = $date->format("H:i");

return $date;

}

public static function rightOrder($wrongDate)
{
    $date = new Datetime($wrongDate);
    $date = $date->format("d-m-Y");

    return $date;
}

public static function onlyDay($date)
{

    $date = new Datetime($date);
    $date = $date->format("d");

    return $date;

}

public static function onlyYear($date)
{

    $date = new Datetime($date);
    $date = $date->format("Y");

    return $date;

}

//Datum wird als Zahl:Ausgeschrieben:Zahl ausgegeben
public static function datum($date)
{

    $month = self::monthConverter($date);
    $day = self::onlyDay($date);
    $year= self::onlyYear($date);

    return $day.". ".$month." ".$year;

}


public static function monthNameToNumber($date)
{


$date=str_replace($date,self::$nummberMonths[$date],$date);
return $date;

}


public static function dateNormalisieren($date)
{
   
    preg_match('/\d{1,2}/',$date,$days);
    $date = preg_replace('/' . preg_quote($days[0], '/') . '/', ' ', $date, 1);
    preg_match('/[\p{L}]+|\d{1,2}/u',$date,$month);
    $date = preg_replace('/' . preg_quote($month[0], '/') . '/', ' ', $date, 1);
    preg_match('/\d{4}|\d{2}/', $date, $year);

    if(preg_match('/^[\p{L}]+$/u', $month[0]))
        {
         $month[0] = self::monthNameToNumber($month[0]);
        }

    $standardDate = $year[0] . '-' . $month[0] . '-' . $days[0];
   

    return  $standardDate;
   

}

}