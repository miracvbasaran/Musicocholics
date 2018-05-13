<?php
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Musicholics - Register</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

	<div align = "center">
		<form action = "#" method = "post" onsubmit = "">
			<br/><br/><br/><br/>MUSICHOLICS<br/><br/>Register<br/><br/><br/><br/>
			<input type = "text" name = "name" placeholder = "Name"> <br/><br/>
			<input type = "text" name = "username" placeholder = "Username"> <br/><br/>
			<input type = "password" name = "pass" placeholder = "Password"> <br/><br/>
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
			<input type="date" name="birthday" placeholder="Birtdate (YYYY-MM-DD)"><br/><br/>
			<select name="gender">
				<option value="Gender">Gender</option>
				<option value="M">Male</option>
				<option value="F">Female</option>
				<option value="NB">Non-binary</option>
			</select>
			<br/><br/>
			
			
			
			<br/><br/>
			<br/><br/>
			<input id = "" value = "Register" name = "register" type = "submit"> </button> 
			<br/><br/><br/><br/>
		</form>
	</div>

	<?php
	
	if( isset( $_POST['register'])){
		$fullname = mysqli_real_escape_string( $db, $_POST['name']);
		$username = mysqli_real_escape_string( $db, $_POST['username']);
		$password = mysqli_real_escape_string( $db, $_POST['pass']);
		$email = mysqli_real_escape_string( $db, $_POST['email']);
		$country = mysqli_real_escape_string( $db, $_POST['country']);
		$language = mysqli_real_escape_string( $db, $_POST['language']);
		$date_of_registration = date("Y-m-d");
		$birthday = mysqli_real_escape_string( $db, $_POST['birthday']);
		$gender = mysqli_real_escape_string( $db, $_POST['gender']);
		$budget = 0;
		
		//picture_path
		if(isset($_POST["uploadpic"])){
			$name = $_FILES['photo']['name'];
			$picture_path = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
			$uploadfile = $dir . $uid . '.' . $picture_path;
			$filename = $login_id . '.' . $picture_path;
			$query = "UPDATE User SET picture = '$filename' WHERE user_id = $uid";
			$result = mysqli_query($db, $query);

			if( move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile))
				echo '<div class="alert alert-success" role="alert">Profile photo uploaded successfully. </div>';
			else
				echo '<div class="alert alert-danger" role="alert">Error on uploading profile photo. </div>';
		}
		
		if( $fullname = "" || $username = "" || $password = "" || $email = "" || 
			$country = "" || $language = "" || $birthday = "" || $gender = "")
				header( "Location: register.php");
		
		
		if( mysqli_num_rows( mysqli_query( $db, "SELECT * FROM Person WHERE username = '$username';")) != 0){ //username taken
			header( "Location: register.php");
		}
		else if( mysqli_num_rows( mysqli_query( $db, "SELECT * FROM Person WHERE email = '$email';")) != 0){ //email taken
			header( "Location: register.php");
		}
		else{ //create new account -email and username is free to use
			$presult = mysqli_query( $db, "INSERT INTO Person ( username, fullname, password, email)
				VALUES ( '$username', '$fullname', '$password', '$email');") or die( mysqli_error( $db));


			$uresult = mysqli_query( $db, "INSERT INTO User ( user_id, country, language, date_of_registration, birthday, gender, budget) VALUES ( (SELECT MAX(person_id) FROM Person), '$country', '$language', '$date_of_registration', '$birthday', '$gender', '$budget');") or die( mysqli_error( $db));
					
			header( "Location: homepage.php");
			
		
		}
	}
				
?>
	
</body>
</html>
