<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db, $_SESSION['login_id']);
    $query1 = "SELECT * FROM user WHERE user_id = {$uid} ";
    $result1 = mysqli_query($db, $query1);
    $user_array = mysqli_fetch_array($result1, MYSQLI_ASSOC);

    $other_user_id = $_GET['other_id'];    

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Musicholics - Own Playlists</title>
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
		<h3> Creator </h3> <br>
		<table class = "table table-hover" style="width:100%">
	  		<tr>
	    		<th>Name</th>
	    		<th>Description</th> 
	  		</tr>
	  		<?php
	  			$query_playlist = "SELECT P.playlist_id, P.playlist_name, P.description, P.date, P.creator_id FROM Playlist P WHERE P.creator_id = {$other_user_id} ORDER BY P.date";
	  			$result_playlist = mysqli_query($db, $query_playlist);
	  			while ($row = mysqli_fetch_array($result_playlist, MYSQLI_NUM)) {
      				$p_id = $row[0];
      				$pc_id = $row[4];
      				$query_check_collaborate = "SELECT count(*) check_collaborate FROM Collaborates C WHERE C.user_id = $uid AND C.playlist_id = $p_id";
      				$result_check_collaborate = mysqli_query($db, $query_check_collaborate);
      				$array_check_collaborate = mysqli_fetch_array($result_check_collaborate, MYSQLI_ASSOC);
      				$check_collaborate = $array_check_collaborate['check_collaborate'];
      				if( $check_collaborate > 0 OR $uid == $pc_id ) {
      					echo "<tr onclick = \"document.location = 'view_own_playlist.php?playlist_id={$p_id}' \">";
      				}
      				else {
      					echo "<tr onclick = \"document.location = 'view_others_playlist.php?playlist_id={$p_id}' \">";
      				}
	      			echo "<td>" . $row[1] . "</td>";
	      			echo "<td>" . $row[2] . "</td>";
	      			echo "</tr>" ;
	  			}
	  		?>
		</table>
	</div>

	<div class="container">
		<h3> Collaborator </h3> <br>
		<table class = "table table-hover" style="width:100%">
	  		<tr>
	    		<th>Name</th>
	    		<th>Description</th> 
	  		</tr>
	  		<?php
	  			$query_playlist = "SELECT P.playlist_id, P.playlist_name, P.description, P.date, P.creator_id FROM Playlist P , Collaborates C WHERE C.user_id = {$other_user_id} AND P.playlist_id = C.playlist_id ORDER BY P.date";
	  			$result_playlist = mysqli_query($db, $query_playlist);
	  			while ($row = mysqli_fetch_array($result_playlist, MYSQLI_NUM)) {
      				$p_id = $row[0];
      				$pc_id = $row[4];
      				$query_check_collaborate = "SELECT count(*) check_collaborate FROM Collaborates C WHERE C.user_id = $uid AND C.playlist_id = $p_id";
      				$result_check_collaborate = mysqli_query($db, $query_check_collaborate);
      				$array_check_collaborate = mysqli_fetch_array($result_check_collaborate, MYSQLI_ASSOC);
      				$check_collaborate = $array_check_collaborate['check_collaborate'];
      				if( $check_collaborate > 0 OR $uid == $pc_id ) {
      					echo "<tr onclick = \"document.location = 'view_own_playlist.php?playlist_id={$p_id}' \">";
      				}
      				else {
      					echo "<tr onclick = \"document.location = 'view_others_playlist.php?playlist_id={$p_id}' \">";
      				}
	      			echo "<td>" . $row[1] . "</td>";
	      			echo "<td>" . $row[2] . "</td>";
	      			echo "</tr>" ;
	  			}
	  		?>
		</table>
	</div>

	<div class="container">
		<h3> Follower </h3> <br>
		<table class = "table table-hover" style="width:100%">
	  		<tr>
	    		<th>Name</th>
	    		<th>Description</th> 
	  		</tr>
	  		<?php
	  			$query_playlist = "SELECT P.playlist_id, P.playlist_name, P.description, P.date, P.creator_id FROM Playlist P , Follows F WHERE F.user_id = {$other_user_id} AND P.playlist_id = F.playlist_id ORDER BY P.date";
	  			$result_playlist = mysqli_query($db, $query_playlist);
	  			while ($row = mysqli_fetch_array($result_playlist, MYSQLI_NUM)) {
      				$p_id = $row[0];
      				$pc_id = $row[4];
      				$query_check_collaborate = "SELECT count(*) check_collaborate FROM Collaborates C WHERE C.user_id = $uid AND C.playlist_id = $p_id";
      				$result_check_collaborate = mysqli_query($db, $query_check_collaborate);
      				$array_check_collaborate = mysqli_fetch_array($result_check_collaborate, MYSQLI_ASSOC);
      				$check_collaborate = $array_check_collaborate['check_collaborate'];
      				if( $check_collaborate > 0 OR $uid == $pc_id ) {
      					echo "<tr onclick = \"document.location = 'view_own_playlist.php?playlist_id={$p_id}' \">";
      				}
      				else {
      					echo "<tr onclick = \"document.location = 'view_others_playlist.php?playlist_id={$p_id}' \">";
      				}
	      			echo "<td>" . $row[1] . "</td>";
	      			echo "<td>" . $row[2] . "</td>";
	      			echo "</tr>" ;
	  			}
	  		?>
		</table>
	</div>
<br><br><br><br><br><br><br><br><br>
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