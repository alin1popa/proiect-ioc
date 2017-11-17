<?php

/*
EXAMPLE

echo quickHash("string"); //32 chars hash
*/

//salt for hashing
$qhashsalt = "abcdefgh098094Z7313PORT";

//hash - unsafe for passwords
function quickHash($string)
{
	global $qhashsalt;
	$t= crypt($string, $qhashsalt);
	return $t;
}
?>