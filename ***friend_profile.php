<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_GET['login_id']);
    $query = "SELECT * FROM user WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);
    $user_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $friend_id = $_GET['other_id'];
    $query2 = "SELECT * FROM user WHERE user_id = '$friend_id' ";
    $result2 = mysqli_query($db, $query2);
    $friend_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    $username_f = $friend_array['username'];
    $fullname_f = $friend_array['fullname'];
    $country_f = $friend_array['country'];
    $language_f = $friend_array['language'];
    $birthday_f = $friend_array['birthday'];
    $gender_f = $friend_array['gender'];
    $email_f = $friend_array['email'];
    $picture_f = $friend_array['picture'];
    if(isset($_POST['sendmessage_button']))
    {
      header("location: send_message.php?other_id=$friend_id");
    }
    if(isset($_POST['block_button']))
    {
      header("location: blocked_profile.php?other_id=$friend_id");
      $query3 = "INSERT INTO blocks VALUES ($uid, $friend_id) ";
      $result3 = mysqli_query($db, $query3);
      $query4 = "DELETE FROM friendship WHERE 
      ($uid = user1_id AND $friend_id = user2_id) OR 
      ( $friend_id = user1_id AND $uid = user2_id) ";
      $result4 = mysqli_query($db, $query4);
    }
    if(isset($_POST['unfriend_button']))
    {
      header("location: nonfriend_profile.php?other_id=$friend_id");
      $query4 = "DELETE FROM friendship WHERE 
      ($uid = user1_id AND $friend_id = user2_id) OR 
      ( $friend_id = user1_id AND $uid = user2_id) ";
      $result4 = mysqli_query($db, $query4);
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musicholics - My Profile</title>
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
      
      <li><a href="own_profile.php">Profile</a></li>
      <li><a href="view_playlists.php">Playlist</a></li>
      <li><a href="view_tracks.php">Tracks</a></li>
	<li><a href="friends_list.php">Friends</a></li>
	<li><a href="message_list.php">Messages</a></li>
	<li><a href="search_result_screen.php">Search</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="change_general_information.php"><span class="glyphicon glyphicon-user"></span> Settings</a></li>
      <li><a href="homepage.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
  	
  <div align="left" class="col-md-6 col-md-offset-3"><img class="img-circle img-responsive" src="assets/img/ <?php echo $picture_f; ?>" width="200" height="200"></div>

<div class="container">
  <h3>This is, </h3> <?php echo $fullname_f;?>
    <p>Username: <?php echo $username_f;?> </p>
    <p> E-mail address: <?php echo $email_f;?></p>
    <p> Country: <?php echo $country_f;?></p>
    <p> Gender: <?php echo $gender_f;?></p>
    <p> Language: <?php echo $language_f;?></p>
    <p> Birthday: <?php echo $birthday_f;?></p>

<div align="right" class="container">
 <a href="view_others_playlist.php?other_id=$view_id" class="btn btn-success" role="button">VIEW PLAYLISTS</a>

 
</div>
  <p> 
       <input id='Submit' name='sendmessage_button' value='Submit' type='button' value='SEND MESSAGE'>

       <input id='Submit' name='block_button' value='Submit' type='button' value='BLOCK'>

       <input id='Submit' name='unfriend_button' value='Submit' type='button' value='UNFRIEND'>
       
    </p>
 </div>
</div>


<div class="container">
<p> POSTS <br><br>
<?php
  $query = "SELECT U.username , P.post, P.date FROM posts P, User U WHERE P.reciver_id = '$friend_id' AND P.writer_id = U.user_id ORDER BY date DESC ";
  $result = mysqli_query($db, $query);
  
  while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
      printf("%s (%s) : %s ", $row[0] , $row[2], $row[1] );  
  }
?>
</div>
</p>


<div> 	
<footer>
	<?php
	$query = "SELECT L1.track_id FROM listens L1 WHERE L1.user_id = '$uid' AND 
	date = SELECT max(L2.date) FROM listens L2 WHERE L2.user_id = '$uid'";
	$result = mysqli_query($db, $query);
	$query2 = "SELECT track_name,duration FROM track WHERE track_id = $result";
	$result2 = mysqli_query($db, $query2);
	$track_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    $track_name = $track_array['track_name'];
    $duration = $track_array['duration'];
	echo $track_name;
	echo $duration;
	?>

