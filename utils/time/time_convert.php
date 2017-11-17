<?php

define ("MINUTE", 60);
define ("HOUR", 3600);
define ("DAY", 86400);
define ("WEEK", 604800);
define ("MONTH", 2592000);
define ("YEAR", 31536000);

function toSeconds($value, $unit)
{
    $v = $value;
    if ($unit=="second")
        return $v;
    
    $v*=60;
    if ($unit=="minute")
        return $v;
    
    $v*=60;
    if ($unit=="hour")
        return $v;
    
    $v*=24;
    if ($unit=="day")
        return $v;
    
    if ($unit=="week")
        return $v*7;
    
    if ($unit=="month")
        return $v*30;
    
    if ($unit=="year")
        return $v*365;
    
    return $value;
}
?>