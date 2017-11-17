<?php

function maxlenUTF8($data, $maxlen)
{
    $data=mb_substr($data,0,$maxlen,'UTF-8');
    return $data;
}


function testInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = maxlenUTF8($data, 32);
  return $data;
}

function validateEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        return false;
    else 
        return true;
}

function validateURL($website)
{
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website))
        return false;
    else
        return true;
}

function safePassword($pass)
{
    $longenough = 1;
    if (strlen($pass)<6) $longenough=0;
    $containsLowerLetter  = preg_match('/[a-z]/',    $pass);
    $containsUpperLetter  = preg_match('/[A-Z]/',    $pass);
    $containsDigit   = preg_match('/\d/',          $pass);
    //$containsSpecial = preg_match('/[^a-zA-Z\d]/', $pass);
    $safe = $containsLowerLetter && $containsUpperLetter && $containsDigit && $longenough;
    
    return $safe;
}

function checkPost($key)
{
    if (!isset($_POST[$key]))
    {
        header("Location: error.php");
        die();
    }
}

function is_empty($data)
{
    if ($data=="") return true;
    else {
        return false;
    }
}
?>