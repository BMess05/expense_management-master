<?php

function totalTime($seconds){
        $timeInSec = $seconds ?? 00;
        $d = (gmdate("d", $timeInSec)-1)*24 ?? 00;
        $hours = gmdate("H", $timeInSec) ?? 00;
        $daysHours = $d + $hours;
        $days = sprintf("%02d", $daysHours);
        $minutes = gmdate("i", $timeInSec) ?? 00;
        $seconds = gmdate("s", $timeInSec) ?? 00;
        return $days.':'.$minutes.':'.$seconds;
}

?>