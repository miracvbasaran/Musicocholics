<?php 
include("session.php");
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Musicholics - Advanced Album Search</title>
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
					<br/><br/><br/><br/>MUSICHOLICS<br/><br/>Advanced Album Search<br/><br/><br/><br/>
					<input type = "text" name = "search_key" placeholder = "Album Name"> <br/><br/>
					<input type = "radio" name="match" value="matches"/> Exactly matches &nbsp; &nbsp;
					<input type = "radio" name="match" value="contains"/> Contains &nbsp; &nbsp;
					<input type = "radio" name="match" value="starts_with"/> Starts with
					<br/><br/>
					<font color="black">
						<input type = "date" name = "from_date" placeholder = "Starting date" > 
						<input type = "date" name = "end_date" placeholder = "End date"> 
					</font>
					<br/><br/>
					<input type = "radio" name="type" value="Album"/> Album &nbsp; &nbsp;
					<input type = "radio" name="type" value="Single"/> Single
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
				var match = document.getElementById( "match").value;
				var from_date = document.getElementById( "from_date").value;
				var end_date = document.getElementById( "end_date").value;
				var type = document.getElementById( "type").value;

				if( search_key == "")
					alert( "Please type an album name");
				if( match = "")
					alert( "Please one of \"Exactly matches\", \"Exactly Contains\", \"Starts with\"" );
				if( from_date = "")
					alert( "Please select a starting date");
				if( end_date = "")
					alert( "Please select a ending date");
				if( type = "")
					alert( "Please select album type");
				
				location.href = "advanced_album_search.php";
			}
			</script>
		
		
		<?php
	
		if( isset( $_POST['search'])){
			$search_key = mysqli_real_escape_string( $db, $_POST['search_key']);
			$match = mysqli_real_escape_string( $db, $_POST['match']);
			$from_date = mysqli_real_escape_string( $db, $_POST['from_date']);
			$end_date = mysqli_real_escape_string( $db, $_POST['end_date']);
			$type = mysqli_real_escape_string( $db, $_POST['type']);
			
			if( $match == "matches"){
				$query = mysqli_query( $db, "SELECT * FROM Album WHERE ( album_name LIKE '$search_key') 
																		AND album_type = '$type' 
																		AND published_date >= '$from_date' 
																		AND published_date <= '$from_date';");
				while( $row = $query->fetch_assoc()){ 
					echo( "<tr> <td><a href='album.php?album_id=".$row['album_id']."'>.$row['album_id'].</a></td> </tr>");
				}
			}
			else if( $match == "contains"){
				$query = mysqli_query( $db, "SELECT * FROM Album WHERE ( album_name LIKE '$search_key') 
																		AND album_type = '$type' 
																		AND published_date >= '$from_date' 
																		AND published_date <= '$from_date';");
				while( $row = $query->fetch_assoc()){ 
					echo( "<tr> <td><a href='album.php?album_id=".$row['album_id']."'>.$row['album_id'].</a></td> </tr>");
				}
			}
			else if( $match == "starts_with"){
				$query = mysqli_query( $db, "SELECT * FROM Album WHERE ( album_name LIKE '$search_key') 
																		AND album_type = '$type' 
																		AND published_date >= '$from_date' 
																		AND published_date <= '$from_date';");
				while( $row = $query->fetch_assoc()){ 
					echo( "<tr> <td><a href='album.php?album_id=".$row['album_id']."'>.$row['album_id'].</a></td> </tr>");
				}
			}
			
		}
		
		?>
	
		<br/><br/><br/>
		<div align = "center">
			<tr><td><a href='logout.php'>Logout</a></td></tr>
		</div>
	</nav>

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
</body>
</html>
