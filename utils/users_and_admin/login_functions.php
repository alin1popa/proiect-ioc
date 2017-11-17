<?php
//include_once 'start_session.php';
//include_once 'random.php';

function unputSession($key)
{
    startSession();
    
    $tail=randomString(10);
    if (!isset($_SESSION['tail']))
        $_SESSION['tail']=$tail;
    else
        $tail=$_SESSION['tail'];
    
    unset($_SESSION[$key.$tail]);
}

function putSession($data, $key)
{
    startSession();
    
    $tail=randomString(10);
    if (!isset($_SESSION['tail']))
        $_SESSION['tail']=$tail;
    else
        $tail=$_SESSION['tail'];
    
    $_SESSION[$key.$tail]=$data;
}

function getSession($key)
{
    startSession();
    
    $tail="";
    if (isset($_SESSION['tail']))
        $tail=$_SESSION['tail'];
    
    $key=$key.$tail;
    if (isset($_SESSION[$key]))
        return $_SESSION[$key];
    else
        return NULL;
}

function setLogin($userid)
{
    startSession();
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $passphrase = randomString(32);
    
    putSession($userid, "userid");
    putSession($ip, "ip");
    putSession($passphrase, "cookie");
    setcookie("cookie", $passphrase, time()+3600);
}

function unsetLogin()
{
    unputSession('userid');
    unputSession('ip');
    unputSession('cookie');
    
    unset($_COOKIE['cookie']);
}

function checkLogin()
{
    startSession();
    
    $userid=getSession("userid");
    $ip=getSession("ip");
    $cookie=getSession("cookie");
    
    $result=$userid;
    
    if (($userid==NULL)||($ip==NULL)||($cookie==NULL))
        $result=NULL;
    else if ($_SERVER['REMOTE_ADDR']!=$ip)
        $result=NULL;
    else if (!isset($_COOKIE['cookie']))
        $result=NULL;
    else if ($_COOKIE['cookie']!=$cookie)
        $result=NULL;
    
    return $result;
}

//if admins are in the same table as regular users
function ifIsAdmin($datab)
{
    $userid = checkLogin();
    if ($userid == NULL)
        return NULL;
    
    $query = "SELECT * FROM users WHERE id='$userid'";
    $result = mysqli_query($datab, $query);
    $row = mysqli_fetch_array($result);
    $admin = $row['admin'];
    
    if ($admin==0) return false;
    else return true;
}

//if admins have a separate table and a separate login form
function setAdmin($adminid)
{
    startSession();
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $passphrase = randomString(32);
    
    putSession($adminid, "adminid");
    putSession($ip, "adminip");
    putSession($passphrase, "admincookie");
    setcookie("admincookie", $passphrase, time()+3600);
}
function checkAdmin()
{
    startSession();
    
    $adminid=getSession("adminid");
    $ip=getSession("adminip");
    $cookie=getSession("admincookie");
    
    $result=$adminid;
    
    if (($adminid==NULL)||($ip==NULL)||($cookie==NULL))
        $result=NULL;
    else if ($_SERVER['REMOTE_ADDR']!=$ip)
        $result=NULL;
    else if (!isset($_COOKIE['admincookie']))
        $result=NULL;
    else if ($_COOKIE['admincookie']!=$cookie)
        $result=NULL;
    
    return $result;
}
function unsetAdmin()
{
    unputSession('adminid');
    unputSession('adminip');
    unputSession('admincookie');
    
    unset($_COOKIE['admincookie']);
}
?>