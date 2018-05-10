<?php 
	include("session.php");
	include("connection.php");
?>

<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>Musicholics - Admin</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>

		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">Home</a></li>
					<li><a href="search.php">Search</a></li>
					<li><a href="add_track.php">Add Track</a></li>
					<li><a href="add_album.php">Add Album</a></li>
					<li><a href="add_artist.php">Add Artist</a></li>
					<li><a href="add_publisher.php">Add Publisher</a></li>
				</ul>
				
				<ul class="nav navbar-nav navbar-right">
					<li><a href="change_password.php"><span class="glyphicon glyphicon-user"></span> Change Password</a></li>
					<li><a href="homepage.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
				</ul>
			</div>
		</nav>
	</body>
</html>
