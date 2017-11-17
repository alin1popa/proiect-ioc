<?php

/*
EXAMPLES

randomStrFromCharset("123ab", 10); -> 10 chars taken out randomly out of "123ab"
randomString();
randomNumber();
randomHex();
*/


//these functions are unsafe for passwords 

//generate a random string from a charset
function randomStrFromCharset($charset, $length=32)
{
	$characters = $charset;
    $rString = '';
    for ($i = 0; $i < $length; $i++) {
        $rString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $rString;
}

//generate random string with $length
function randomString($length = 32) {
    $charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return randomStrFromCharset($charset, $length);
}

//generate random number with $length
function randomNumber($length = 32) {
    $charset = '0123456789';
    return randomStrFromCharset($charset, $length);
}

//generate random hex with $length
function randomHex($length = 32) {
    $charset = '0123456789abcdef';
    return randomStrFromCharset($charset, $length);
}
?>