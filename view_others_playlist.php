<?php

	include("session.php");

    $uid = mysqli_real_escape_string($db,$_GET['login_id']);
    $query1 = "SELECT * FROM user WHERE user_id = '$uid' ";
    $result1 = mysqli_query($db, $query1);
    $user_array = mysqli_fetch_array($result1, MYSQLI_ASSOC);

    $pid = $_GET['playlist_id'];
    $query2 = "SELECT * FROM playlist WHERE playlist_id = '$pid' "
    $result2 = mysqli_query($db, $query2);
    $playlist_array = mysqli_fetch_array($result2, MYSQLI_ASSOC);

    $user_id = $_GET['other_id'];

    $pname = $playlist_array['playlist_name'];

    if ( isset($_POST['followplaylist_button']) ) {
    	$queryF = "INSERT INTO VALUES($uid , $pid , $rate)";
    	$resultF = mysqli_query($db, $queryF);
    }

    /* There is no space for comment now */
    if ( isset($_POST['commentplaylist_button']) ) {
    	$queryComment = "INSERT INTO VALUES($uid , $pid , getdate() , $comment)";
    	$resultComment = mysqli_query($db, $queryComment);
    }

    if ( isset($_POST['collaborateplaylist_button']) ) {
    	$queryCollaborate = "INSERT INTO VALUES($uid , $pid)";
    	$resultCollaborate = mysqli_query($db, $queryCollaborate);
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
		      		<li><a href="homepage.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
		    	</ul>
			</div>
		</nav>

		<div class="container">
			
			<h3> Playlist: </h3> <?php echo $pname; ?> <br>
			
			<p>
				<?php
					$queryR = "SELECT AVG(rate) FROM Rates R , User U WHERE R.playlist_id = '$pid' AND U.user_id = '$user_id' ";
					$resultR = mysqli_query($db, $queryR);
					printf( "Avg Rate: %lf\n" , $resultR );
				?>
			</p>

			<p> <input id='Submit' name='followplaylist_button' value='Submit' type='button' value='FOLLOW PLAYLIST'> </p>

			<p> <input id='Submit' name='collaborateplaylist_button' value='Submit' type='button' value='COLLABORATE PLAYLIST'> </p>

			<p>
				<?php
					$queryT = "SELECT T.track_name , T.duration , T.price FROM Added A , Track T WHERE A.playlist_id = '$pid' AND T.track_id = A.track_id"
					$resultT = mysqli_query($db, $queryT);
					while( $row = mysql_fetch_array($resultT, MYSQL_NUM) ) {
						printf("%s %d: %lf\n", $row[0] , $row[1] ,$row[2]);  
					}
				?>
			</p>

			<p>
				<?php
					$queryC = "SELECT U.usernane , C.date , C.comment FROM Comments C , User U WHERE C.playlist_id = '$pid' AND U.user_id = '$user_id' ORDER BY C.date DESC"
					$resultC = mysqli_query($db, $queryC);
					while( $row = mysql_fetch_array($resultC, MYSQL_NUM) ) {
						printf("%s (%s): %s\n", $row[0] , $row[1] ,$row[2]);  
					}
				?>
			</p>

			<p> <input id='Submit' name='commentplaylist_button' value='Submit' type='button' value='COMMENT PLAYLIST'> </p>

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