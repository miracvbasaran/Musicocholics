<?php
error_reporting(E_ALL & ~E_NOTICE);

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
          <li><a href="change_password_admin.php"><span class="glyphicon glyphicon-user"></span> Change Password</a></li>
          <li><a href="homepage.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
      </div>
		
  	  <div class = "container" align = "center"><h2>
  		<font color="white">
  			<br/><br/>
  			Advanced User Search</h2>
  			<br/><br/>
  		</font>
  		</div>
		
		
		<div align = "center">
			<form action = "#" method = "post" onsubmit = "">
				<font color="white">
					<font color="black">
						<input type = "text" name = "username" placeholder = "Username"> <br/><br/>
					</font>
					<input type = "radio" name="match" value="matches"/> Exactly matches &nbsp; &nbsp;
					<input type = "radio" name="match" value="contains"/> Contains &nbsp; &nbsp;
					<input type = "radio" name="match" value="starts_with"/> Starts with <br/><br/><br/>
					<font color="black">
						<input type = "text" name = "fullname" placeholder = "Name contains.."> <br/><br/>
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
		
	  <div class = "container" align = "center"><h4>
		<font color="white">
			<br/><br/>
			Results</h4>
			<br/><br/>
		</font>
		</div>	
		
			<?php
	
			if( isset( $_POST['search'])){
				$username = mysqli_real_escape_string( $db, $_POST['username']);
				$match = mysqli_real_escape_string( $db, $_POST['match']);
				$fullname = mysqli_real_escape_string( $db, $_POST['fullname']);
				$country = mysqli_real_escape_string( $db, $_POST['country']);
				
				
				if( $search_key == "")
					echo ' <script type="text/javascript"> alert("Search will be done using for any username"); </script>';
				if( $match == "")
					echo ' <script type="text/javascript"> alert("Select from Exactly matches, Contains, Starts with "); </script>';
				if( $fullname == "")
					echo ' <script type="text/javascript"> alert("Search will be done using any name"); </script>';
				if( $country == "")
					echo ' <script type="text/javascript"> alert("Select a country "); </script>';
				
				
				$id_list = new SplDoublyLinkedList;
				
				if( $match == "matches"){
					$query = mysqli_query( $db, "SELECT * FROM Person, User WHERE (username LIKE '$search_key') 
																				AND user_id = person_id
																				AND country = '$country';");
					while( $row = $query->fetch_assoc()){ //printing every user with that user name
						echo( "<div align = \"center\"><tr><td><a href='complete_profile.php?view_id=".$row['user_id']."'>".$row['username']."</a></td></tr><br/></div>");
					}
					
				}
				
				if( $match == "contains"){
					$query = mysqli_query( $db, "SELECT * FROM Person, User WHERE (username LIKE '%$search_key%') 
																				AND user_id = person_id
																				AND country = '$country';");
					while( $row = $query->fetch_assoc()){ //printing every user with that user name
						echo( "<div align = \"center\"><tr><td><a href='complete_profile.php?view_id=".$row['user_id']."'>".$row['username']."</a></td></tr><br/></div>");
					}
																				
				}
				
				if( $match == "starts_with"){
					$query = mysqli_query( $db, "SELECT * FROM Person, User WHERE (username LIKE '$search_key%') 
																				AND user_id = person_id
																				AND country = '$country';");
					while( $row = $query->fetch_assoc()){ //printing every user with that user name
						echo( "<div align = \"center\"><tr><td><a href='complete_profile.php?view_id=".$row['user_id']."'>".$row['username']."</a></td></tr><br/></div>");
					}
				}
					
			}
		
			?>
			
			<div align = "center">
				<tr><td><a href='search_admin.php'>Go back to main search page</a></td></tr>
			</div>
	
				<br/><br/><br/>

		</body>
		</html>
