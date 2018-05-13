<?php
	  include("session.php");
    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
    
    $friend_id = $_GET["other_id"];

    $query = "SELECT * FROM person WHERE person_id = '$friend_id'";
    $result = mysqli_query($db, $query);
    $fPer_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $username_f = $fPer_array['username'];
    $fullname_f = $fPer_array['fullname'];
    $email_f = $fPer_array['email'];

    $query2 = "SELECT * FROM user WHERE user_id = '$friend_id'";
    $result2 = mysqli_query($db, $query2);
    $friend_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    
    $country_f = $friend_array['country'];
    $language_f = $friend_array['language'];
    $birthday_f = $friend_array['birthday'];
    $gender_f = $friend_array['gender'];
    
    $picture_f = $friend_array['picture'];

    if(isset($_POST['sendmessage_button']))
    {
      header("location: send_direct_message.php?receiver_username=".$username_f);
     
    }


    if(isset($_POST['block_button']))
    {
      
      $query3 = "INSERT INTO blocks VALUES ($uid, $friend_id) ";
      $result3 = mysqli_query($db, $query3);

      $query4 = "DELETE FROM friendship WHERE 
      ($uid = user1_id AND $friend_id = user2_id) OR 
      ( $friend_id = user1_id AND $uid = user2_id) ";
      $result4 = mysqli_query($db, $query4);
      header("location: blocked_profile.php?other_id=".$friend_id);
  
    }

    if(isset($_POST['unfriend_button']))
    {
      
      $query4 = "DELETE FROM friendship WHERE 
      ($uid = user1_id AND $friend_id = user2_id) OR 
      ( $friend_id = user1_id AND $uid = user2_id) ";
      $result4 = mysqli_query($db, $query4);

      header("location: nonfriend_profile.php?other_id=".$friend_id);
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
  
<div class="container">
  	
  <div align="center" class="container"><img class="img-circle img-responsive" src="assets/img/ <?php echo $picture_f; ?>" width="200" height="200"></div>

<div class="container" align="center">
  <h3>This is <?php echo $username_f;?> </h3> 
    <p> E-mail address: <?php echo $email_f;?></p>
    <p> Country: <?php echo $country_f;?></p>
    <p> Gender: <?php echo $gender_f;?></p>
    <p> Language: <?php echo $language_f;?></p>
    <p> Birthday: <?php echo $birthday_f;?></p>

<div class="container" align="right" >
    <form method="post" action="">

<div align="right" class="container">
 <a href=<?php echo "'view_others_playlists.php?other_id={$friend_id}'"; ?> class="btn btn-success" role="button">View Playlists</a>

       <input id='Submit' name='sendmessage_button' type='Submit' class="btn btn-warning" value='Send Message'>
       <br><br>
       <input id='Submit' name='block_button' type='Submit' class="btn btn-danger" value='Block'>

       <input id='Submit' name='unfriend_button' type='Submit' class="btn btn-primary" value='Unfriend'>

           
  </form>


</div>


<div class="container" align="left">
<fieldset>
    <legend><h3>  POSTS </h3></legend> 
<div class="container">

<?php
  $query = "SELECT P.writer_id , P.date, P.post FROM posts P WHERE P.receiver_id = '$friend_id' ORDER BY date DESC";
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

<style>
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   text-align: center;
}
</style>
<div class = "footer">

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
</div>

</body>
</html>