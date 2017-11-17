<?php
	$utils_path = "./";
	require_once "php_header.php";
    
    $currentuser = checkLogin();
	
	if (!$currentuser) {
		header("Location: login.php");
	}

    function sendLike($user, $id) {
        global $conn;
        
        $query = "INSERT INTO likes (username, multimediaid) VALUES ('$user', '$id')";
        $result = mysqli_query($conn, $query);
        
        return $result;
    }
    
    print sendLike($currentuser, $_POST["id"]) ? "true" : "false";
?>