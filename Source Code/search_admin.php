<?php 
include("session.php");
//include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Musicholics - Search</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

	<nav class="navbar navbar-inverse">
	
		<div align = "center">
			<form action = "#" method = "post">
				<font color="white">
					<br/><br/><br/><br/>MUSICHOLICS<br/><br/>Search<br/><br/><br/><br/>
					
					
					<font color="black">
						<input type = "text" name = "search_key" placeholder = "Search.."> 
						<input id = "" value = "Search" name = "search" type = "submit"> </button>
					</font>
					<br/><br/>
					<input type="radio" name="filter" value="all"/> All &nbsp; &nbsp;
					<input type="radio" name="filter" value="track"/> Track &nbsp; &nbsp;
					<input type="radio" name="filter" value="album"/> Song &nbsp; &nbsp;
					<input type="radio" name="filter" value="artist"/> Artist &nbsp; &nbsp;
					<input type="radio" name="filter" value="playlist"/> Playlist &nbsp; &nbsp;
					<input type="radio" name="filter" value="user"/> User
					<br>
				</font>
			</form>
		</div>

		<?php
	
		if( isset( $_POST['search'])){
			$search_key = mysqli_real_escape_string( $db, $_POST['search_key']);
			$filter = mysqli_real_escape_string( $db, $_POST['filter']);
			//echo( "<tr> <td>".$search_key."</td> </tr><br/>");
			//echo( "<tr> <td>".$filter."</td> </tr><br/>");

			if( $filter == "track" || $filter == "all"){ //TRACK
				$query = mysqli_query( $db, "SELECT * FROM Track WHERE track_name LIKE '%$search_key%';");
				while( $row = $query->fetch_assoc()){ //printing every track with that track name
					echo( "<tr> <td><a href='track.php?track_id=".$row['track_id']."'>".$row['track_name']."</a></td> </tr><br/>");
				}
			}
			if( $filter == "album" || $filter == "all"){ //ALBUM
				$query = mysqli_query( $db, "SELECT * FROM Album WHERE album_name LIKE '%$search_key%';");
				while( $row = $query->fetch_assoc()){ //printing every album with that album name
					echo( "<tr> <td><a href='album.php?album_id=".$row['album_id']."'>".$row['album_name']."</a></td> </tr><br/>");
				}
			}
			if( $filter == "artist" || $filter == "all"){ //ARTIST
				$query = mysqli_query( $db, "SELECT * FROM Artist WHERE artist_name LIKE '%$search_key%';");
				while( $row = $query->fetch_assoc()){ //printing every artist with that artist name
					echo( "<tr><td><a href='artist.php?artist_id=".$row['artist_id']."'>".$row['artist_name']."</a></td></tr><br/>");
				}
			}
			if( $filter == "playlist" || $filter == "all"){ //PLAYLIST
				$query = mysqli_query( $db, "SELECT * FROM Playlist WHERE playlist_name LIKE '%$search_key%';");
				while( $row = $query->fetch_assoc()){ //printing every playlist with that playlist name
					echo( "<tr><td><a href='playlist.php?playlist_id=".$row['playlist_id']."'>".$row['playlist_name']."</a></td></tr><br/>");
				}
			}
		if( $filter == "user" || $filter == "all"){ //USER
				$query = mysqli_query( $db, "SELECT * FROM Person, User WHERE username LIKE '%$search_key%' AND user_id = person_id;");
				while( $row = $query->fetch_assoc()){ //printing every user with that user name
					echo( "<tr><td><a href='complete_profile.php?view_id=".$row['person_id']."'>".$row['username']."</a></td></tr><br/>");
					
				}
			}
		}
		
		?>
	
		<br/><br/><br/>
		<div align = "center">
			<tr><td><a href='logout.php'>Logout</a></td></tr>
		</div>
	</nav>
</body>
</html>
