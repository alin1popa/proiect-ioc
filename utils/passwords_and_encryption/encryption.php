<?php

/*
EXAMPLES

echo generateEncryptionKey();

$enc = safeEncrypt("hello", KEY);
echo safeDecrypt($enc, KEY);
*/


//encryption algorithm - AES-128 is best
$cipher = MCRYPT_RIJNDAEL_128;

//encryption key - should be kept safe
define('KEY', 'a352225c322cbdbf8b602272');

//generates a random safe encryption key - can be used to replace a key or blah
function generateEncryptionKey()
{
	global $cipher;
	$key_size = mcrypt_get_key_size($cipher, MCRYPT_MODE_CFB);
	do{
	$encryption_key = openssl_random_pseudo_bytes($key_size, $strong);
	}while ($strong==false);
	return substr(bin2hex($encryption_key), -24);
}

//encrypts string with key
function safeEncrypt($string, $key)
{
	global $cipher;
	
	//serialize string
	$string = serialize($string);
	
	//generate random initialization vector for algorithm
	$iv_size = mcrypt_get_iv_size($cipher, MCRYPT_MODE_CFB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_URANDOM);
	
	//generates signature based on string and key
	$signature = hash_hmac('sha256', $string, substr(bin2hex($key), -20, 16));
	
	//add signature to string and then encrypt
	$encoded = mcrypt_encrypt($cipher, $key, $string.$signature, MCRYPT_MODE_CFB, $iv);
	
	//concatenate string and iv
	$final = base64_encode($encoded).'|'.base64_encode($iv);
	
	return $final;
}

//decrypts encrypted string with key
function safeDecrypt($enc, $key)
{
	global $cipher;
	
	//disassemble into string and iv
	$decrypt = explode('|', $enc);
	$decoded = base64_decode($decrypt[0]);
	$iv = base64_decode($decrypt[1]);
	if (strlen($iv)!=mcrypt_get_iv_size($cipher, MCRYPT_MODE_CFB)) return false;
	
	//decrypt string
	$string = trim(mcrypt_decrypt($cipher, $key, $decoded, MCRYPT_MODE_CFB, $iv));
	
	//disassemble again into actual string and signature
	$strsign = substr($string, -64);
	$string = substr($string, 0, -64);
	
	//calculate signature again
	$realsign = hash_hmac('sha256', $string, substr(bin2hex($key), -20, 16));
	
	//validate signatures
	if($realsign!==$strsign){ return false; }
	
	//unserialize and return
	return unserialize($string);
}
?>