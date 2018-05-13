<?php

	include("session.php");

    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
    $query = "SELECT * FROM user U WHERE U.user_id = '$uid' ";
    $result = mysqli_query($db, $query);
    $user_array = mysqli_fetch_array($result,MYSQLI_ASSOC);

    if( $other_id != '' )
    	$user_id = $_POST['other_id'];

    if ( isset($_POST['sendmessage_button']) ) {
    	if ( isset($_POST['receiver']) ) {
    		if ( isset($_POST['text_message']) ) {
    			$query = "INSERT INTO SENDS_MESSAGE VALUES ('$uid', '$user_id', getdate(), '$text_message' ";
    			$result = mysqli_query($db, $query);
    			header("location: message_list.php?");
    		}
    		else {
    			echo '<div class="alert alert-danger" role="alert"> Receiver is not entered. </div>';
    		}
    	}
    	else {
			echo '<div class="alert alert-danger" role="alert"> Message is not entered. </div>';
    	}
    }

?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Musicholics - My Profile</title>
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
		      		<li><a href="own_profile.php">Profile</a></li>
		      		<li><a href="playlists.php">Playlist</a></li>
		      		<li><a href="view_tracks.php">Tracks</a></li>
					<li><a href="friends.php">Friends</a></li>
					<li><a href="message_list.php">Messages</a></li>
					<li><a href="search.php">Search</a></li>
		    	</ul>
		    	<ul class="nav navbar-nav navbar-right">
		      		<li><a href="change_general_information.php"><span class="glyphicon glyphicon-user"></span> Settings</a></li>
		      		<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
		    	</ul>
			</div>
		</nav>

		<form method="post" action="">
			Receiver: <input type="text" name="receiver" value= <?php echo "\"".$user_id."\"";?> autofocus> <br>
		</form>

		<form method="post" action="">
			Text Message: <input type="text" name="text_message" value= <?php echo "\"".$text_message."\"";?> autofocus> <br>
		</form>

		<div class="container">
			<p> <input id='Submit' name='sendmessage_button' value='Submit' type='button' value='SEND MESSAGE'> </p>
		</div>

		<div> 	
			<footer>
					<?php
					$query = "SELECT L1.track_id FROM listens L1 WHERE L1.user_id = '$uid' AND 
					date = (SELECT max(L2.date) FROM listens L2 WHERE L2.user_id = '$uid') ";
					$result = mysqli_query($db, $query);
					$row = mysqli_fetch_array($result, MYSQLI_NUM);
					$query2 = "SELECT track_name,duration FROM track WHERE track_id = '$row[0]' ";
					$result2 = mysqli_query($db, $query2);
					$track_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);

				  	$track_name = $track_array['track_name'];
				  	$duration = $track_array['duration'];
					echo $track_name;
					echo $duration;
					?>
			</footer>
		</div>

	</body>

</html>