</footer>
</div>
</body>
</html>




<!-- 



















 -->



<?php 
	include("session.php");
	include("connection.php");
?>

<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>Musicholics - Friends</title>
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
					<li class="active"><a href="#">Friends</a></li>
					<li><a href="message_list.php">Messages</a></li>
					<li><a href="search_result_screen.php">Search</a></li>
					<li><<?php 
include("session.php");
include("connection.php");
?>

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
			Birth date: <input type="date" name="birthday"><br/><br/>
			<select name="gender">
				<option value="Gender">Gender</option>
				<option value="M">Male</option>
				<option value="F">Female</option>
				<option value="NB">Non-binary</option>
			</select>
			<br/><br/>
			<!--  Path of the picture: <input type = "text" name = "picture_path"><br/><br/>  -->
			<input class="btn btn-primary btn-sm" type="file" name="photo" id="photo" accept="image/*"> <button class="btn btn-success btn-sm" type="submit" name="uploadpic">Upload picture</button> 
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
			var agreed = document.getElementById( "agreed").value;

			if( realname = "" || username == "" || password == "" || email = "" 
				|| country = "Country" || language = "Language" || day = "" 
				|| month = "" || year = "" || gender = "Gender")
				alert( "Please fill all fields.");
			else if( !agreed)
				alert( "You did not agree to terms and conditions.");
			else
				return true;
			location.href = "register.php";
		}
		</script>
		
	
		<?php
		
		if( isset( $_POST['register'])){
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
			//country
			$country = trim($_POST['username']);
			$country = strip_tags($country);
			$country = htmlspecialchars($country);
			//language
			$language = trim($_POST['language']);
			$language = strip_tags($language);
			$language = htmlspecialchars($language);
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
			//budget
			$budget = 0;
	
			if( mysql_num_rows( mysqli_query( $db, "SELECT * FROM Person WHERE username = '$username';")) != 0) //username taken
				echo( "Username is taken.");
			else if( mysql_num_rows( mysqli_query( $db, "SELECT * FROM Person WHERE email = '$email';")) != 0) //email taken
				echo( "There is an account with the e-mail address");
			else{ //create new account
				$presult = mysqli_query( $db, "INSERT INTO Person( username, fullname, password, email, membership_type) 
					VALUES ( '$username', '$fullname', '$password', '$email', 'user')"); //MEMBERSHIP_TYPE --> USER???
				
				//person_id & user_id
				$id = mysqli_query( $db, "SELECT MAX(person_id) FROM Person");
				
				$uresult = mysqli_query( $db, "INSERT INTO User( user_id, country, language, picture_path, date_of_registration, birthday, gender, budget)
												VALUES ( '$id', '$country', '$language', '$picture_path', '$date_of_registration', '$birthday', '$gender', '$budget')");
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
		?>
	</body>
</html>a href="logout.php">Logout</a></li>
				</ul>
				
				
				
				
			</div>
		</nav>
		
		<?php
		
		$id = mysqli_real_escape_string( $db, $_POST['login_id']);
		$fquery = mysqli_query( $db, "SELECT * FROM Friendship WHERE user1_id = '$id' OR user2_id = '$id');");
		
		while( $frow = $fquery->fetch_assoc()){ //for each friend
			$fid = $frow['user1_id'];
			if( $fid == $id)
				$fid = $frow['user2_id'];
			$_SESSION['remove_friend_id'] = $fid;
			$uquery = mysqli_query( $db, "SELECT * FROM Person WHERE person_id = '$fid');"); //friends profile
			echo( "<tr><td><a href='friend_profile.php?friend_id=".$id."'>".$uquery['fullname']."	</a></td></tr></br>");
			echo( "<tr><td><a href='send_message.php?friend_id=".$id."'>Send Message</a></td></tr>	"); //SEND MESSAGE
			echo( "<tr><td><a href='remove_friend.php'>Remove</a></td></tr>	"); //REMOVE
		}
		
		?>
		
		
	</body>
</html>

