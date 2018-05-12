<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_GET['login_id']);


    $track_id = $_GET['track_id'];
    $query2 = "SELECT * FROM track WHERE track_id = {$track_id} ";
    $result2 = mysqli_query($db, $query2);
    $track_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    $track_name = $track_array['track_name'];
    $recording_type = $track_array['recording_type'];
    $duration = $track_array['duration'];
    $danceability = $track_array['danceability'];
    $acousticness = $track_array['acousticness'];
    $instrumentalness = $track_array['instrumentalness'];
    $speechness = $track_array['speechness'];
    $balance = $track_array['balance'];
    $loudness = $track_array['loudness'];
    $language = $track_array['language'];
    $price = $track_array['price'];
    $date_of_addition = $track_array['date_of_addition'];
    $album_id = $track_array['album_id'];
    if(isset($_POST['modify_track_button']))
    {
      header("location: modify_track.php?track_id=".$track_id);
    }
    if(isset($_POST['delete_track_button']))
    {
      $query4 = "CALL DeleteTrack({$track_id})";
      $result4 = mysqli_query($db, $query4);
      header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musicholics - Access Track</title>
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

<div class="container">
    
  <div align="left" class="col-md-6 col-md-offset-3"></div>

<div class="container">
  <h3><?php echo $track_name;?></h3> 
    <p>Recording Type: <?php echo $recording_type;?> </p>
    <p> Duration: <?php echo $duration;?></p>
    <p> Danceability: <?php echo $danceability;?></p>
    <p> Acousticness: <?php echo $acousticness;?></p>
    <p> Instrumentalness: <?php echo $instrumentalness;?></p>
    <p> Speechess: <?php echo $speechness;?></p>
    <p> Balance: <?php echo $balance;?></p>
    <p> Loudness: <?php echo $loudness;?></p>
    <p> Language: <?php echo $language;?></p>
    <p> Price: <?php echo $price;?></p>
    <p> Date of Addition <?php echo $date_of_addition;?></p>

<div align="right" class="container">

 
</div>
  <p> <form method="post" action="">
       <input id='Submit' name='modify_track_button' type='Submit' type='button' value='Modify Track'>

       <input id='Submit' name='delete_track_button' type='Submit' type='button' value='Delete Track'>
       </form>
    </p>
 </div>
</div>  

</body>
</html>