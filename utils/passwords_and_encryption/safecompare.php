<?php

/*
EXAMPLES

safeCompare($passhash1, $passhash2);
--> compares $passhash1 with $passhash2
*/

//safely compare two encrypted values or passwords that people shouldn't have access to
function safeCompare($str1, $str2)
{
    $n1 = strlen($str1);
    if (strlen($str2) != $n1) {
        return false;
    }
    for ($i = 0, $diff = 0; $i != $n1; ++$i) {
        $diff |= ord($str1[$i]) ^ ord($str2[$i]);
    }
    return !$diff;
}
?>