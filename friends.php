<?php 
	include("session.php");
	include("connection.php");
?>

<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>Musicholics - Friends</title>
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
					<li><a href="own_profile.php">Profile</a></li>
					<li><a href="view_playlists.php">Playlist</a></li>
					<li><a href="view_tracks.php">Tracks</a></li>
					<li class="active"><a href="#">Friends</a></li>
					<li><a href="message_list.php">Messages</a></li>
					<li><a href="search_result_screen.php">Search</a></li>
					<li><a href="change_general_information.php">Settings</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>
		</nav>
		
		<?php
		
		$id = mysqli_real_escape_string( $db, $_POST['login_id']);
		$fquery = mysqli_query( $db, "SELECT * FROM Friendship WHERE user1_id = '$id' OR user2_id = '$id');");
		
		while( $frow = $fquery->fetch_assoc()){ //for each friend
			$fid = $frow['user1_id'];
			if( $fid == $id)
				$fid = $frow['user2_id'];
			$_SESSION['remove_friend_id'] = $fid;
			$uquery = mysqli_query( $db, "SELECT * FROM Person WHERE person_id = '$fid');"); //friends profile
			echo( "<tr><td><a href='friend_profile.php?friend_id=".$id."'>".$uquery['fullname']."	</a></td></tr></br>");
			echo( "<tr><td><a href='send_message.php?friend_id=".$id."'>Send Message</a></td></tr>	"); //SEND MESSAGE
			echo( "<tr><td><a href='remove_friend.php'>Remove</a></td></tr>	"); //REMOVE
		}
		
		?>
		
		
	</body>
</html>
