<?php

	include("session.php");

    $uid = mysqli_real_escape_string($db,$_POST['login_id']);
    $query1 = "SELECT * FROM user WHERE user_id = '$uid' ";
    $result1 = mysqli_query($db, $query1);
    $user_array = mysqli_fetch_array($result1, MYSQLI_ASSOC);

    $pid = $_POST['playlist_id'];
    $query2 = "SELECT * FROM playlist WHERE playlist_id = '$pid' "
    $result2 = mysqli_query($db, $query2);
    $playlist_array = mysqli_fetch_array($result2, MYSQLI_ASSOC);

    $pname = $playlist_array['playlist_name'];

    if ( isset($_POST['deleteplaylist_button']) ) {
    	
    	$queryD1 = "DELETE FROM playlist WHERE playlist_id = '$pid' ";
    	$resultD1 = mysqli_query($db, $queryD1);

    	$queryD2 = "DELETE FROM added WHERE playlist_id = '$pid' ";
    	$resultD2 = mysqli_query($db, $queryD2);

    	$queryD3 = "DELETE FROM follows WHERE playlist_id = '$pid' ";
    	$resultD3 = mysqli_query($db, $queryD3);

    	$queryD4 = "DELETE FROM rates WHERE playlist_id = '$pid' ";
    	$resultD4 = mysqli_query($db, $queryD4);

    	$queryD5 = "DELETE FROM comments WHERE playlist_id = '$pid' ";
    	$resultD5 = mysqli_query($db, $queryD5);

    	$queryD6 = "DELETE FROM collaborates WHERE playlist_id = '$pid' ";
    	$resultD6 = mysqli_query($db, $queryD6);

    	header("location: view_own_playlists.php?");

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
		      		<li><a href="view_own_playlists.php">Playlist</a></li>
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

		<div class="container">
			
			<h3> Playlist: </h3> <?php echo $pname; ?> <br>

			<p>
				<?php
					$queryR = "SELECT AVG(rate) FROM Rates R , User U WHERE R.playlist_id = '$pid' AND U.user_id = '$uid' ";
					$resultR = mysqli_query($db, $queryR);
					printf( "Avg Rate: %lf\n" , $resultR );
				?>
			</p>
			
			<p> <input id='Submit' name='deleteplaylist_button' value='Submit' type='button' value='DELETE PLAYLIST'> </p>

			<table>
			    <thead>
			        <tr>
						<td>Name</td>
			            <td>Duration</td>
			            <td>Price</td>
			        </tr>
			    </thead>
			    <tbody>
					<?php
						$queryT = "SELECT T.track_name , T.duration , T.price FROM Added A , Track T WHERE A.playlist_id = '$pid' AND T.track_id = A.track_id"
						$resultT = mysqli_query($db, $queryT);
			            while($row = mysql_fetch_array($resultsT, MYSQL_NUM)) { ?>
			                <tr>
			                    <td><?php echo $row[0]?></td>
			                    <td><?php echo $row[1]?></td>
			                    <td><?php echo $row[2]?></td>
			                </tr>
			            <?php }
			        ?>
			    </tbody>
			</table>

			<h3> Comments: </h3> <br>

			<table>
			    <thead>
			        <tr>
						<td>Username</td>
			            <td>Date</td>
			            <td>Comment</td>
			        </tr>
			    </thead>
			    <tbody>
					<?php
						$queryC = "SELECT C.user_id , C.date , C.comment FROM Comments C WHERE C.playlist_id = '$pid' ORDER BY C.date DESC"
						$resultC = mysqli_query($db, $queryC);
			            while($row = mysql_fetch_array($resultsC, MYSQL_NUM)) { ?>
			                <tr>
			                    <td><?php echo $row[0]?></td>
			                    <td><?php echo $row[1]?></td>
			                    <td><?php echo $row[2]?></td>
			                </tr>
			            <?php }
			        ?>
			    </tbody>
			</table>

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
