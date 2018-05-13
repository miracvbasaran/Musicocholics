<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db, $_SESSION['login_id']);
    $query1 = "SELECT * FROM user WHERE user_id = {$uid} ";
    $result1 = mysqli_query($db, $query1);
    $user_array = mysqli_fetch_array($result1, MYSQLI_ASSOC);

    if(isset($_POST['create_playlist'])) {
    	if(isset($_POST['playlist_name'])) {
    		if(isset($_POST['playlist_description'])) {
    			$playlist_name = $_POST['playlist_name'];
    			$playlist_description = $_POST['playlist_description'];
    			$date = new DateTime();
    			$query_insert = "INSERT INTO Playlist(playlist_name, description, date) VALUES({$playlist_name}, {$playlist_description}, {$date->getTimestamp()}";
    			$result_insert = mysqli_query($db, $query_insert);
         		$query5 = "SELECT MAX(playlist_id) FROM Playlist";
         		$result5 = mysqli_query($db, $query5);
         		$index_array = mysqli_fetch_array($result5, MYSQLI_NUM);
        	  	header("location: view_own_playlist.php?playlist_id=".$index_array[0]);
    		}
    		else {
    			echo ' <script type="text/javascript"> alert("Description is not entered."); </script>';
    		}
    	}
    	else {
			echo ' <script type="text/javascript"> alert("Playlist name is not entered."); </script>';
    	}
    }
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

	<div class="container">
		<h3> Playlists </h3> <br>
		<div align="right" class="container"></div>
		<p>
			<form method="post" action="">
				<input id='Submit' name='create_playlist' type='Submit' value='Create Playlist' class="btn btn-default">
			</form>
		</p>
	</div>

	<div class="container">
		<form method="post" action="">
			<input type="text" name="playlist_name" value= "New Playlist Name" autofocus>
			<input type="text" name="playlist_description" value= "Description" autofocus>
		</form>
	</div>

	<div class="container">
		<table class = "table table-hover" style="width:100%">
	  		<tr>
	    		<th>Name</th>
	    		<th>Description</th> 
	  		</tr>
	  		<?php
	  			$query_playlist = "SELECT P.playlist_id, P.playlist_name, P.description, P.date, FROM Playlist P WHERE P.creator_id = {$uid} ORDER BY P.date";
	  			$result_playlist = mysqli_query($db, $query_playlist);
	  			while ($row = mysqli_fetch_array($result_playlist, MYSQLI_NUM)) {
      				$p_id = $row[0];
      				echo "<a href = \"view_own_playlist.php?playlist_id = {$p_id}\"<tr>";
	      			echo "<td>" . $row[1] . "</td>";
	      			echo "<td>" . $row[2] . "</td>";
	      			echo "</tr></a>" ;
	  			}
	  		?>
		</table>
	</div>

</body>

</html>