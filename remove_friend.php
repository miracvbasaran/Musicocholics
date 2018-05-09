<?php session_start(); ?>

<html>
	<head>
		<title>Friends</title>
	</head>
	<body>
		<div align = "center">
			<form action = "#" method = "post" onsubmit = "return check()">
	          	<br/><br/><br/><br/>MUSICHOLICS<br/><br/>
				FRIENDS<br/><br/>
			</form>
		</div>
	
		<?php
		$hostname = ""; 
		$username = "";
		$password = "";
		$connect = mysqli_connect( $hostname, $username, $password, $username) or die( "MySQL connection error");
		if ( mysqli_connect_errno())
			echo "Failed to connect to MySQL: ".mysqli_connect_error();
		
		$id = $_SESSION['login_id'];
		$remove_id = $_SESSION['remove_friend_id'];
		
		$rquery = mysqli_query( $connect, "DELETE * FROM Friendship WHERE (user1_id = '$id' AND user2_id = '$fid') 
																	   OR (user1_id = '$fid' AND user2_id = '$id')");
		if( $rquery) //successful
			header( "Location: friends.php");
		else
			echo( "Error while deleting friend.");
		
	</body>
</html>
