<?php 
	include("session.php");
	include("connection.php");
?>

<html>
	<head>
		<title>Login</title>
	</head>
	<body>
		<div align = "center">
			<form action = "#" method = "post" onsubmit = "return check()">
	          	<br/><br/><br/><br/>MUSICHOLICS<br/><br/>
	   		 	SIGN IN<br/><br/><br/><br/>
				Username: <input type = "text" name = "name">	<br/><br/>
				Password: <input type = "text" name = "pass"> <br/><br/>
				<input id = "" value = "Login" name = "login" type = "submit"> </button>
			</form>
		</div>
		
		<script type = "text/javascript">
			function check(){
				var username = document.getElementById( "name").value;
				var password = document.getElementById( "pass").value;

				if( username == "" && password == "")
					alert( "Please enter your customer ID password");
				else if( name == "")
					alert( "Enter Username");
				else if( password == "")
					alert( "Enter password");
				location.href = "login.php";
			}
		</script>
	
		<?php
		
		if( isset( $_POST['login'])){
			if( mysql_num_rows( mysqli_query( $db, "SELECT * FROM Person WHERE username = '$username';")) < 1) //no matching username
				echo( "No such user exists.");
			else{ //if a user exists with that user name
				if( mysql_num_rows( mysqli_query( $db, "SELECT * FROM Person WHERE password = '$password';")) != 1){ //incorrect password
					echo( "Incorrect password.");
					break;
				}
				else{
					$username = mysqli_real_escape_string( $db, $_POST['name']);
					$password = mysqli_real_escape_string( $db, $_POST['pass']);
					$array = mysqli_query( $db, "SELECT person_id FROM Person WHERE username = '$username';");
					$person_id = $array['person_id'];
					$_SESSION['login_id'] = $person_id;
					
					$array = mysqli_query( $db, "SELECT * FROM User WHERE user_id = '$person_id'");
					
					if( mysql_num_rows( mysqli_query( $db, "SELECT * FROM User WHERE user_id = '$person_id'")) == 1){ //person is a user
						//$_SESSION['member_type'] = "user";
						header( "Location: own_profile.php");
						exit();
					}
					else if( mysql_num_rows( mysqli_query( $db, "SELECT * FROM Admin WHERE admin_id = '$person_id'")) == 1){ //person is an admin
						//$_SESSION['member_type'] = "admin";
						header( "Location: admin.php");
						exit();
					}
					else //some weird error
						echo( "ID is not related to a user or an admin profile.");
				}
			}
		}	
			
		?>
	</body>
</html>