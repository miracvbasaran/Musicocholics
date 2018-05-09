<?php session_start(); ?>

<html>
	<head>
		<title>Search</title>
	</head>
	<body>
		<div align = "center">
			<form action = "#" method = "post">
				<br/><br/><br/><br/>MUSICHOLICS<br/><br/>
				SEARCH<br/><br/>
				<input type = "text" name = "search_key" placeholder = "Search.."> 
				<input id = "" value = "Search" name = "search" type = "submit"> </button> <br/><br/>
				<input type="radio" name="filter" value="all"/>All
				<input type="radio" name="filter" value="track"/>Track
				<input type="radio" name="filter" value="album"/>Song
				<input type="radio" name="filter" value="artist"/>Artist
				<input type="radio" name="filter" value="playlist"/>Playlist
				<input type="radio" name="filter" value="user"/>User<br/>
			</form>
		</div>
	
		<?php
		$hostname = "";
		$username = "";
		$password = "";
		$connect = mysqli_connect( $hostname, $username, $password, $username) or die( "MySQL connection error");
		if( mysqli_connect_errno())
			echo "Failed to connect to MySQL: ".mysqli_connect_error();

		if( isset( $_POST['search'])){
			$search_key = mysqli_real_escape_string( $connection, $_POST['search_key']);
			$filter = mysqli_real_escape_string( $connection, $_POST['filter']);
			
			if( $filter == "track" || $filter == "all"){ //TRACK
				$query = "SELECT * FROM Track WHERE track_name = '$search_key'";
				while( $row = $query->fetch_assoc()){ //printing every track with that track name
					echo( "<tr> <td><a href='track.php?album_id=".$row['track_id']."'>.$row['track_id'].</a></td> </tr>");
				}
			}
			else if( $filter == "album" || $filter == "all"){ //ALBUM
				$query = "SELECT * FROM Album WHERE album_name = '$search_key'";
				while( $row = $query->fetch_assoc()){ //printing every album with that album name
					echo( "<tr> <td><a href='album.php?album_id=".$row['album_id']."'>.$row['album_id'].</a></td> </tr>");
				}
			}
			else if( $filter == "artist" || $filter == "all"){ //ARTIST
				$query = "SELECT * FROM Artist WHERE artist_name = '$search_key'";
				while( $row = $query->fetch_assoc()){ //printing every artist with that artist name
					echo( "<tr><td><a href='artist.php?album_id=".$row['artist_id']."'>.$row['artist_id'].</a></td></tr>");
				}
			}
			else if( $filter == "playlist" || $filter == "all"){ //PLAYLIST
				$query = "SELECT * FROM Album WHERE album_name = '$search_key'";
				while( $row = $query->fetch_assoc()){ //printing every playlist with that playlist name
					echo( "<tr><td><a href='playlist.php?playlist_id=".$row['playlist_id']."'>.$row['playlist_id'].</a></td></tr>");
				}
			}
			else if( $filter == "user" || $filter == "all"){ //USER
				$query = mysqli_query( $connect, "SELECT * FROM Person NATURAL JOIN User WHERE username = '$search_key';");
				while( $row = $query->fetch_assoc()){ //printing every user with that user name
					$id = $row['person_id'];
					
					//not printing own profile
					
					//printing friends
					$fquery = mysqli_query( $connect, "SELECT * FROM Friendship WHERE user1_id = '$id' OR user2_id = '$id');");
					while( $frow = $fquery->fetch_assoc()){ //for each friend
						echo( "<tr><td><a href='friend_profile.php?friend_id=".$row['person_id']."'>.$row['person_id'].</a></td></tr>");
					}
					
					//printing non-friends
					$nfquery = mysqli_query( $connect, "SELECT * FROM Friendship WHERE user1_id != '$id' OR user2_id != '$id');");
					while( $nfrow = $nfquery->fetch_assoc()){ //for each friend
						echo( "<tr><td><a href='nonfriend_profile.php?nonfriend_id=".$row['person_id']."'>.$row['person_id'].</a></td></tr>");
					}
					
					//printing blocked people
					$bquery = mysqli_query( $connect, "SELECT * FROM Blocks WHERE blocked_id = '$id');");
					while( $brow = $bquery->fetch_assoc()){ //for each friend
						echo( "<tr><td><a href='blocked_profile.php?blocked_id=".$row['person_id']."'>.$row['person_id'].</a></td></tr>");
					}
				}
			}
		}
		?>
	</body>
</html>
