<?php session_start(); ?>

<html>
	<head>
		<title>Register</title>
	</head>
	<body>
		<div align = "center">
			<form action = "#" method = "post" onsubmit = "return check()">
	          	<br/><br/><br/><br/>MUSICHOLICS<br/><br/>
	   		 	Register<br/><br/><br/><br/>
				<input type = "text" name = "name" placeholder = "Name"> <br/><br/>
				<input type = "text" name = "username" placeholder = "Username"> <br/><br/>
				<input type = "text" name = "pass" placeholder = "Password"> <br/><br/>
				<input type = "text" name = "email" placeholder = "E-mail address"> <br/><br/>
				<select name="country">
				  <option value="Country">Country</option>
				  <option value="tr">Turkey</option>
				  <option value="gb">Global</option>
				</select>
				<br/><br/>
				<select name="language">
				  <option value="Language">Language</option>
				  <option value="tr">Turkish</option>
				  <option value="en">English</option>
				</select>
				<br/><br/>
				Birth date: <input type="date" name="bday"><br/><br/>
				<select name="gender">
				  <option value="Gender">Gender</option>
				  <option value="M">Male</option>
				  <option value="F">Female</option>
				  <option value="NB">Non-binary</option>
				</select>
				<br/><br/>
				Path of the picture: <input type = "text" name = "picture_path"><br/><br/>
				<input type="checkbox" name="agreed"> I agree to terms and conditions<br/><br/>
				<input id = "" value = "Register" name = "register" type = "submit"> </button>
			</form>
		</div>
		
		<script type = "text/javascript">
			function check(){
				var realname = document.getElementById( "name").value;
				var username = document.getElementById( "username").value;
				var password = document.getElementById( "pass").value;
				var email = document.getElementById( "email").value;
				var country = document.getElementById( "country").value;
				var language = document.getElementById( "language").value;
				var day = document.getElementById( "day").value;
				var month = document.getElementById( "month").value;
				var year = document.getElementById( "year").value;
				var gender = document.getElementById( "gender").value;

				if( realname = "" || username == "" || password == "" || email = "" 
				   || country = "Country" || language = "Language" || day = "" 
				   || month = "" || year = "" || gender = "Gender")
					alert( "Please fill all fields.");
				else 
					return true;
				location.href = "register.php";
			}
		</script>
		
	
		<?php
		$hostname = ""; 
		$username = "";
		$password = "";
		$connect = mysqli_connect( $hostname, $username, $password, $username) or die( "MySQL connection error");
		if( mysqli_connect_errno())
			echo "Failed to connect to MySQL: ".mysqli_connect_error();
		
		if( isset( $_POST['register'])){
			if( isset( $_POST['agreed'])){
				//fullname
				$fullname = trim($_POST['name']);
				$fullname = strip_tags($fullname);
				$fullname = htmlspecialchars($fullname);
				//username
				$username = trim($_POST['username']);
				$username = strip_tags($username);
				$username = htmlspecialchars($username);
				//password
				$password = trim($_POST['pass']);
				$password = strip_tags($password);
				$password = htmlspecialchars($password);
				//email
				$email = trim($_POST['username']);
				$email = strip_tags($email);
				$email = htmlspecialchars($email);
				//person_id & user_id
				$id = NULL;
				//country
				$country = trim($_POST['username']);
				$country = strip_tags($country);
				$country = htmlspecialchars($country);
				//language
				$language = trim($_POST['language']);
				$language = strip_tags($language);
				$language = htmlspecialchars($language);
				//picture_path
				$picture_path = = trim($_POST['picture_path']);
				$picture_path = strip_tags($picture_path);
				$picture_path = htmlspecialchars($picture_path);
				//date_of_registration
				$date_of_registration = date("Y.m.d");
				//birthday
				$birthday = trim($_POST['birthday']);
				$birthday = strip_tags($birthday);
				$birthday = htmlspecialchars($birthday);
				//gender
				$gender = trim($_POST['gender']);
				$gender = strip_tags($gender);
				$gender = htmlspecialchars($gender);
		
				if( mysql_num_rows( mysqli_query( $connect, "SELECT * FROM Person WHERE username = '$username';")) != 0) //username taken
					echo( "Username is taken.");
				else if( mysql_num_rows( mysqli_query( $connect, "SELECT * FROM Person WHERE email = '$email';")) != 0) //email taken
					echo( "There is an account with the e-mail address");
				else{ //create new account
					$presult = mysqli_query( $connect, "INSERT INTO Person(person_id, username, fullname, password, email) 
														VALUES ( id, '$username', '$fullname', '$password', '$email')");
					$uresult = mysqli_query( $connect, "INSERT INTO User(user_id, country, language, picture_path, date_of_registration, birthday, gender, budget)
														VALUES ( id, '$country', '$language', '$picture_path', '$date_of_registration', '$birthday', '$gender', 0)");
					if( $presult && $uresult)
						echo( "Registration successful.");
					else if( $presult && !$uresult)
						echo( "Error occured while inserting into User table");
					else if( !$presult && $uresult)
						echo( "Error occured while inserting into Person table");
					else
						echo( "Error occured while inserting into User and User tables ");
					header( "Location: homepage.php"); //HOMEPAGE.PHP
					exit();
				}
			}
			else
				echo( "You need to agree to terms and conditions.");
		}
		?>
	</body>
</html>
