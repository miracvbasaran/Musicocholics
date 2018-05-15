<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
    $query = "SELECT * FROM user WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);
    $user_array = mysqli_fetch_array($result,MYSQLI_ASSOC);


    $nonfriend_id = $_GET["other_id"];
    $query2 = "SELECT * FROM person WHERE person_id = '$nonfriend_id'";
    $result2 = mysqli_query($db, $query2);
    $nonfriend_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    $username_non = $nonfriend_array['username'];
    $fullname_non = $nonfriend_array['fullname'];


    $query4 = "SELECT country, picture,gender FROM user WHERE user_id = '$nonfriend_id'";
    $result4 = mysqli_query($db, $query4);
    $nonfriend_array_u = mysqli_fetch_array($result4,MYSQLI_ASSOC);
    $country_non = $nonfriend_array_u['country'];
    $gender_non = $nonfriend_array_u['gender'];

    if( $nonfriend_array_u['picture'] == NULL){
        $picture_non = "nophoto.png";
        
    }
    else{
      $picture_non = $nonfriend_array_u['picture'];
    }

    if(isset($_POST['block_button']))
    {
      
      $query3 = "INSERT INTO blocks VALUES ('$uid', '$nonfriend_id') ";
      $result3 = mysqli_query($db, $query3);

      $query4 = "DELETE FROM friendship WHERE 
      ('$uid' = user1_id AND '$nonfriend_id' = user2_id) OR 
      ( '$nonfriend_id' = user1_id AND '$uid' = user2_id) ";
      $result4 = mysqli_query($db, $query4);
      header("location: blocked_profile.php?other_id=".$nonfriend_id);
  
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musicholics - Nonfriend Profile</title>
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

  <div class="container" align="center"><img class="img-circle img-responsive" src="images/<?php echo $picture_non; ?>" width="200" height="200"></div>  
  <h3>This is <?php echo $username_non;?> </h3> 
  	<p> 
      
    <p> Fullname: <?php echo $fullname_non;?></p><br>
    <p> Country: <?php echo $country_non;?></p><br>
    <p> Gender: <?php echo $gender_non;?></p><br>
    
    </p>
    
    <div> 
    
      <form method="post" action="">
        <a href="add_friend.php?other_id=<?php echo $nonfriend_id; ?> " class="btn btn-success" role="button">ADD AS FRIEND
        </a>
        <br><br>
       <input id='Submit' name='block_button' type='Submit' class="btn btn-danger" value='BLOCK'>
       </form>
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
</div>
</body>
</html>
