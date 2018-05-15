<?php
	error_reporting(E_ALL & ~E_NOTICE);

	include("session.php");

    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
    $query1 = "SELECT * FROM user WHERE user_id = '$uid' ";
    $result1 = mysqli_query($db, $query1);
    $user_array = mysqli_fetch_array($result1, MYSQLI_ASSOC);

	if (isset($_POST['addplaylist_button'])) {
    	
    }

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
				<li><a href="view_playlists.php">Playlist</a></li>
				<li><a href="view_tracks.php">Tracks</a></li>
				<li><a href="friends.php">Friends</a></li>
				<li><a href="message_list.php">Messages</a></li>
				<li class="active"><a href="search.php">Search</a></li>
			</ul>
		    <ul class="nav navbar-nav navbar-right">
				<li><a href="change_general_information.php"><span class="glyphicon glyphicon-user"></span> Settings</a></li>
				<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
		    </ul>
		</div>
</nav>
		  <div class = "container" align = "center"><h2>
			
				<br/><br/>
				Search</h2>
				<br/><br/>
			
			</div>
	
		<div align = "center">
			<form action = "#" method = "post">
			
						<input type = "text" name = "search_key" placeholder = "Search.."> 
						<input id = "" value = "Search" name = "search" type = "submit" class="btn btn-warning" > </button> <br/><br/>
					
					<input type="checkbox" name="filter_track" value="track"/> Track 
					
					<input type="checkbox" name="filter_album" value="album"/> Album 
					
					<input type="checkbox" name="filter_artist" value="artist"/> Artist 
					
					<input type="checkbox" name="filter_playlist" value="playlist"/> Playlist 
					
					<input type="checkbox" name="filter_user" value="user"/> User 
					 <br><br>
					<tr><td><a href='advanced_track_search.php' class="btn btn-info" > Advanced Track Search</a></td></tr><br/><br>
					<tr><td><a href='advanced_album_search.php' class="btn btn-info"> Advanced Album Search</a></td></tr><br/><br>
					<tr><td><a href='advanced_artist_search.php' class="btn btn-info"> Advanced Artist Search</a></td></tr><br/><br>
					<tr><td><a href='advanced_playlist_search.php' class="btn btn-info"> Advanced Playlist Search</a></td></tr><br/><br>
					<tr><td><a href='advanced_user_search.php' class="btn btn-info" > Advanced User Search</a></td></tr><br/><br/><br>

				
			</form>
		</div>
		
		
	  <div class = "container" align = "center"><h4>
	
			<br/><br/>
			RESULTS</h4>
			<br/><br/>
		
		</div>

				<?php
	
				if( isset( $_POST['search'])){
					$search_key = mysqli_real_escape_string( $db, $_POST['search_key']);
					
					if( $search_key == "")
						echo ' <script type="text/javascript"> alert("Search will be done with an empty key"); </script>';
					

					//$filter = mysqli_real_escape_string( $db, $_POST['filter']);
					//echo( "<tr> <td>".$search_key."</td> </tr><br/>");
					//echo( "<tr> <td>".$filter."</td> </tr><br/>");
		
					if( isset( $_POST['filter_track'])){//TRACK
						$query = mysqli_query( $db, "SELECT * FROM Track WHERE track_name LIKE '%$search_key%';");
						while( $row = $query->fetch_assoc()){ //printing every track with that track name
							echo( "<div align = \"center\"><tr> <td><a href='view_track.php?track_id=".$row['track_id']."'>".$row['track_name']."</a></td> </tr><br/></div>");
						}
					}
					if( isset( $_POST['filter_album'])){ //ALBUM
						$query = mysqli_query( $db, "SELECT * FROM Album WHERE album_name LIKE '%$search_key%';");
						while( $row = $query->fetch_assoc()){ //printing every album with that album name
							echo( "<div align = \"center\"><tr> <td><a href='view_album.php?album_id=".$row['album_id']."'>".$row['album_name']."</a></td> </tr><br/></div>");
						}
					}
					if( isset( $_POST['filter_artist'])){ //ARTIST
						$query = mysqli_query( $db, "SELECT * FROM Artist WHERE artist_name LIKE '%$search_key%';");
						while( $row = $query->fetch_assoc()){ //printing every artist with that artist name
							echo( "<div align = \"center\"><tr><td><a href='view_artist.php?artist_id=".$row['artist_id']."'>".$row['artist_name']."</a></td></tr><br/></div>");
						}
					}
					if( isset( $_POST['filter_playlist'])){ //PLAYLIST
						$query = mysqli_query( $db, "SELECT * FROM Playlist WHERE playlist_name LIKE '%$search_key%';");
						while( $row = $query->fetch_assoc()){ //printing every playlist with that playlist name
							$query2 = mysqli_query( $db, "SELECT * FROM Playlist WHERE playlist_id = {$row['playlist_id']} AND creator_id = {$u_id};");
							if($query2){
								echo( "<div align = \"center\"><tr><td><a href='view_own_playlist.php?playlist_id=".$row['playlist_id']."'>".$row['playlist_name']."</a></td></tr><br/></div>");
							}
							else{
								echo( "<div align = \"center\"><tr><td><a href='view_others_playlist.php?playlist_id=".$row['playlist_id']."'>".$row['playlist_name']."</a></td></tr><br/></div>");
							}
							
						}
					}
					if( isset( $_POST['filter_user'])){ //USER
						$query = mysqli_query( $db, "SELECT * FROM Person, User WHERE (username LIKE '%$search_key%') AND user_id = person_id;");
						
						$id_list = new SplDoublyLinkedList;
						
						while( $row = $query->fetch_assoc()){ //printing every user with that user name
							$id = $row['person_id'];
							
							
							//not printing own profile
							if( $id != $uid){
								//printing friends
								$fquery = mysqli_query( $db, "SELECT * FROM Friendship WHERE (user1_id = '$uid' OR user2_id = '$uid') AND (user1_id = '$id' OR user2_id = '$id');");
								while( $frow = $fquery->fetch_assoc()){ //for each friend
									echo( "<div align = \"center\"><tr><td><a href='friend_profile.php?other_id=".$id."'>".$row['username']."</a></td></tr><br/></div>");
									$id_list->push($id);
								}
								
								//not printing blocker profiles
								$bquery = mysqli_query( $db, "SELECT * FROM Blocks WHERE (blocker_id = '$id' AND blocked_id = '$uid');");
								while( $brow = $bquery->fetch_assoc()){ //for each blocked/blocker
									$id_list->push($id);
								}
								
								//printing blocked profiles
								$bquery = mysqli_query( $db, "SELECT * FROM Blocks WHERE (blocked_id = '$id' AND blocker_id = '$uid') AND (blocker_id != '$id' OR blocked_id != '$uid')");
								while( $brow = $bquery->fetch_assoc()){ //for each blocked/blocker
									echo( "<div align = \"center\"><tr><td><a href='blocked_profile.php?other_id=".$id."'>".$row['username']."</a></td></tr><br/></div>");
									$id_list->push($id);
								}
								
								//printing non-friends
								$id_count = $id_list->count();
								for( $i = 0; $i < $id_count; $i++){
									if( $id_list->bottom() != $id){
										$id_list->shift();
										$id_list->push( $id);
									}
									else{
										$id_list->shift(); 
									}
										
								}
								if( $id_count == $id_list->count()){ //not friend, not blocked -> non-friend
									echo( "<div align = \"center\"><tr><td><a href='nonfriend_profile.php?other_id=".$id."'>".$row['username']."</a></td></tr><br/></div>");
								}
								
							}
							
						}
					}
				}
		
				?>
	
		<br/><br/><br/><br/><br/><br/>
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
