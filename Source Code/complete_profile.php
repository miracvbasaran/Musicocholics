

<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
    $query = "SELECT admin_id FROM admin WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);

    $view_id = $_GET['other_id'];
    $query2 = "SELECT * FROM user WHERE user_id = '$view_id' ";
    $result2 = mysqli_query($db, $query2);
    $view_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);

    $query3 = "SELECT * FROM person WHERE person_id = '$uid' ";
    $result3 = mysqli_query($db, $query3);
    $person_array = mysqli_fetch_array($result3,MYSQLI_ASSOC);

    $username_v = $person_array['username'];
    $fullname_v = $person_array['fullname'];
    $country_v = $view_array['country'];
    $language_v = $view_array['language'];
    $birthday_v = $view_array['birthday'];
    $gender_v = $view_array['gender'];
    $email_v = $person_array['email'];
    $picture_v = $view_array['picture'];
    $user_id_v = $view_array['user_id'];
    $date_of_registration_v = $view_array['date_of_registration'];
    $budget_v = $view_array['budget'];
    $membership_type_v = $user_array['membership_type'];

    if(isset($_POST['ban_button']))
    {

      $query5 = "INSERT INTO bans VALUES( $admin_id,$view_id )";
      $result5 = mysqli_query($db, $query5);


      header("location: admin.php?");

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
          <li><a href="search_admin.php">Search</a></li>
          <li><a href="add_track.php">Add Track</a></li>
          <li><a href="add_album.php">Add Album</a></li>
          <li><a href="add_artist.php">Add Artist</a></li>
          <li><a href="add_publisher.php">Add Publisher</a></li>
        </ul>
        
        <ul class="nav navbar-nav navbar-right">
          <li><a href="change_password.php"><span class="glyphicon glyphicon-user"></span> Change Password</a></li>
          <li><a href="homepage.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
      </div>
    </nav>

   <div align="left" class="col-md-6 col-md-offset-3"><img class="img-circle img-responsive" src="assets/img/ <?php echo $picture_v; ?>" width="200" height="200"></div>

<div class="container">
  <h3>This is, </h3> <?php echo $fullname_v;?>
  	<p>Username: <?php echo $username_v;?> </p>
  	<p>	Fullname: <?php echo $fullname_v;?></p>
  	<p>	E-mail address: <?php echo $email_v;?></p>
  	<p>	Country: <?php echo $country_v;?></p>
  	<p>	Gender: <?php echo $gender_v;?></p>
  	<p>	Language: <?php echo $language_v;?></p>
  	<p>	Birthday: <?php echo $birthday_v;?></p>
  	<p>	Budget: <?php echo $budget_v;?> $ </p>
  	<p>	Date of registration: <?php echo $date_of_registration_v;?> </p>
  	<p>	Membership type: <?php echo $membership_type_v;?> </p>
   
    <p> 
    <input id='Submit' name='ban_button' value='Submit' type='button' value='BAN' onclick="popMessage()">
    </p>

    <script>
    function popMessage(){
        alert("User is banned succesfully!");     
    }   
  </script>

 </div>

<div align="right" class="container">
 <a href="view_others_playlist.php?other_id=$view_id" class="btn btn-success" role="button">VIEW PLAYLISTS</a>
</div>


</p>
<div class="container">
<?php
	$query = "SELECT U.username , P.date, P.post FROM posts P, User U WHERE P.receiver_id = {$view_id} AND P.writer_id = U.user_id ORDER BY date DESC";
	$result = mysqli_query($db, $query);
	
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
    	printf("%s (%s) : %s ", $row[0] , $row[1],$row[2] );  
	}

?>
</div>

</body>
</html>
