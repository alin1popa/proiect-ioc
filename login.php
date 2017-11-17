<?php
	$utils_path = "./";
	require_once "php_header.php";

	//unsetLogin();
	//setLogin("asd");
	
	if (isset($_POST["username"]) && isset($_POST["password"])) {
		$username = $_POST["username"];
		$password = $_POST["password"];
		
		$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
		$result = mysqli_query($conn, $query);
		
		if (mysqli_num_rows($result)) {
			setLogin($username);
			mysqli_free_result($result);
			header("Location: index.php");
			exit();
		}
		else {
			mysqli_free_result($result);
			$error = "Incorrect username or password";
		}
	}
	
	$currentuser = checkLogin();
?>

<html>
	<head>
	</head>
	
	<body>
		<p>Currently logged user: <?php echo $currentuser; ?></p>
		<?php if (isset($error)) {
			echo "<p>$error</p>";
		}
		?>
		<form method="POST" action="login.php">
			<input type="text" name="username" placeholder="Username"/> <br/>
			<input type="password" name="password" placeholder="Password"/>
			<input type="submit" name="submit" value="submit"/>
		</form>
	</body>
</html>