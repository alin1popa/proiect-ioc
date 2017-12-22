<?php
	$utils_path = "./";
	require_once "php_header.php";
    
    $currentuser = checkLogin();
	
	if (!$currentuser) {
		header("Location: login.php");
	}

    function sendLike($user, $id, $type) {
        global $conn;
		
		$query = "SELECT COUNT(*) FROM likes WHERE username='$user' AND multimediaid='$id' AND type='$type'";
		$result = mysqli_query($conn, $query);
		
		$row = mysqli_fetch_row($result);
		
        if ($row[0]) {
			$query = "DELETE FROM likes WHERE username='$user' AND multimediaid='$id' AND type='$type'";
			$result = mysqli_query($conn, $query);
        
			return "0";
		} else {
			$query = "INSERT INTO likes (username, multimediaid, type) VALUES ('$user', '$id', '$type')";
			$result = mysqli_query($conn, $query);
        
			return "1";
		}
    }
    
    print sendLike($currentuser, $_POST["id"], $_POST["type"]);
?>