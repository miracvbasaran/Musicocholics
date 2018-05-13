<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
    $query = "SELECT * FROM user WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);
    $user_array = mysqli_fetch_array($result,MYSQLI_ASSOC);

   
    $query2 = "SELECT * FROM person WHERE person_id = '$uid' ";
    $result2 = mysqli_query($db, $query2);
    $person_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);

   
	  $username = $person_array['username'];
	  $fullname = $person_array['fullname'];
  	$email = $person_array['email'];
    $password = $person_array['password'];
    $user_id = $user_array['user_id'];
    $country = $user_array['country'];
    $language = $user_array['language'];
    $date_of_registration = $user_array['date_of_registration'];
    $birthday = $user_array['birthday'];
    $gender = $user_array['gender'];
    $budget = $user_array['budget'];
	  
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
      
      <li><a href="own_profile.php">Profile</a></li>
      <li><a href="view_playlists.php">Playlist</a></li>
      <li><a href="view_tracks.php">Tracks</a></li>
      <li><a href="friends.php">Friends</a></li>
      <li><a href="message_list.php">Messages</a></li>
      <li><a href="search.php">Search</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="change_general_information.php"><span class="glyphicon glyphicon-user"></span> Settings</a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>


   <div align="center" class="container">
      <img class="img-circle img-responsive" src="assets/img/ <?php echo $picture; ?>" width="100" height="100">
  </div>

<div class="container" align="center" >

  <h3> Hello, <?php echo $fullname; ?> </h3>  
	<br>
  	<p> Username: <?php echo $username;?> </p><br>
  	<p>	Fullname: <?php echo $fullname;?></p><br>
  	<p>	E-mail address: <?php echo $email;?></p><br>
  	<p>	Country: <?php echo $country;?></p><br>
  	<p>	Gender: <?php echo $gender;?></p><br>
  	<p>	Language: <?php echo $language;?></p><br>
  	<p>	Birthday: <?php echo $birthday;?></p><br>
  	<p>	Budget: <?php echo $budget;?> $ </p><br>
  	<p>	Date of registration: <?php echo $date_of_registration;?>  </p><br>
  	<p>	Membership type: <?php echo $membership_type;?>  </p><br>

 </div>

<div class="container" align="left">
<fieldset>
    <legend><h3>  POSTS </h3></legend> 
<div class="container">

<?php
	$query = "SELECT P.writer_id , P.date, P.post FROM posts P WHERE P.receiver_id = '$uid' ORDER BY date DESC";
	$result = mysqli_query($db, $query);
	$writer_names = array();
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $query1 = "SELECT P.username FROM Person P WHERE P.person_id = '$row[writer_id]' ";
		  $result1 = mysqli_query($db, $query1);
		  $writer_names[] = mysqli_fetch_array($result1, MYSQLI_ASSOC)['username'];
	}
	$i=0;
  $result = mysqli_query($db, $query);
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      echo " <div class=\"well\"> <div  align=\"left\" > {$writer_names[$i]} ( {$row['date']} ): <br> </div> <div align=\"left\" > {$row['post']}  <br> </div> </div>"; 
      $i = $i + 1;
	}

?>
<fieldset>
</div>

</div> 	

<style>
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 80%;
   text-align: center;
}
</style>
<div class = "footer">
<footer>
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

</footer>
</div>

</div>
</body>
</html>
