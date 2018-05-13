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
      <li><a href="playlists.php">Playlist</a></li>
      <li><a href="view_tracks.php">Tracks</a></li>
	<li><a href="friends_list.php">Friends</a></li>
	<li><a href="message_list.php">Messages</a></li>
	<li><a href="search.php">Search</a></li>
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
          date = (SELECT max(L2.date) FROM listens L2 WHERE L2.user_id = '$uid') ";
          $result = mysqli_query($db, $query);
          $row = mysqli_fetch_array($result, MYSQLI_NUM);
          $query2 = "SELECT track_name,duration FROM track WHERE track_id = '$row[0]' ";
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