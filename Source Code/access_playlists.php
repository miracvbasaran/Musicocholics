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
		  <li><a href="admin.php">Admin</a></li>
          <li><a href="search_admin.php">Search</a></li>
          <li><a href="add_track.php">Add Track</a></li>
          <li><a href="add_album.php">Add Album</a></li>
          <li><a href="add_artist.php">Add Artist</a></li>
          <li><a href="add_publisher.php">Add Publisher</a></li>
        </ul>
        
        <ul class="nav navbar-nav navbar-right">
          <li><a href="change_password_admin.php"><span class="glyphicon glyphicon-user"></span> Change Password</a></li>
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
	  			$query_playlist = "SELECT P.playlist_id, P.playlist_name, P.description, P.date FROM Playlist P WHERE P.creator_id = {$other_user_id} ORDER BY P.date";
	  			$result_playlist = mysqli_query($db, $query_playlist);
	  			while ($row = mysqli_fetch_array($result_playlist, MYSQLI_NUM)) {
      				$p_id = $row[0];
      				echo "<tr onclick = \"document.location = 'access_playlist.php?playlist_id={$p_id}' \">";
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
	  			$query_playlist = "SELECT P.playlist_id, P.playlist_name, P.description, P.date FROM Playlist P , Collaborates C WHERE C.user_id = {$other_user_id} AND P.playlist_id = C.playlist_id ORDER BY P.date";
	  			$result_playlist = mysqli_query($db, $query_playlist);
	  			while ($row = mysqli_fetch_array($result_playlist, MYSQLI_NUM)) {
      				$p_id = $row[0];
      				echo "<tr onclick = \"document.location = 'access_playlist.php?playlist_id={$p_id}' \">";
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
	  			$query_playlist = "SELECT P.playlist_id, P.playlist_name, P.description, P.date FROM Playlist P , Follows F WHERE F.user_id = {$other_user_id} AND P.playlist_id = F.playlist_id ORDER BY P.date";
	  			$result_playlist = mysqli_query($db, $query_playlist);
	  			while ($row = mysqli_fetch_array($result_playlist, MYSQLI_NUM)) {
      				$p_id = $row[0];
      				echo "<tr onclick = \"document.location = 'access_playlist.php?playlist_id={$p_id}' \">";
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

</body>

</html>