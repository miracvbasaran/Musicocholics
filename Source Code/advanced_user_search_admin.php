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
          <li class="active"><a href="#">Home</a></li>
          <li><a href="search_admin.php">Search</a></li>
          <li><a href="add_track.php">Add Track</a></li>
          <li><a href="add_album.php">Add Album</a></li>
          <li><a href="add_artist.php">Add Artist</a></li>
          <li><a href="add_publisher.php">Add Publisher</a></li>
        </ul>
        
        <ul class="nav navbar-nav navbar-right">
          <li><a href="change_password.php"><span class="glyphicon glyphicon-user"></span> Change Password</a></li>
          <li><a href="homepage.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
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

				if( username == "")
					alert( "Please type an username");
				if( match == "")
					alert( "Please one of \"Exactly matches\", \"Exactly Contains\", \"Starts with\"" );
				if( country == "")
					alert( "Please select a country");
				
				location.href = "advanced_user_search.php";
			}
			</script>
		
		
			<?php
	
			if( isset( $_POST['search'])){
				$username = mysqli_real_escape_string( $db, $_POST['username']);
				$match = mysqli_real_escape_string( $db, $_POST['match']);
				$fullname = mysqli_real_escape_string( $db, $_POST['fullname']);
				$country = mysqli_real_escape_string( $db, $_POST['country']);
				
				$id_list = new SplDoublyLinkedList;
				
				if( $match == "matches"){
					$query = mysqli_query( $db, "SELECT * FROM Person, User WHERE (username LIKE '$search_key') 
																				AND user_id = person_id
																				AND country = '$country';");
					while( $row = $query->fetch_assoc()){ //printing every user with that user name
						echo( "<tr><td><a href='complete_profile.php?view_id=".$row['user_id']."'>".$row['username']."</a></td></tr><br/>");
					}
					
				}
				
				if( $match == "contains"){
					$query = mysqli_query( $db, "SELECT * FROM Person, User WHERE (username LIKE '%$search_key%') 
																				AND user_id = person_id
																				AND country = '$country';");
					while( $row = $query->fetch_assoc()){ //printing every user with that user name
						echo( "<tr><td><a href='complete_profile.php?view_id=".$row['user_id']."'>".$row['username']."</a></td></tr><br/>");
					}
																				
				}
				
				if( $match == "starts_with"){
					$query = mysqli_query( $db, "SELECT * FROM Person, User WHERE (username LIKE '$search_key%') 
																				AND user_id = person_id
																				AND country = '$country';");
					while( $row = $query->fetch_assoc()){ //printing every user with that user name
						echo( "<tr><td><a href='complete_profile.php?view_id=".$row['user_id']."'>".$row['username']."</a></td></tr><br/>");
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
