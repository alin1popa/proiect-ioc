<?php

/*
EXAMPLES

logError("Error blah");
logTask("Task successfully made");
logToFile("message", "file.txt");

*/

$where_to_log="";
$curuser="";

//log something to a file
function logToFile($string, $file)
{
        //get filename and line
        $backt = debug_backtrace();
        $backt_index = count($backt)-1;
        $curfile = $backt[$backt_index]['file'];
        $curline = $backt[$backt_index]['line'];
    
	//$luser = $_SESSION['a_user'];
	global $curuser;
	$luser = $curuser;//user
	
	//add date, time, ip, file, user and string
	$content = date('m/d/Y a h:i:s').' '.$_SERVER['REMOTE_ADDR'].' '. $curfile .' '.$curline.' '. $luser .' '. $string ."\r\n";
	
	//write to file
	file_put_contents($file, $content, FILE_APPEND );
}

//error logging
function logError($string)
{
	global $where_to_log;
	$file = $where_to_log.'logerror.txt';
	logToFile($string, $file);
	echo $string;
}

//task logging
function logTask($string)
{
	global $where_to_log;
	$file = $where_to_log.'logtask.txt';
	logToFile($string, $file);
}

function initLog($path)
{
	global $where_to_log;
	$where_to_log = $path;
}

function setLogUser($string)
{
	global $curuser;
	$curuser = $string;
}
?>
