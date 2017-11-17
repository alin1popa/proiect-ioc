<?php
$log_path = "./";

include_once $utils_path.'utils/errors/error_rep.php';
include_once $utils_path.'utils/errors/logs.php';
include_once $utils_path.'utils/database/connect.php';
include_once $utils_path.'utils/database/datab_tests.php';
include_once $utils_path.'utils/sessions/start_session.php';
include_once $utils_path.'utils/random/random.php';
include_once $utils_path.'utils/users_and_admin/login_functions.php';

//include_once $scripts_path.'gotoPages.php';

//session
startSession();

//logging
initLog($log_path);

//admin - #TESTING
//setAdmin();

//connect to database
$conn=connectToDB($datab1);
if (!$conn){
	gotoError(5);
	exit();
}
mysqli_set_charset($conn, 'utf8');
mysqli_query($conn, "SET SQL_MODE=''");

#todo banning (if banned)
?>