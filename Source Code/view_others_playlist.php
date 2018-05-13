<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db, $_SESSION['login_id']);
    $query1 = "SELECT * FROM person WHERE user_id = {$uid} ";
    $result1 = mysqli_query($db, $query1);
    $user_array = mysqli_fetch_array($result1, MYSQLI_ASSOC);
    
    $otheruser_id = $_POST['user_id'];
    $query5 = "SELECT * FROM person WHERE user_id = {$otheruser_id} ";
    $result5 = mysqli_query($db, $query5);
    $other_user_array = mysqli_fetch_array($result5, MYSQLI_ASSOC);
    $username = $other_user_array['username'];

    $playlist_id = $_POST['playlist_id'];
    $query2 = "SELECT * FROM playlist WHERE playlist_id = {$playlist_id}";
    $result2 = mysqli_query($db, $query2);
    $playlist_array =  mysqli_fetch_array($result2, MYSQLI_ASSOC);
    $playlist_name = $playlist_array['playlist_name'];

    $query3 = "SELECT AVG(rate) as avg_rate FROM rates WHERE playlist_id = {$playlist_id}";
    $result3 = mysqli_query($db, $query3);
    $rates_array =  mysqli_fetch_array($result3, MYSQLI_ASSOC);
    $avg_rate = $rates_array['avg_rate'];

    if(isset($_POST['collaborate_playlist'])) {
    	$query4 = "INSERT INTO Collaborates(user_id, playlist_id) VALUES({$uid} , {playlist_id})";
    	$result4 = mysqli_query($db, $query4);
    	header("Refresh:0");
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Musicholics - Playlist</title>
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

	<div class="container">
		<h3> Playlist </h3> <br>
		<h3> <?php echo $playlist_name;?> </h3> <p> by <?php echo $username?> </p> <br>
		<h3> <p>Rate:</p> <?php echo $avg_rate;?> </h3> <br>
	</div>

	<div class="container" align="right">
		<p>
			<form method="post" action="">
				<input id='Submit' name='collaborate_playlist' type='Submit' value='Collaborate Playlist' class="btn btn-default">
			</form>
		</p>
	</div>

	<div class="container">
		<table class = "table table-hover" style="width:100%">
	  		<tr>
	    		<th>Song name</th>
	    		<th>Length</th>
	    		<th>Price</th> 
	  		</tr>
	  		<?php
	  			$query_playlist = "SELECT A.track_id , T.track_name , T.duration , T.price FROM added A , Track T WHERE A.playlist_id = {$playlist_id}";
	  			$result_playlist = mysqli_query($db, $query_playlist);
	  			while ($row = mysqli_fetch_array($result_playlist, MYSQLI_NUM)) {
      				$p_id = $row[0];
     				echo "<a href = \"view_track.php?album_id = {$p_id}\"><tr>";
     				echo "<td>" . $row[1] . "</td>";
     				echo "<td>" . $row[2] . "</td>";
    				echo "<td>" . $row[3] . "</td></a>";
     				echo "</tr>";
	  			}
	  		?>
		</table>
	</div>

	<div class="container">
		<table class = "table table-hover" style="width:100%">
	  		<tr>
	    		<th>Username</th>
	    		<th>Comment</th> 
	  		</tr>
	  		<?php
	  			$query_comment = "SELECT P.person_id , P.username , C.comment , FROM person P , comments C WHERE P.person_id = C.person_id AND C.playlist_id = {$playlist_id}";
	  			$result_comment  = mysqli_query($db, $query_comment);
	  			while ($row = mysqli_fetch_array($result_comment, MYSQLI_NUM)) {
      				$person_id = $row[0];
      				$query_friend = "SELECT COUNT(*) as cntfriend FROM friendship F WHERE (F.user1_id={$uid} AND F.user2_id={$person_id}) OR (F.user2_id={$uid} AND F.user1_id={$person_id})";
      				$result_friend = mysqli_query($db, $query_friend);
      				$friend_array = mysqli_fetch_array($result_friend, MYSQLI_ASSOC);
      				$cnt_friend = $friend_array['cntfriend'];
      				if( $cnt_friend == 0 ) {
      					echo "<a href = \"nonfriend_profile.php?p_id = {$p_id}\"<tr>";
	      				echo "<td>" . $row[1] . "</td>";
	      				echo "<td>" . $row[2] . "</td>";
	      				echo "</tr></a>" ;
	      			}
	      			else {
      					echo "<a href = \"friend_profile.php?p_id = {$p_id}\"<tr>";
	      				echo "<td>" . $row[1] . "</td>";
	      				echo "<td>" . $row[2] . "</td>";
	      				echo "</tr></a>" ;
	      			}
	  			}
	  		?>
		</table>
	</div>

	<div>   
		<footer>
	  		<?php
		  		$query0 = "SELECT L1.track_id FROM listens L1 WHERE L1.user_id = {$uid} AND 
		  		date = (SELECT max(L2.date) FROM listens L2 WHERE L2.user_id = {$uid}) ";
		  		$result0 = mysqli_query($db, $query0);
		  		$row = mysqli_fetch_array($result0, MYSQLI_NUM);
		  		$query9 = "SELECT track_name,duration FROM track WHERE track_id = {$row[0]} ";
		  		$result9 = mysqli_query($db, $query9);
		  		$track_array = mysqli_fetch_array($result9, MYSQLI_ASSOC);
		  		$track_name = $track_array['track_name'];
		  		$duration = $track_array['duration'];
		  		echo $track_name;
		  		echo $duration;
	  		?>
		</footer>
	</div>

</body>

</html>