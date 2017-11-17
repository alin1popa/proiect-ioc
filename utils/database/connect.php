<?php

/*
EXAMPLES

configure array in datab_config.php

$datab1 = array();
$datab1['host'] = "localhost";
$datab1['database'] = "docviewer_db";
$datab1['user'] = "root";
$datab1['password'] = "";

$connection1 = connectToDB($datab1);
if ($connection1)
{
	do stuff here with the database connection
}
*/

include_once 'datab_config.php';

function connectToDB($db_array)
{   
    //----MYSQL login credentials
    $mysql_host = $db_array['host'];
    $mysql_database = $db_array['database'];
    $mysql_user = $db_array['user'];
    $mysql_password = $db_array['password'];
    
    //try to connect
    $datab=mysqli_connect($mysql_host,$mysql_user,$mysql_password,$mysql_database);
	
	//unable to connect
	if (mysqli_connect_errno())
	{
		$errmsg = 'Error connecting to database. Details: -- host '.$mysql_host.' -- database '.$mysql_database.' -- MySQL error number '.mysqli_connect_errno().' -- MySQL error message '.mysqli_connect_error();
		//echo $errmsg;
		logError($errmsg);
		return 0;
	}
	else
	{
		return $datab;
	}
}

?>