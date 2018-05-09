<?php

	include("session.php");

    $uid = mysqli_real_escape_string($db,$_POST['login_id']);
    $query1 = "SELECT * FROM user WHERE user_id = '$uid' ";
    $result1 = mysqli_query($db, $query1);
    $user_array = mysqli_fetch_array($result1, MYSQLI_ASSOC);

	if (isset($_POST['addplaylist_button'])) {
    	
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
		      		<li><a href="view_playlists.php">Playlist</a></li>
		      		<li><a href="view_tracks.php">Tracks</a></li>
					<li><a href="friends_list.php">Friends</a></li>
					<li><a href="message_list.php">Messages</a></li>
					<li><a href="search_result_screen.php">Search</a></li>
		    	</ul>
		    	<ul class="nav navbar-nav navbar-right">
		      		<li><a href="change_general_information.php"><span class="glyphicon glyphicon-user"></span> Settings</a></li>
		      		<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
		    	</ul>
			</div>
		</nav>

		<div class="container">

			<h3> Your Playlists: </h3> <br>
			<p>
				<?php
					$queryOP = "SELECT P.playlist_name FROM Playlist P WHERE P.creator_id = '$uid' "
					$resultOP = mysqli_query($db, $queryOP);
					while( $row = mysql_fetch_array($resultOP, MYSQL_NUM) ) {
						printf("%s\n", $row[0]);  
					}
				?>
			</p>

			<p> <input id='Submit' name='addplaylist_button' value='Submit' type='button' value='ADD PLAYLIST'> </p>

			<h3> Your Followed Playlists: </h3> <br>
			<p>
				<?php
					$queryFP = "SELECT P.playlist_name FROM Playlist P , Follows F WHERE F.user_id = '$uid' AND F.playlist_id = P.playlist_id"
					$resultFP = mysqli_query($db, $queryFP);
					while( $row = mysql_fetch_array($resultFP, MYSQL_NUM) ) {
						printf("%s\n", $row[0]);  
					}
				?>
			</p>

		</div>

		<div> 	
			<footer>
				<?php
					$query = "SELECT L1.track_id FROM listens L1 WHERE L1.user_id = '$uid' AND 
						date = SELECT max(L2.date) FROM listens L2 WHERE L2.user_id = '$uid'";
					$result = mysqli_query($db, $query);
					$query2 = "SELECT track_name,duration FROM track WHERE track_id = $result";
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