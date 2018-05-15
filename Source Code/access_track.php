<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);


    $track_id = $_GET['track_id'];
    $query2 = "SELECT * FROM track WHERE track_id = {$track_id} ";
    $result2 = mysqli_query($db, $query2);
    if($result2 === FALSE){
      echo "<script type=\"text/javascript\"> alert(\"There is no track to show!\"); </script>";
      header("Location: admin.php");
    }
    else{
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

      $query2 = "SELECT * FROM Album WHERE album_id = {$album_id} ";
      $result2 = mysqli_query($db, $query2);
      if($result2 === FALSE){
        echo "<script type=\"text/javascript\"> alert(\"The track does not belong to an album!\"); </script>";
        header("Location: admin.php");
      }
      else{
        $album_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
        $album_name = $album_array['album_name'];
      }
    }

    
    if(isset($_POST['modify_track_button']))
    {
      header("location: modify_track.php?track_id=".$track_id);
    }
    if(isset($_POST['delete_track_button']))
    {
      $query4 = "CALL DeleteTrack({$track_id})";
      $result4 = mysqli_query($db, $query4);
      if($result4){
        echo "<script type=\"text/javascript\"> alert(\"Track succesfully deleted!\"); </script>";
        header("Location: admin.php");
      }
      else{
        echo "<script type=\"text/javascript\"> alert(\"Track could not be deleted!\"); </script>";
      }
      
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
		  <li><a href="admin.php">Admin</a></li>
          <li><a href="search_admin.php">Search</a></li>
          <li><a href="add_track.php">Add Track</a></li>
          <li><a href="add_album.php">Add Album</a></li>
          <li><a href="add_artist.php">Add Artist</a></li>
          <li><a href="add_publisher.php">Add Publisher</a></li>
        </ul>
        
        <ul class="nav navbar-nav navbar-right">
          <li><a href="change_password_admin.php"><span class="glyphicon glyphicon-user"></span> Change Password</a></li>
          <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
      </div>
    </nav>

<div class="container">
    
  <div align="center" class="col-md-6 col-md-offset-3"></div>

<div class="container">
  <div class = "container" align = "center"><h2><?php echo $track_name;?><small> in <?php echo "<a href= \"access_album.php?album_id={$album_id}\">{$album_name}</a>" ?></small></h2></div>
    <div class = "container" align = "center">
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
  </div>

<div align="right" class="container">
  <p> <form method="post" action="">
       <input id='Submit' name='modify_track_button' type='Submit' type='button' value='Modify Track' class = "btn btn-warning">

       <input id='Submit' name='delete_track_button' type='Submit' type='button' value='Delete Track' class = "btn btn-danger">
       </form>
    </p>
 </div>
</div>
 
</div>  

</body>
</html>