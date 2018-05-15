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

    
    $query2 = "SELECT * FROM Album WHERE album_id = {$album_id} ";
    $result2 = mysqli_query($db, $query2);
    $album_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    $album_name = $album_array['album_name'];
    if(isset($_POST['apply']))
    {
      if(isset( ($_POST['track_name']) )  ){
          $track_name = $_POST['track_name'];
          $query = "UPDATE Track SET track_name = '{$track_name}' WHERE track_id = {$track_id}; ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['recording_type']) )  ){
          $recording_type = $_POST['recording_type'];
          $query = "UPDATE Track SET recording_type = '{$recording_type}' WHERE track_id = {$track_id}; ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['duration']) )  ){
          $duration = $_POST['duration'];
          $query = "UPDATE Track SET duration = {$duration} WHERE track_id = {$track_id}; ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['danceability']) )  ){
          $danceability = $_POST['danceability'];
          $query = "UPDATE Track SET danceability = {$danceability} WHERE track_id = {$track_id}; ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['acousticness']) )  ){
          $acousticness = $_POST['acousticness'];
          $query = "UPDATE Track SET acousticness = {$acousticness} WHERE track_id = {$track_id}; ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['instrumentalness']) )  ){
          $instrumentalness = $_POST['instrumentalness'];
          $query = "UPDATE Track SET instrumentalness = {$instrumentalness} WHERE track_id = {$track_id};";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['speechness']) )  ){
          $speechness = $_POST['speechness'];
          $query = "UPDATE Track SET speechness = {$speechness} WHERE track_id = {$track_id};";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['balance']) )  ){
          $balance = $_POST['balance'];
          $query = "UPDATE Track SET balance = {$balance} WHERE track_id = {$track_id};";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['loudness']) )  ){
          $loudness = $_POST['loudness'];
          $query = "UPDATE Track SET loudness = {$loudness} WHERE track_id = {$track_id};";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['language']) )  ){
          $language = $_POST['language'];
          $query = "UPDATE Track SET language = '{$language}' WHERE track_id = {$track_id};";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['price']) )  ){
          $price = $_POST['price'];
          $query = "UPDATE Track SET price = {$price} WHERE track_id = {$track_id};";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['date_of_addition']) )  ){
          $date_of_addition = $_POST['date_of_addition'];
          $query = "UPDATE Track SET date_of_addition = '{$date_of_addition}' WHERE track_id = {$track_id};";
          $result = mysqli_query($db, $query);
      }
      header("Location: access_track.php?track_id=".$track_id);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musicholics - Modify Track</title>
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
          <li><a href="admin.php">Home</a></li>
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

   <div align="center" class="col-md-6 col-md-offset-3"><img class="img-circle img-responsive" src="assets/img/ <?php echo $picture_v; ?>" width="200" height="200"></div>

<div class="container" align = "center">
  <h2><?php echo $track_name;?><small> in <?php echo "<a href= \"access_album.php?album_id={$album_id}\">{$album_name}</a>" ?></small></h2>


<form method="post" action="">
  <div class="col-xs-3">Track Name: <input type="text" name="track_name" class = "form-control" default = <?php echo "'".$track_name."'"; ?> 
    value= <?php echo "'".$track_name."'"; ?> autofocus><br></div>
  <div class="col-xs-3">Recording Type: <select class = "form-control" name="recording_type">
    <option <?php if(strcasecmp("Live", $recording_type) === 0){ echo "selected = "."\"selected\"";} ?> value="Live">Live</option>
    <option <?php if(strcasecmp("Studio", $recording_type) === 0){ echo "selected = "."\"selected\"";} ?> value="Studio">Studio</option>
  </select> <br></div>
  <div class="col-xs-3">Duration: <input type="text" name="duration" class = "form-control" value= <?php echo "{$duration}"; ?> autofocus><br></div>
  <div class="col-xs-3">Danceability: <input type="text" name="danceability" class = "form-control" value= <?php echo "{$danceability}"; ?> autofocus><br></div>
  <div class="col-xs-3">Acousticness: <input type="text" name="acousticness" class = "form-control" value= <?php echo "{$acousticness}"; ?> autofocus><br></div>
  <div class="col-xs-3">Instrumentalness: <input type="text" name="instrumentalness" class = "form-control" value= <?php echo "{$instrumentalness}"; ?> autofocus><br></div>
  <div class="col-xs-3">Speechness: <input type="text" name="speechness" class = "form-control" value= <?php echo "{$speechness}"; ?> autofocus><br></div>
  <div class="col-xs-3">Balance: <input type="text" name="balance" class = "form-control" value= <?php echo "{$balance}"; ?> autofocus><br></div>
  <div class="col-xs-3">Loudness: <input type="text" name="loudness" class = "form-control" value= <?php echo "{$loudness}"; ?> autofocus><br></div>
  <div class="col-xs-3">Price: <input type="text" name="price" class = "form-control" value= <?php echo "{$price}"; ?> autofocus><br></div>
  <div class="col-xs-3">Date of Addition: <input type="date" name="date_of_addition" class = "form-control" value= <?php echo "{$date_of_addition}"; ?> autofocus><br></div>
  <div class="col-xs-3">Language: <select class = "form-control" name="language">
    <option <?php if(strcasecmp("Turkish", $language) === 0){ echo "selected = "."\"selected\"";} ?> value="Turkish">Turkish</option>
    <option <?php if(strcasecmp("English", $language) === 0){ echo "selected = "."\"selected\"";} ?> value="English">English</option>
    <option <?php if(strcasecmp("German", $language) === 0){ echo "selected = "."\"selected\"";} ?> value="German">German</option>
  </select> <br></div>
  
  <div class="container" align = "right"><input type="submit" name="apply" value="Apply" class = "btn btn-success"> </div>

</form> 

 </div>

</body>
</html>