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
		
		$id = mysqli_real_escape_string( $connect, $_GET['login_id']);
		$fquery = mysqli_query( $connect, "SELECT * FROM Friendship WHERE user1_id = '$id' OR user2_id = '$id');");
		
		while( $frow = $fquery->fetch_assoc()){ //for each friend
			$fid = $frow['user1_id'];
			if( $fid == $id)
				$fid = $frow['user2_id'];
			$_SESSION['remove_friend_id'] = $fid;
			$uquery = mysqli_query( $connect, "SELECT * FROM Person WHERE person_id = '$fid');"); //friends profile
			echo( "<tr><td><a href='friend_profile.php?friend_id=".$id."'>.$uquery['fullname'].	</a></td></tr></br>");
			echo( "<tr><td><a href='send_message.php?friend_id=".$id."'>Send Message</a></td></tr>	"); //SEND MESSAGE
			echo( "<tr><td><a href='remove_friend.php'>Remove</a></td></tr>	"); //REMOVE
		}
		?>
	</body>
</html>
