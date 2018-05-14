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
      <div class="container-fluid">
        <ul class="nav navbar-nav">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="search_admin.php">Search</a></li>
          <li><a href="add_track.php">Add Track</a></li>
          <li><a href="add_album.php">Add Album</a></li>
          <li><a href="add_artist.php">Add Artist</a></li>
          <li><a href="add_publisher.php">Add Publisher</a></li>
        </ul>
        
        <ul class="nav navbar-nav navbar-right">
          <li><a href="change_password_admin.php"><span class="glyphicon glyphicon-user"></span> Change Password</a></li>
          <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
      </div>
    </nav>
	
		<div align = "center">
			<form action = "#" method = "post">
				<font color="white">
					<br/><br/><br/><br/>MUSICHOLICS<br/><br/>Search<br/><br/><br/><br/>
					
					<font color="black">
						<input type = "text" name = "search_key" placeholder = "Search.."> 
						<input id = "" value = "Search" name = "search" type = "submit"> </button> <br/><br/>
					</font>
					<input type="checkbox" name="filter_track" value="track"/> Track &nbsp;&nbsp;
					<tr><td><a href='advanced_track_search_admin.php'> Advanced Track Search</a></td></tr><br/>
					<input type="checkbox" name="filter_album" value="album"/> Album &nbsp;&nbsp;
					<tr><td><a href='advanced_album_search_admin.php'> Advanced Album Search</a></td></tr><br/>
					<input type="checkbox" name="filter_artist" value="artist"/> Artist &nbsp;&nbsp; 
					<tr><td><a href='advanced_artist_search_admin.php'> Advanced Artist Search</a></td></tr><br/>
					<input type="checkbox" name="filter_playlist" value="playlist"/> Playlist &nbsp;&nbsp; 
					<tr><td><a href='advanced_playlist_search_admin.php'> Advanced Playlist Search</a></td></tr><br/>
					<input type="checkbox" name="filter_user" value="user"/> User &nbsp;&nbsp; 
					<tr><td><a href='advanced_user_search_admin.php'> Advanced User Search</a></td></tr><br/><br/>
				</font>
			</form>
		</div>

				<?php
	
				if( isset( $_POST['search'])){
					$search_key = mysqli_real_escape_string( $db, $_POST['search_key']);
					//echo( "<tr> <td>".$search_key."</td> </tr><br/>");
					//echo( "<tr> <td>".$filter."</td> </tr><br/>");
					
					if( $search_key == "")
						echo ' <script type="text/javascript"> alert("Please type an album name"); </script>';
					
					
					if( isset( $_POST['filter_track'])){//TRACK
						$query = mysqli_query( $db, "SELECT * FROM Track WHERE track_name LIKE '%$search_key%';");
						while( $row = $query->fetch_assoc()){ //printing every track with that track name
							echo( "<tr> <td><a href='access_track.php?track_id=".$row['track_id']."'>".$row['track_name']."</a></td> </tr><br/>");
						}
					}
					if( isset( $_POST['filter_album'])){ //ALBUM
						$query = mysqli_query( $db, "SELECT * FROM Album WHERE album_name LIKE '%$search_key%';");
						while( $row = $query->fetch_assoc()){ //printing every album with that album name
							echo( "<tr> <td><a href='access_album.php?album_id=".$row['album_id']."'>".$row['album_name']."</a></td> </tr><br/>");
						}
					}
					if( isset( $_POST['filter_artist'])){ //ARTIST
						$query = mysqli_query( $db, "SELECT * FROM Artist WHERE artist_name LIKE '%$search_key%';");
						while( $row = $query->fetch_assoc()){ //printing every artist with that artist name
							echo( "<tr><td><a href='access_artist.php?artist_id=".$row['artist_id']."'>".$row['artist_name']."</a></td></tr><br/>");
						}
					}
					if( isset( $_POST['filter_playlist'])){ //PLAYLIST
						$query = mysqli_query( $db, "SELECT * FROM Playlist WHERE playlist_name LIKE '%$search_key%';");
						while( $row = $query->fetch_assoc()){ //printing every playlist with that playlist name
							echo( "<tr><td><a href='access_playlist.php?playlist_id=".$row['playlist_id']."'>".$row['playlist_name']."</a></td></tr><br/>");
						}
					}
					if( isset( $_POST['filter_user'])){ //USER
						$query = mysqli_query( $db, "SELECT * FROM Person, User WHERE (username LIKE '%$search_key%') AND user_id = person_id;");
						while( $row = $query->fetch_assoc()){ //printing every user with that user name
							echo( "<tr><td><a href='complete_profile.php?view_id=".$row['username']."'>".$row['user_id']."</a></td></tr><br/>");
						}
					}
				}
		
				?>
	
		<br/><br/><br/>
	</nav>
</body>
</html>
