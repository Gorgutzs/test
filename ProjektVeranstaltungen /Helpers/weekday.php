<?php

class helperFunctionWeekday{


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
    1 => "Januar",
    2 => "Februar",
    3 => "März",
    4 => "April",
    5 => "Mai",
    6 => "Juni",
    7 => "Juli",
    8 => "August",
    9 => "September",
    10 => "Oktober",
    11 => "November",
    12 => "Dezember"
];


public static function weekdayConverter($Weekday)
{
$date = new Datetime($Weekday);
$date = $date->format("N");

return self::$Weekdays[$date];
}

public static function monthConverter($Month)
{
$date = new Datetime($Month);
$date = $date->format("N");

return self::$Months[$date];
}



}