<?php 
include("session.php");
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Musicholics - Advanced Playlist Search</title>
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
				<li><a href="view_own_playlists.php">Playlist</a></li>
				<li><a href="view_tracks.php">Tracks</a></li>
				<li><a href="friends.php">Friends</a></li>
				<li><a href="message_list.php">Messages</a></li>
				<li class="active"><a href="#">Search</a></li>
				<li><a href="change_general_information.php">Settings</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
		
		
		<div align = "center">
			<form action = "#" method = "post" onsubmit = "return check()">
				<font color="white">
					<br/><br/><br/><br/>MUSICHOLICS<br/><br/>Advanced Playlist Search<br/><br/><br/><br/>
					<input type = "text" name = "search_key" placeholder = "Album Name"> <br/><br/>
					<input type = "radio" name="match" value="matches"/> Exactly matches &nbsp; &nbsp;
					<input type = "radio" name="match" value="contains"/> Contains &nbsp; &nbsp;
					<input type = "radio" name="match" value="starts_with"/> Starts with
					<br/><br/>
					<input type = "text" name = "creator" placeholder = "Creator name contains.."> <br/><br/>
					<br/><br/>
					<font color="black">
						<input id = "" value = "Search" name = "search" type = "submit"> </button> <br/><br/>
					</font>
					<br/><br/>
				</font>
			</form>
		</div>
		
		
		<script type = "text/javascript">
			function check(){
				var search_key = document.getElementById( "search_key").value;
				var match = document.getElementById( "description").value;

				if( search_key == "")
					alert( "Please type an playlist name");
				if( match = "")
					alert( "Please one of \"Exactly matches\", \"Exactly Contains\", \"Starts with\"" );
				
				location.href = "advanced_playlist_search.php";
			}
			</script>
		
		
		<?php
	
		if( isset( $_POST['search'])){
			$search_key = mysqli_real_escape_string( $db, $_POST['search_key']);
			$match = mysqli_real_escape_string( $db, $_POST['match']);
			$creator = mysqli_real_escape_string( $db, $_POST['creator']);
			
			
			
			if( $match == "matches"){
				$query = mysqli_query( $db, "SELECT * FROM Playlist WHERE ( playlist_name LIKE '$search_key';)");
				while( $row = $query->fetch_assoc()){ 
					$pquery = mysqli_query( $db, "SELECT * FROM Person, Playlist WHERE username LIKE '%$creator%'");
					while( $prow = $pquery->fetch_assoc()){ 
						if( $row['creator_id'] == $prow['person_id'])
							echo( "<tr> <td><a href='playlist.php?playlist_id=".$row['playlist_id']."'>.$row['playlist_id'].</a></td> </tr>");
					}
				}
			}
			else if( $match == "contains"){
				$query = mysqli_query( $db, "SELECT * FROM Playlist WHERE ( playlist_name LIKE '%$search_key%';)");
				while( $row = $query->fetch_assoc()){ 
					$pquery = mysqli_query( $db, "SELECT * FROM Person, Playlist WHERE username LIKE '%$creator%'");
					while( $prow = $pquery->fetch_assoc()){ 
						if( $row['creator_id'] == $prow['person_id'])
							echo( "<tr> <td><a href='playlist.php?playlist_id=".$row['playlist_id']."'>.$row['playlist_id'].</a></td> </tr>");
					}
				}
			}
			else if( $match == "starts_with"){
				$query = mysqli_query( $db, "SELECT * FROM Playlist WHERE ( playlist_name LIKE '$search_key%';)");
				while( $row = $query->fetch_assoc()){ 
					$pquery = mysqli_query( $db, "SELECT * FROM Person, Playlist WHERE username LIKE '%$creator%'");
					while( $prow = $pquery->fetch_assoc()){ 
						if( $row['creator_id'] == $prow['person_id'])
							echo( "<tr> <td><a href='playlist.php?playlist_id=".$row['playlist_id']."'>.$row['playlist_id'].</a></td> </tr>");
					}
				}
			}
			
		}
		
		?>
	
		<br/><br/><br/>
		<div align = "center">
			<tr><td><a href='logout.php'>Logout</a></td></tr>
		</div>
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
