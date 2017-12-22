<?php
	$utils_path = "./";
	require_once "php_header.php";
	
	$currentuser = checkLogin();
	
	if (!$currentuser) {
		header("Location: login.php");
	}
	
	$TYPE_MOVIE = 1;
	$TYPE_SERIES = 2;
	$TYPE_GAME = 4;
	$TYPE_ANY = $TYPE_MOVIE |
				$TYPE_SERIES |
				$TYPE_GAME;
				
	$STRING_MOVIE = "movie";
	$STRING_SERIES = "series";
	$STRING_GAME = "game";
				
	function getTypeString($type) {
		global $TYPE_MOVIE;
		global $TYPE_SERIES;
		global $TYPE_GAME;
		
		global $STRING_MOVIE;
		global $STRING_SERIES;
		global $STRING_GAME;
		
		switch ($type) {
			case $TYPE_MOVIE: return $STRING_MOVIE;
			case $TYPE_SERIES: return $STRING_SERIES;
			case $TYPE_GAME: return $STRING_GAME;
		}
	}
				
	function getTypeCondition($type) {
		global $TYPE_MOVIE;
		global $TYPE_SERIES;
		global $TYPE_GAME;

		global $STRING_MOVIE;
		global $STRING_SERIES;
		global $STRING_GAME;
		
		$str = "";
		if ($type & $TYPE_MOVIE) { 
			if (strlen($str) > 0)
				$str .= " OR ";
			$str.= "type='$STRING_MOVIE'";
		}
		if ($type & $TYPE_SERIES) { 
			if (strlen($str) > 0)
				$str .= " OR ";
			$str.= "type='$STRING_SERIES'";
		}
		if ($type & $TYPE_GAME) { 
			if (strlen($str) > 0)
				$str .= " OR ";
			$str.= "type='$STRING_GAME'";
		}
		
		return "($str)";
	}
	
	function getLatest($count = 5, $type = 7, $orderby = "releasedate", $ordertype = "DESC") {
		global $conn;
		global $currentuser;
		$array = Array();
		
		$query = "SELECT * FROM multimedia ";
		$query .= "WHERE ";
		$query .= getTypeCondition($type) . " ";
		$query .= "ORDER BY $orderby $ordertype ";
		$query .= "LIMIT $count";
		
		$result = mysqli_query($conn, $query);
		
		while ($row = mysqli_fetch_assoc($result)) {
			$likequery = "SELECT * FROM likes WHERE multimediaid='{$row['id']}'";
			$likeresult = mysqli_query($conn, $likequery);
			
			$likearray = Array();
			while ($likerow = mysqli_fetch_assoc($likeresult)) {
				if (strcmp($likerow['username'], $currentuser) == 0) {
					$row['liked'] = true;
				}
				else {
					array_push($likearray, $likerow['username']);
				}
			}
			$row['wholikes'] = $likearray;
			
			mysqli_free_result($likeresult);
			array_push($array, $row);
		}
		
		mysqli_free_result($result);
		return $array;
	}
	
	$latest = getLatest();
	/*
	* mall vitan -> se schimba sensul scarilor rulante
	* => mai schimbi traseul
	* => #ubd
	*
	*/
	
	
	if (isset($_POST) && isset($_POST['addfriend'])) {
		$friendusername = $_POST['username'];
		
		$query = "INSERT INTO friends (sender,receiver) VALUES ('$currentuser','$friendusername')";
		$result = mysqli_query($conn, $query);
	}
	
	function getFriends($user) {
		global $conn;
		$array = Array();
		
		$query = "SELECT * FROM friends WHERE sender='$user' or receiver='$user'";
		$result = mysqli_query($conn, $query);
		
		while ($row = mysqli_fetch_array($result)) {
			$otheruser = strcmp($row['sender'], $user) ? $row['sender'] : $row['receiver'];
			array_push($array, $otheruser);
		}
		
		mysqli_free_result($result);
		return $array;
	}
	
	$friends = getFriends($currentuser);
?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="layout.css">
		<link rel="stylesheet" type="text/css" href="multimedia.css">
		
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

        <script type="text/javascript">
            function like(id) {
                $.post("like.php", {id: id}, function( data ) {
                    if (data === "true")
                        $("#liked_container_"+id).html("<p class='liked'>LIKED</p>");
                });
            }
        </script>
	</head>
	
	<body>
	
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
		  <a class="navbar-brand" href="#">Navbar</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<ul class="navbar-nav mr-auto">
			  <li class="nav-item active">
				<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="#">Link</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link disabled" href="#">Disabled</a>
			  </li>
			  <li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
				<div class="dropdown-menu" aria-labelledby="dropdown01">
				  <a class="dropdown-item" href="#">Action</a>
				  <a class="dropdown-item" href="#">Another action</a>
				  <a class="dropdown-item" href="#">Something else here</a>
				</div>
			  </li>
			</ul>
			<form class="form-inline my-2 my-lg-0">
			  <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
			  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
			</form>
		  </div>
		</nav>
	
		<p>Currently logged user: <?php echo $currentuser; ?></p>
		<p>Your friends: 
		<?php
			foreach ($friends as $friend) {
				echo $friend . ", ";
			}
		?></p>
		<p><a href="logout.php">Log out</a></p>
		<?php if (isset($error)) {
			echo "<p>$error</p>";
		}
		?>
		
		<div>
			<?php
				if (isset($latest)) {
					foreach ($latest as $item) {	
						$out = "";
						$out .= "<div class='multimedia {$item['type']}'>";
						$out .= "	<p>{$item['name']}</p>";
						$out .= "	<p>{$item['description']}</p>";
                        $out .= "   <div id='liked_container_{$item['id']}'>";
						if (isset($item['liked'])) {
							$out .= "	<p class='liked'>LIKED</p>";
						} else {
							$out .= "	<a onClick='like({$item['id']})'>like</a>";
						}
                        $out .= "   </div>";
						$out .= "	<p>Users who like: ";
						foreach ($item['wholikes'] as $user) {
							$out .= "$user, ";
						}
						$out .= "	</p>";
						$out .= "</div>";
						
						echo $out;
					}
				}
			?>
		</div>
		
		<div>
			<form method="POST" action="index.php">
				<input type="text" name="username" placeholder="Friend username"/>
				<input type="submit" name="addfriend" value="Add friend"/>
			</form>
		</div>
	</body>
</html>