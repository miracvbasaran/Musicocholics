<?php 
include("session.php");
include("connection.php");
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
				<li><a href="view_playlists.php">Playlist</a></li>
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
					<br/><br/><br/><br/>MUSICHOLICS<br/><br/>Advanced User Search<br/><br/><br/><br/>
					<input type = "text" name = "username" placeholder = "Username"> <br/><br/>
					<input type = "radio" name="match" value="matches"/> Exactly matches &nbsp; &nbsp;
					<input type = "radio" name="match" value="contains"/> Contains &nbsp; &nbsp;
					<input type = "radio" name="match" value="starts_with"/> Starts with <br/><br/><br/>
					<input type = "text" name = "fullname" placeholder = "Name"> <br/><br/>
					<input type = "radio" name="country" value="tr"/> Turkey &nbsp; &nbsp;
					<input type = "radio" name="country" value="gb"/> Global &nbsp; &nbsp;
					<br/><br/>
					<input type = "radio" name="gender" value="f"/> Female &nbsp; &nbsp;
					<input type = "radio" name="gender" value="m"/> Male &nbsp; &nbsp;
					<input type = "radio" name="gender" value="n"/> Nonbinary gender
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
				if( fullname = "")
					alert( "Please type full name");
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
			$id = $_SESSION['login_id'];
			
			if( $relationship == "friend"){ //searching a friend
				if( $match == "matches"){
					$fquery = mysqli_query( $db, "SELECT * FROM Friendship WHERE user1_id = '$id';"); //user2 is the friend
					while( $frow = $fquery->fetch_assoc()){ 
						$upquery = mysqli_query( $db, "SELECT * FROM User, Person WHERE user_id = '$frow['user2_id']' 
																					AND person_id = '$frow['user2_id']' 
																					AND ( username LIKE '$username') 
																					AND country = '$country';"); //id is unique, so only one row
						$uprow = $upquery->fetch_assoc();
						echo( "<tr><td><a href='friend_profile.php?friend_id=".$uprow['user_id']."'>.$uprow['user_id'].</a></td></tr>");
					}
					
					
					$fquery = mysqli_query( $db, "SELECT * FROM Friendship WHERE user2_id = '$id';"); //user2 is the friend
					while( $frow = $fquery->fetch_assoc()){ 
						$upquery = mysqli_query( $db, "SELECT * FROM User, Person WHERE user_id = '$frow['user1_id']' 
																					AND person_id = '$frow['user1_id']' 
																					AND ( username LIKE '$username') 
																					AND country = '$country';"); //id is unique, so only one row
						$uprow = $upquery->fetch_assoc();
						echo( "<tr><td><a href='friend_profile.php?friend_id=".$uprow['user_id']."'>.$uprow['user_id'].</a></td></tr>");
					}
				}
				else if( $match == "contains"){
					$fquery = mysqli_query( $db, "SELECT * FROM Friendship WHERE user1_id = '$id';"); //user2 is the friend
					while( $frow = $fquery->fetch_assoc()){ 
						$upquery = mysqli_query( $db, "SELECT * FROM User, Person WHERE user_id = '$frow['user2_id']' 
																					AND person_id = '$frow['user2_id']' 
																					AND ( username LIKE '%$username%') 
																					AND country = '$country';"); //id is unique, so only one row
						$uprow = $upquery->fetch_assoc();
						echo( "<tr><td><a href='friend_profile.php?friend_id=".$uprow['user_id']."'>.$uprow['user_id'].</a></td></tr>");
					}
					
					
					$fquery = mysqli_query( $db, "SELECT * FROM Friendship WHERE user2_id = '$id';"); //user2 is the friend
					while( $frow = $fquery->fetch_assoc()){ 
						$upquery = mysqli_query( $db, "SELECT * FROM User, Person WHERE user_id = '$frow['user1_id']' 
																					AND person_id = '$frow['user1_id']' 
																					AND ( username LIKE '%$username%') 
																					AND country = '$country';"); //id is unique, so only one row
						$uprow = $upquery->fetch_assoc();
						echo( "<tr><td><a href='friend_profile.php?friend_id=".$uprow['user_id']."'>.$uprow['user_id'].</a></td></tr>");
					}
				}
				else if( $match == "starts_with"){
					$fquery = mysqli_query( $db, "SELECT * FROM Friendship WHERE user1_id = '$id';"); //user2 is the friend
					while( $frow = $fquery->fetch_assoc()){ 
						$upquery = mysqli_query( $db, "SELECT * FROM User, Person WHERE user_id = '$frow['user2_id']' 
																					AND person_id = '$frow['user2_id']' 
																					AND ( username LIKE '$username%') 
																					AND country = '$country';"); //id is unique, so only one row
						$uprow = $upquery->fetch_assoc();
						echo( "<tr><td><a href='friend_profile.php?friend_id=".$uprow['user_id']."'>.$uprow['user_id'].</a></td></tr>");
					}
					
					
					$fquery = mysqli_query( $db, "SELECT * FROM Friendship WHERE user2_id = '$id';"); //user2 is the friend
					while( $frow = $fquery->fetch_assoc()){ 
						$upquery = mysqli_query( $db, "SELECT * FROM User, Person WHERE user_id = '$frow['user1_id']' 
																					AND person_id = '$frow['user1_id']' 
																					AND ( username LIKE '$username%') 
																					AND country = '$country';"); //id is unique, so only one row
						$uprow = $upquery->fetch_assoc();
						echo( "<tr><td><a href='friend_profile.php?friend_id=".$uprow['user_id']."'>.$uprow['user_id'].</a></td></tr>");
					}
				}
			}
			else if( $relationship == "all"){ //searching all people
				if( $match == "matches"){
					$upquery = mysqli_query( $db, "SELECT * FROM User, Person WHERE ( username LIKE '$username') 
																				AND country = '$country';");
					$uprow = $upquery->fetch_assoc();
					echo( "<tr><td><a href='friend_profile.php?friend_id=".$uprow['user_id']."'>.$uprow['user_id'].</a></td></tr>");
				}
				else if( $match == "contains"){
					$upquery = mysqli_query( $db, "SELECT * FROM User, Person WHERE ( username LIKE '%$username%') 
																				AND country = '$country';");
					$uprow = $upquery->fetch_assoc();
					echo( "<tr><td><a href='friend_profile.php?friend_id=".$uprow['user_id']."'>.$uprow['user_id'].</a></td></tr>");
				}
				else if( $match == "starts_with"){
					$upquery = mysqli_query( $db, "SELECT * FROM User, Person WHERE ( username LIKE '$username%') 
																				AND country = '$country';");
					$uprow = $upquery->fetch_assoc();
					echo( "<tr><td><a href='friend_profile.php?friend_id=".$uprow['user_id']."'>.$uprow['user_id'].</a></td></tr>");
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
