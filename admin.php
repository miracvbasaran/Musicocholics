<?php session_start(); ?>

<html>
	<head>
		<title>Homepage</title>
	</head>
	<body>
		<div align = "center">
			<form action = "#" method = "post" onsubmit = "return check()">
	          	<br/><br/><br/><br/>MUSICHOLICS<br/><br/>
				ADMIN HOMEPAGE<br/><br/>
				<tr><td><a href='search.php'>Search</a></td></tr><br><br>
				<tr><td><a href='add_track.php'>Add Track</a></td></tr><br> <!--ADD TRACK-->
				<tr><td><a href='add_album.php'>Add Album</a></td></tr><br> <!--ADD ALBUM-->
				<tr><td><a href='add_artist.php'>Add Artist</a></td></tr><br> <!--ADD ARTIST-->
				<tr><td><a href='add_publisher.php'>Add Publisher</a></td></tr><br><br> <!--ADD PUBLISHER-->
				<tr><td><a href='change_password.php'>Change Password</a></td></tr><br><br> <!--CHANGE PASSWORD-->
				<tr><td><a href='logout.php'>Logout</a></td></tr>
			</form>
		</div>
		<!--php-->
	</body>
</html>
