<?php
include("connection.php");
$uploaddir = getcwd().'/images/';;
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

	
  <div class = "container" align = "center"><h2>
	
		<br/><br/>
		SIGN UP</h2>
	
	</div>

	<div align = "center">
		<form action = "#" method = "post" onsubmit = "" enctype="multipart/form-data">
			FULLNAME: <input type = "text" name = "name" placeholder = "Fullname"> <br/><br/>
			USERNAME: <input type = "text" name = "username" placeholder = "Username"> <br/><br/>
			PASSWORD: <input type = "password" name = "pass" placeholder = "Password"> <br/><br/>
			E-MAIL ADDRESS: <input type = "text" name = "email" placeholder = "E-mail address"> <br/><br/>

	         <input class="btn btn-primary btn-sm" type="file" name="userphoto" id="userphoto" accept="image/*">
	         <br>
	         		   
			COUNTRY: <select name="country">
				<option value="Country">Country</option>
				<option value="Turkey">Turkey</option>
				<option value="Germany">Germany</option>
				<option value="USA">USA</option>
			</select>
			<br/><br/>
			LANGUAGE: <select name="language">
				<option value="Language">Language</option>
				<option value="Turkish">Turkish</option>
				<option value="English">English</option>
				<option value="German">German</option>
			</select>
			<br/><br/>
			BIRTHDAY: <input type="date" name="birthday" placeholder="(YYYY-MM-DD)"><br/><br/>
			
			GENDER: <select name="gender">
				<option value="Gender">Gender</option>
				<option value="male">Male</option>
				<option value="female">Female</option>
			</select>
			<br/><br/>
			
			<br/><br/>
			<br/><br/>
			<input id = ""  class="btn btn-success" value = "SUBMIT" name = "register" type = "submit"> </button> 
			<input id = ""  class="btn btn-danger" value = "CANCEL" name = "cancel" type = "submit"> </button> 
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
		
		$result = mysqli_query($db, "SELECT MAX(person_id) FROM Person");
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		$uid = $row[0];
	    $name = $_FILES['userphoto']['name']; 
	    $ext = pathinfo($_FILES['userphoto']['name'], PATHINFO_EXTENSION);
	    $uploadfile = $uploaddir . $uid . '.' . $ext;
	    $filename = $uid . '.' . $ext;

	    $picture = $filename;
	     if (move_uploaded_file($_FILES['userphoto']['tmp_name'], $uploadfile)) {
	            
	     } else {
	            echo '<div class="alert alert-danger" role="alert">Error on uploading profile photo. </div>';
	     }
    	
    	if($name == ""){
    		$picture = NULL;
    	}

		
		if( $fullname == "")
			echo ' <script type="text/javascript"> alert("Fill in the name area"); </script>';
		if( $username == "")
			echo ' <script type="text/javascript"> alert("Fill in the username area"); </script>';
		if( $password == "")
			echo ' <script type="text/javascript"> alert("Fill in the password area"); </script>';
		if( $email == "")
			echo ' <script type="text/javascript"> alert("Fill in the email area"); </script>';
		if( $country == "Country")
			echo ' <script type="text/javascript"> alert("Select your country"); </script>';
		if( $language == "Language")
			echo ' <script type="text/javascript"> alert("Select your language"); </script>';
		if( $birthday == "")
			echo ' <script type="text/javascript"> alert("Fill in the birthday area"); </script>';
		if( $gender == "Gender")
			echo ' <script type="text/javascript"> alert("Select your gender"); </script>';
		
		
		$uquery = mysqli_query( $db, "SELECT * FROM Person WHERE username = '$username';");
		$equery = mysqli_query( $db, "SELECT * FROM Person WHERE email = '$email';");
		
		if( !$uquery)
			echo ' <script type="text/javascript"> alert("Database error for uquery"); </script>';
		if( !$equery)
			echo ' <script type="text/javascript"> alert("Database error for equery"); </script>';
		
		if( mysqli_num_rows( $uquery) > 0){ //username taken
			echo ' <script type="text/javascript"> alert("Username taken"); </script>';
		}
		else if( mysqli_num_rows( $equery) > 0){ //email taken
			echo ' <script type="text/javascript"> alert("E-mail taken"); </script>';
		}
		else{ //create new account --email and username is free to use
			$presult = mysqli_query( $db, "INSERT INTO Person ( username, fullname, password, email)
				VALUES ( '$username', '$fullname', '$password', '$email');") or die( mysqli_error( $db));
			
			if( !$presult){
				echo ' <script type="text/javascript"> alert("Error: Could not insert into Person"); </script>';
			}

			$uresult = mysqli_query( $db, "INSERT INTO User ( user_id, country, language, date_of_registration, birthday, gender, budget, membership_type, picture) VALUES ( (SELECT MAX(person_id) FROM Person), '$country', '$language', '$date_of_registration', '$birthday', '$gender', '$budget', 'normal', '$picture');") or die( mysqli_error( $db));
					
			if( !$uresult){
				echo ' <script type="text/javascript"> alert("Error: Could not insert into User"); </script>';
			}
					
			header( "Location: homepage.php");
			
		
		}
	}

	if( isset($_POST['cancel'])){
		header("Location: index.php");
	}
				
?>

</body>
</html>
