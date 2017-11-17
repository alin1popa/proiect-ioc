<?php

/*
EXAMPLES

$hash = hashPassword("password345");
if (verifyPassword($user_input, $hash))
{
	//user gave correct password
}
*/

include_once 'safecompare.php';

//create hash from password
function hashPassword($password)
{
	$random = openssl_random_pseudo_bytes(18);
	$salt = sprintf('$5$rounds=5000$%s$',
		substr(strtr(base64_encode($random), '+', '.'), 0, 32)
	);

	$hash = crypt($password, $salt);
	return $hash;
}

//validate a given password from its hash
function verifyPassword($given_password, $old_hash)
{
	$given_hash = crypt($given_password, $old_hash);

	return safeCompare($given_hash, $old_hash);
}

?>