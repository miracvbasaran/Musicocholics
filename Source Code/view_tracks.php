<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db, $_SESSION['login_id']);
    $query1 = "SELECT * FROM user WHERE user_id = {$uid} ";
    $result1 = mysqli_query($db, $query1);
    $user_array = mysqli_fetch_array($result1, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Musicholics - View Tracks</title>
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
		<h3> Tracks </h3> <br>
	</div>

	<div class="container">
		<table class = "table table-hover" style="width:100%">
	  		<tr>
	    		<th>Name</th>
	    		<th>Recording Type</th>
	    		<th>Duration</th>
	    		<th>Danceability</th>
	    		<th>Acousticness</th>
	    		<th>Instrumentalness</th>
	    		<th>Speechness</th>
	    		<th>Balance</th>
	    		<th>Loudness</th>
	    		<th>Language</th>
	    		<th>Price</th>
	    		<th>Date of Addition</th>
	  		</tr>
	  		<?php
	  			$query_track = "SELECT T.track_id, T.track_name, T.recording_type, T.duration, T.danceability, T.Acousticness, T.Instrumentalness, T.Speechness, T.Balance, T.Loudness, T.Language, T.Price, T.date_of_addition FROM buys B, track T WHERE B.user_id = {$uid} AND B.track_id = T.track_id";
	  			$result_track = mysqli_query($db, $query_track);
	  			while ($row = mysqli_fetch_array($result_track, MYSQLI_NUM)) {
      				$t_id = $row[0];
      				echo "<tr onclick = \"document.location = 'view_track.php?track_id={$t_id}' \">";
	      			echo "<td>" . $row[1] . "</td>";
	      			echo "<td>" . $row[2] . "</td>";
	      			echo "<td>" . $row[3] . "</td>";
	      			echo "<td>" . $row[4] . "</td>";
	      			echo "<td>" . $row[5] . "</td>";
	      			echo "<td>" . $row[6] . "</td>";
	      			echo "<td>" . $row[7] . "</td>";
	      			echo "<td>" . $row[8] . "</td>";
	      			echo "<td>" . $row[9] . "</td>";
	      			echo "<td>" . $row[10] . "</td>";
	      			echo "<td>" . $row[11] . "</td>";
	      			echo "<td>" . $row[12] . "</td>";
	      			echo "</tr>" ;
	  			}
	  		?>
		</table>
	</div>
<style>
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   text-align: center;
}
</style>
<div class = "footer">

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
  ?>

  <h4> <?php echo $track_name; ?> (<?php echo $duration; ?> ) </h4>
  
  <div class="progress">
  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="70"
  aria-valuemin="0" aria-valuemax="100" style="width:70%">
    <span class="sr-only"> </span> 
  </div>
</div>
</body>

</html>