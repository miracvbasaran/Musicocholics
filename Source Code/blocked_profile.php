<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
    $query = "SELECT * FROM user WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);
    $user_array = mysqli_fetch_array($result,MYSQLI_ASSOC);


    $blocked_id = $_GET["other_id"];
    $query2 = "SELECT * FROM person WHERE person_id = '$blocked_id' ";
    $result2 = mysqli_query($db, $query2);
    $blocked_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);

    $username_b = $blocked_array['username'];
    $fullname_b = $blocked_array['fullname'];

    $query3 = "SELECT picture FROM user WHERE user_id = '$blocked_id' ";
    $result3 = mysqli_query($db, $query3);
    $pic_array = mysqli_fetch_array($result3,MYSQLI_ASSOC);
    $picture_b = $pic_array['picture'];


    if( $picture_b == NULL){
        $picture_b = "nophoto.png";      
    }
    else{
       $picture_b =$pic_array['picture'];
    }

    if(isset($_POST['unblock_button']))
    {
          $query3 = "DELETE FROM blocks WHERE '$uid'=blocker_id AND '$blocked_id'=blocked_id";
          $result3 = mysqli_query($db, $query3);
          header("location: nonfriend_profile.php?other_id=".$blocked_id);
    }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musicholics - Blocked Profile</title>
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
  

<div class="container" align="center"> 

<div align="center" class="container"><img class="img-circle img-responsive" src="images/<?php echo $picture_b; ?>" width="200" height="200"></div> 
  <h3>This is <?php echo $username_b;?> </h3> 
<br><br>
   <div class="container" align="center" >
    <form method="post" action="">
      <input id='Submit' name='unblock_button' type='Submit' class="btn btn-danger" value='UNBLOCK'>
    </form>
    </div>

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
