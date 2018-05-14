<?php

include("session.php");

$uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
$query1 = "SELECT * FROM user WHERE user_id = '$uid' ";
$result1 = mysqli_query($db, $query1);
$user_array = mysqli_fetch_array($result1, MYSQLI_ASSOC);
	
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Musicholics - Advanced User Search</title>
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
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="change_general_information.php"><span class="glyphicon glyphicon-user"></span> Settings</a></li>
				<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
			</ul>
		</div>
		
		
		<div align = "center">
			<form action = "#" method = "post" onsubmit = "return check()">
				<font color="white">
					<br/><br/><br/><br/>MUSICHOLICS<br/><br/>Advanced User Search<br/><br/><br/><br/>
					<font color="black">
						<input type = "text" name = "username" placeholder = "Username"> <br/><br/>
					</font>
					<input type = "radio" name="match" value="matches"/> Exactly matches &nbsp; &nbsp;
					<input type = "radio" name="match" value="contains"/> Contains &nbsp; &nbsp;
					<input type = "radio" name="match" value="starts_with"/> Starts with <br/><br/><br/>
					<font color="black">
						<input type = "text" name = "fullname" placeholder = "Name"> <br/><br/>
					</font>
					<input type = "radio" name="country" value="Turkey"/> Turkey &nbsp; &nbsp;
					<input type = "radio" name="country" value="Germany"/> Germany
					<br/><br/>
					<input type = "radio" name="relationship" value="friend"/> Only friends &nbsp; &nbsp;
					<input type = "radio" name="relationship" value="all"/> All people 
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
				var username = document.getElementById( "username").value;
				var match = document.getElementById( "match").value;
				var fullname = document.getElementById( "name").value;
				var country = document.getElementById( "country").value;
				var relationship = document.getElementById( "relationship").value;

				if( username == "")
					alert( "Please type an username");
				if( match == "")
					alert( "Please one of \"Exactly matches\", \"Exactly Contains\", \"Starts with\"" );
				if( country == "")
					alert( "Please select a country");
				if( relationship == "")
					alert( "Please select your relationship with the user");
				
				location.href = "advanced_user_search.php";
			}
			</script>
		
		
			<?php
	
			if( isset( $_POST['search'])){
				$username = mysqli_real_escape_string( $db, $_POST['username']);
				$match = mysqli_real_escape_string( $db, $_POST['match']);
				$fullname = mysqli_real_escape_string( $db, $_POST['fullname']);
				$country = mysqli_real_escape_string( $db, $_POST['country']);
				$relationship = mysqli_real_escape_string( $db, $_POST['relationship']);
				
				$id_list = new SplDoublyLinkedList;
				
				if( $match == "matches"){
					$query = mysqli_query( $db, "SELECT * FROM Person, User WHERE (username LIKE '$username') 
																				AND user_id = person_id
																				AND country = '$country';");
					
					$id_list = new SplDoublyLinkedList;
					
					while( $row = $query->fetch_assoc()){ //printing every user with that user name
						$id = $row['person_id'];
						
						
						//not printing own profile
						if( $id != $uid){
							//printing friends
							$fquery = mysqli_query( $db, "SELECT * FROM Friendship WHERE (user1_id = '$uid' OR user2_id = '$uid') AND (user1_id = '$id' OR user2_id = '$id');");
							while( $frow = $fquery->fetch_assoc()){ //for each friend
								echo( "<tr><td><a href='friend_profile.php?friend_id=".$id."'>".$row['username']."</a></td></tr><br/>");
								$id_list->push($id);
							}
							
							
							//not printing blocked profiles
							$bquery = mysqli_query( $db, "SELECT * FROM Blocks WHERE (blocked_id = '$id' AND blocker_id = '$uid') OR (blocker_id = '$id' AND blocked_id = '$uid')");
							while( $brow = $bquery->fetch_assoc()){ //for each blocked/blocker
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
							
							if( $relationship == "all"){
								if( $id_count == $id_list->count()){ //not friend, not blocked -> non-friend
									echo( "<tr><td><a href='nonfriend_profile.php?nonfriend_id=".$id."'>".$row['username']."</a></td></tr><br/>");
								}
							}
							
						}
						
					}
				}
				
				if( $match == "contains"){
					$query = mysqli_query( $db, "SELECT * FROM Person, User WHERE (username LIKE '%$username%') 
																				AND user_id = person_id
																				AND country = '$country';");
					
					$id_list = new SplDoublyLinkedList;
					
					while( $row = $query->fetch_assoc()){ //printing every user with that user name
						$id = $row['person_id'];
						
						//not printing own profile
						if( $id != $uid){
							//printing friends
							$fquery = mysqli_query( $db, "SELECT * FROM Friendship WHERE (user1_id = '$uid' OR user2_id = '$uid') AND (user1_id = '$id' OR user2_id = '$id');");
							while( $frow = $fquery->fetch_assoc()){ //for each friend
								echo( "<tr><td><a href='friend_profile.php?friend_id=".$id."'>".$row['username']."</a></td></tr><br/>");
								$id_list->push($id);
							}
							
							
							//not printing blocked profiles
							$bquery = mysqli_query( $db, "SELECT * FROM Blocks WHERE (blocked_id = '$id' AND blocker_id = '$uid') OR (blocker_id = '$id' AND blocked_id = '$uid')");
							while( $brow = $bquery->fetch_assoc()){ //for each blocked/blocker
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
							
							if( $relationship == "all"){
								if( $id_count == $id_list->count()){ //not friend, not blocked -> non-friend
									echo( "<tr><td><a href='nonfriend_profile.php?nonfriend_id=".$id."'>".$row['username']."</a></td></tr><br/>");
								}
							}
							
						}
						
					}
				}
				
				if( $match == "starts_with"){
					$query = mysqli_query( $db, "SELECT * FROM Person, User WHERE (username LIKE '$username%') 
																				AND user_id = person_id
																				AND country = '$country';");
					
					$id_list = new SplDoublyLinkedList;
					
					while( $row = $query->fetch_assoc()){ //printing every user with that user name
						$id = $row['person_id'];
						
						
						//not printing own profile
						if( $id != $uid){
							//printing friends
							$fquery = mysqli_query( $db, "SELECT * FROM Friendship WHERE (user1_id = '$uid' OR user2_id = '$uid') AND (user1_id = '$id' OR user2_id = '$id');");
							while( $frow = $fquery->fetch_assoc()){ //for each friend
								echo( "<tr><td><a href='friend_profile.php?friend_id=".$id."'>".$row['username']."</a></td></tr><br/>");
								$id_list->push($id);
							}
							
							
							//not printing blocked profiles
							$bquery = mysqli_query( $db, "SELECT * FROM Blocks WHERE (blocked_id = '$id' AND blocker_id = '$uid') OR (blocker_id = '$id' AND blocked_id = '$uid')");
							while( $brow = $bquery->fetch_assoc()){ //for each blocked/blocker
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
							
							if( $relationship == "all"){
								if( $id_count == $id_list->count()){ //not friend, not blocked -> non-friend
									echo( "<tr><td><a href='nonfriend_profile.php?nonfriend_id=".$id."'>".$row['username']."</a></td></tr><br/>");
								}
							}
							
						}
						
					}
				}
					
			}
		
			?>
	
				<br/><br/><br/>
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
