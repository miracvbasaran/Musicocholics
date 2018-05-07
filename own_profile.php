<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_GET['user_id']);
    $query = "SELECT * FROM user WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);
    $user_array = mysqli_fetch_array($result,MYSQLI_ASSOC);

    $user_id = $user_array['user_id'];
    $country = $user_array['country'];
    $language = $user_array['language'];
    $date_of_registration = $user_array['date_of_registration'];
    $birthday = $user_array['birthday'];
    $gender = $user_array['gender'];
    $budget = $user_array['budget'];
	$username = $user_array['username'];
	$fullname = $user_array['fullname'];
	$password = $user_array['password'];
	$email = $user_array['email'];
    $picture = $user_array['picture'];
    $membership_type = $user_array['membership_type'];

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
      <li><a href="wiev_playlists.php">Playlist</a></li>
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
  <h3>Hello, </h3> <?php echo $fullname;?>
  	<p>Username: <?php echo $username;?> </p>
  	<p>	Fullname: <?php echo $fullname;?></p>
  	<p>	E-mail address: <?php echo $email;?></p>
  	<p>	Country: <?php echo $country;?></p>
  	<p>	Gender: <?php echo $gender;?></p>
  	<p>	Language: <?php echo $language;?></p>
  	<p>	Birthday: <?php echo $birthday;?></p>
  	<p>	Budget: <?php echo $budget;?> $ </p>
  	<p>	Date of registration: <?php echo $date_of_registration;?> $ </p>
  	<p>	Membership type: <?php echo $membership_type;?> $ </p>

 </div>

<div class="container">
<?php
	$query = "SELECT U.username , P.post FROM posts P, User U WHERE P.reciver_id = '$uid' AND P.writer_id = U.user_id ORDER BY date";
	$result = mysqli_query($db, $query);
	
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
    	printf("%s : %s ", $row[0] , $row[1] );  
	}

?>
</div>
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