<?php 
//include("session.php");

include("connection.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Musicholics - Sign In</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

	<nav class="navbar navbar-inverse">
		<div align = "center">
			<form action = "#" method = "post" onsubmit = "">
				<font color="white">
					<br/><br/><br/><br/>MUSICHOLICS<br/><br/>
					Sign In<br/><br/><br/><br/>
				</font>
				<input type = "text" name = "name" placeholder = "Username" >	<br/><br/>
				<input type = "password" name = "pass" placeholder = "Password"> <br/><br/>
				<input id = "" value = "Login" name = "login" type = "submit"> </button>
			</form>
		</div>
		
	
			<?php
		
			if( isset( $_POST['login'])){
				$username= $_POST['name'];
				$password = $_POST['pass'];
				
				if( $username == "")
					echo ' <script type="text/javascript"> alert("Fill in the username area"); </script>';
				else if( $password == "")
					echo ' <script type="text/javascript"> alert("Fill in the password area"); </script>';
				else if( mysqli_num_rows( mysqli_query( $db, "SELECT * FROM Person WHERE username = '$username';")) < 1){ //no matching username
					echo ' <script type="text/javascript"> alert("No such user exists"); </script>';
				} 
				else{ //if a user exists with that user name
					if( mysqli_num_rows( mysqli_query( $db, "SELECT * FROM Person WHERE password = '$password';")) != 1){ //incorrect password
						echo ' <script type="text/javascript"> alert("Incorrect password"); </script>';
					}
					else{
						
						$result = mysqli_query( $db, "SELECT person_id FROM Person WHERE username = '$username';");
						$array = mysqli_fetch_array($result, MYSQLI_ASSOC);
						$person_id = $array['person_id'];
						$_SESSION['login_id'] = $person_id;
					
						$array = mysqli_query( $db, "SELECT * FROM User WHERE user_id = '$person_id'");
					
						if( mysqli_num_rows( mysqli_query( $db, "SELECT * FROM User WHERE user_id = '$person_id'")) == 1){ //person is a user
							$_SESSION['login_user'] = $username;
							header( "Location: own_profile.php");
							exit();
						}
						else if( mysqli_num_rows( mysqli_query( $db, "SELECT * FROM Admin WHERE admin_id = '$person_id'")) == 1){ //person is an admin
							$_SESSION['login_user'] = $username;
							header( "Location: admin.php");
							exit();
						}
						else //some weird error
							echo ' <script type="text/javascript"> alert("ID is not related to a user or an admin profile."); </script>';
					}
				}
			}	
			
			?>
		</nav>
	</body>
	</html>