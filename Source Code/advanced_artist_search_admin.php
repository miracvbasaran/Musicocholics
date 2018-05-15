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
	<title>Musicholics - Advanced Track Search</title>
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
          <li><a href="admin.php">Home</a></li>
          <li class="active"><a href="search_admin.php">Search</a></li>
          <li><a href="modify_track.php">Add Track</a></li>
          <li><a href="modify_album.php">Add Album</a></li>
          <li><a href="modify_artist.php">Add Artist</a></li>
          <li><a href="modify_publisher.php">Add Publisher</a></li>
        </ul>
        
        <ul class="nav navbar-nav navbar-right">
          <li><a href="change_password_admin.php"><span class="glyphicon glyphicon-user"></span> Change Password</a></li>
          <li><a href="homepage.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
      </div>
</nav>	  
	  <div class = "container" align = "center"><h2>
		
			<br/><br/>
			Advanced Artist Search</h2>
			<br/><br/>
	
		</div>
	  
	  	
		<div align = "center">
			<form action = "#" method = "post" onsubmit = "">
				
						Artist Name: <input type = "text" name = "search_key" placeholder = ""> <br/><br/>
					
					<input type = "radio" name="match" value="matches"/> Exactly matches &nbsp; &nbsp;
					<input type = "radio" name="match" value="contains"/> Contains &nbsp; &nbsp;
					<input type = "radio" name="match" value="starts_with"/> Starts with
					<br/><br/>
					
						Description: <input type = "text" name = "description" placeholder = "Description contains.."> <br/><br/>
						<input id = "" value = "Search" name = "search" type = "submit" class="btn btn-warning"> </button> <br/><br/>
				
					<br/><br/>
				</font>
			</form>
		</div>
		
		
    	  <div class = "container" align = "center"><h4>
    	
    			<br/><br/>
    			Results</h4>
    			<br/><br/>
    		
    		</div>
		
		
		<?php
	
		if( isset( $_POST['search'])){
			$search_key = mysqli_real_escape_string( $db, $_POST['search_key']);
			$match = mysqli_real_escape_string( $db, $_POST['match']);
			$description = mysqli_real_escape_string( $db, $_POST['description']);
			
			
			if( $search_key == "")
				echo ' <script type="text/javascript"> alert("Search will be done for any artist name"); </script>';
			if( $match == "")
				echo ' <script type="text/javascript"> alert("Select from Exactly matches, Contains, Starts with "); </script>';
			
	
			if( $match == "matches"){
				$query = mysqli_query( $db, "SELECT * FROM Artist WHERE ( artist_name LIKE '$search_key') 
																		AND description LIKE '%$description%';");
										
				while( $row = $query->fetch_assoc()){ 
					echo( "<div align = \"center\"><tr> <td><a href='modify_artist.php?artist_id=".$row['artist_id']."'>".$row['artist_name']."</a></td> </tr><br/></div>");
				}
			}
			else if( $match == "contains"){
				$query = mysqli_query( $db, "SELECT * FROM Artist WHERE ( artist_name LIKE '%$search_key%') 
																		AND description LIKE '%$description%';");
				while( $row = $query->fetch_assoc()){ 
					echo( "<div align = \"center\"><tr> <td><a href='modify_artist.php?artist_id=".$row['artist_id']."'>".$row['artist_name']."</a></td> </tr><br/></div>");
				}
			}
			else if( $match == "starts_with"){
				$query = mysqli_query( $db, "SELECT * FROM Artist WHERE ( artist_name LIKE '$search_key') 
																		AND description LIKE '%$description%';");
				while( $row = $query->fetch_assoc()){ 
					echo( "<div align = \"center\"><tr> <td><a href='modify_artist.php?artist_id=".$row['artist_id']."'>".$row['artist_id']."</a></td> </tr><br/></div>");
				}
			}
			
		}
		
		?>
		
		<div align = "center">
		<br/><br/>
			<tr><td><a href='search_admin.php'>Go back to main search page</a></td></tr>
		</div>
	
		<br/><br/><br/><br/><br/><br/><br/>
	


</body>
</html>




