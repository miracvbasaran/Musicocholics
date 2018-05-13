<?php
// Turn off all error reporting
error_reporting(0);
?>
<?php 
	include("session.php");
	$uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
    $query = "SELECT * FROM user WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);
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
		
		
		<?php
		$query = mysqli_query( $db, "SELECT * FROM Person, User, Friendship WHERE user_id = person_id
																			AND ((user1_id = '$uid' AND user2_id = user_id)
																				OR (user1_id = user_id AND user2_id = '$uid'));");
		while( $row = $query->fetch_assoc()){
			if( $user1_id == $uid)
				$fid = $user2_id;
			else if( $user2_id == $uid)
				$fid = $user1_id;
			
			echo( "<tr><td><a href='friend_profile.php?friend_id=".$id."'>".$row['username']. "&nbsp;&nbsp;</a></td></tr>");
			echo( "<tr><td><a href='send_direct_message.php?friend_id=".$id.	"&nbsp;&nbsp;'>Send Message</a></td></tr>	"); //SEND MESSAGE
			echo( "<tr><td><a href='remove_friend.php?remove_id=".$fid.	"&nbsp;&nbsp;'>Remove</a></td></tr>	<br/> <br/>"); //REMOVE
		}
		
		
		?>
		
	</nav>

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
