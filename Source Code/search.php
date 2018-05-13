<?php 
include("session.php");
include("connection.php");
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
		<div class="container-fluid">
			<ul class="nav navbar-nav">
				<li><a href="own_profile.php">Profile</a></li>
				<li><a href="playlists.php">Playlist</a></li>
				<li><a href="view_tracks.php">Tracks</a></li>
				<li><a href="friends.php">Friends</a></li>
				<li><a href="message_list.php">Messages</a></li>
				<li class="active"><a href="#">Search</a></li>
				<li><a href="change_general_information.php">Settings</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>

	
		<div align = "center">
			<form action = "#" method = "post">
				<font color="white">
					<br/><br/><br/><br/>MUSICHOLICS<br/><br/>Search<br/><br/><br/><br/>
					<input type = "text" name = "search_key" placeholder = "Search.."> 
					<font color="black">
						<input id = "" value = "Search" name = "search" type = "submit"> </button> <br/><br/>
					</font>
					<input type="radio" name="filter" value="all"/>All &nbsp; &nbsp;
					<input type="radio" name="filter" value="track"/>Track &nbsp; &nbsp;
					<input type="radio" name="filter" value="album"/>Song &nbsp; &nbsp;
					<input type="radio" name="filter" value="artist"/>Artist &nbsp; &nbsp;
					<input type="radio" name="filter" value="playlist"/>Playlist &nbsp; &nbsp;
					<input type="radio" name="filter" value="user"/>User<br/>
				</font>
			</form>
		</div>

		<?php
	
		if( isset( $_POST['search'])){
			$search_key = mysqli_real_escape_string( $dbion, $_POST['search_key']);
			$filter = mysqli_real_escape_string( $dbion, $_POST['filter']);
		
			if( $filter == "track" || $filter == "all"){ //TRACK
				$query = "SELECT * FROM Track WHERE track_name LIKE '%$search_key%'";
				while( $row = $query->fetch_assoc()){ //printing every track with that track name
					echo( "<tr> <td><a href='track.php?track_id=".$row['track_id']."'>.$row['track_id'].</a></td> </tr>");
				}
			}
			else if( $filter == "album" || $filter == "all"){ //ALBUM
				$query = "SELECT * FROM Album WHERE album_name LIKE '%$search_key%'";
				while( $row = $query->fetch_assoc()){ //printing every album with that album name
					echo( "<tr> <td><a href='album.php?album_id=".$row['album_id']."'>.$row['album_id'].</a></td> </tr>");
				}
			}
			else if( $filter == "artist" || $filter == "all"){ //ARTIST
				$query = "SELECT * FROM Artist WHERE artist_name LIKE '%$search_key%'";
				while( $row = $query->fetch_assoc()){ //printing every artist with that artist name
					echo( "<tr><td><a href='artist.php?artist_id=".$row['artist_id']."'>.$row['artist_id'].</a></td></tr>");
				}
			}
			else if( $filter == "playlist" || $filter == "all"){ //PLAYLIST
				$query = "SELECT * FROM Album WHERE album_name LIKE '%$search_key%'";
				while( $row = $query->fetch_assoc()){ //printing every playlist with that playlist name
					echo( "<tr><td><a href='playlist.php?playlist_id=".$row['playlist_id']."'>.$row['playlist_id'].</a></td></tr>");
				}
			}
			else if( $filter == "user" || $filter == "all"){ //USER
				$query = mysqli_query( $db, "SELECT * FROM Person NATURAL JOIN User WHERE username LIKE '%$search_key%';");
				while( $row = $query->fetch_assoc()){ //printing every user with that user name
					$id = $row['person_id'];
					
					//printing friends
					$fquery = mysqli_query( $db, "SELECT * FROM Friendship WHERE user1_id = '$id' OR user2_id = '$id');");
					while( $frow = $fquery->fetch_assoc()){ //for each friend
						echo( "<tr><td><a href='friend_profile.php?friend_id=".$frow['person_id']."'>.$frow['person_id'].</a></td></tr>");
					}
				
					//not printing own profile
					//printing non-friends
					if( $query['person_id'] != id){
						$nfquery = mysqli_query( $db, "SELECT * FROM Friendship WHERE user1_id != '$id' AND user2_id != '$id');");
						while( $nfrow = $nfquery->fetch_assoc()){ //for each friend
							echo( "<tr><td><a href='nonfriend_profile.php?nonfriend_id=".$nfrow['person_id']."'>.$nfrow['person_id'].</a></td></tr>");
						}
					}
				
					//printing blocked people ?????
					$bquery = mysqli_query( $db, "SELECT * FROM Blocks WHERE blocked_id = '$id');");
					while( $brow = $bquery->fetch_assoc()){ //for each friend
						echo( "<tr><td><a href='blocked_profile.php?blocked_id=".$brow['person_id']."'>.$brow['person_id'].</a></td></tr>");
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
