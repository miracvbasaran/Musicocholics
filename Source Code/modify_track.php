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
    

    if(isset($_POST['apply']))
    {
      if(isset( ($_POST['track_name']) )  ){
          $track_name = $_POST['track_name'];
          $query = "UPDATE Track SET track_name = {$track_name} WHERE track_id = {$track_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['recording_type']) )  ){
          $recording_type = $_POST['recording_type'];
          $query = "UPDATE Track SET recording_type = {$recording_type} WHERE track_id = {$track_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['duration']) )  ){
          $duration = $_POST['duration'];
          $query = "UPDATE Track SET duration = {$duration} WHERE track_id = {$track_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['danceability']) )  ){
          $danceability = $_POST['danceability'];
          $query = "UPDATE Track SET danceability = {$danceability} WHERE track_id = {$track_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['acousticness']) )  ){
          $acousticness = $_POST['acousticness'];
          $query = "UPDATE Track SET acousticness = {$acousticness} WHERE track_id = {$track_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['instrumentalness']) )  ){
          $instrumentalness = $_POST['instrumentalness'];
          $query = "UPDATE Track SET instrumentalness = {$instrumentalness} WHERE track_id = {$track_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['speechness']) )  ){
          $speechness = $_POST['speechness'];
          $query = "UPDATE Track SET speechness = {$speechness} WHERE track_id = {$track_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['balance']) )  ){
          $balance = $_POST['balance'];
          $query = "UPDATE Track SET balance = {$balance} WHERE track_id = {$track_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['loudness']) )  ){
          $loudness = $_POST['loudness'];
          $query = "UPDATE Track SET loudness = {$loudness} WHERE track_id = {$track_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['language']) )  ){
          $language = $_POST['language'];
          $query = "UPDATE Track SET language = {$language} WHERE track_id = {$track_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['price']) )  ){
          $price = $_POST['price'];
          $query = "UPDATE Track SET price = {$price} WHERE track_id = {$track_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['date_of_addition']) )  ){
          $date_of_addition = $_POST['date_of_addition'];
          $query = "UPDATE Track SET date_of_addition = {$date_of_addition} WHERE track_id = {$track_id} ";
          $result = mysqli_query($db, $query);
      }
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

<div class="container" align = "center">
  <h3>Change Track Information</h3> 


<form method="post" action="">
  Track Name: <input type="text" name="track_name" value= <?php echo $track_name ?> autofocus><br>
  Recording Type: <select name="recording_type">
    <option value="Live">Live</option>
    <option value="Studio">Studio</option>
  </select> <br>
  Duration: <input type="text" name="duration" value= <?php echo "{$duration}" ?> autofocus><br>
  Danceability: <input type="text" name="danceability" value= <?php echo "{$danceability}" ?> autofocus><br>
  Acousticness: <input type="text" name="acousticness" value= <?php echo "{$acousticness}" ?> autofocus><br>
  Instrumentalness: <input type="text" name="instrumentalness" value= <?php echo "{$instrumentalness}" ?> autofocus><br>
  Speechness: <input type="text" name="speechness" value= <?php echo "{$speechness}" ?> autofocus><br>
  Balance: <input type="text" name="balance" value= <?php echo "{$balance}" ?> autofocus><br>
  Loudness: <input type="text" name="loudness" value= <?php echo "{$loudness}" ?> autofocus><br>
  Price: <input type="text" name="price" value= <?php echo "{$price}" ?> autofocus><br>
  Date of Addition: <input type="date" name="date_of_addition" value= <?php echo "{$date_of_addition}" ?> autofocus><br>
  Language: <select name="language">
    <option value="Turkish">Turkish</option>
    <option value="English">English</option>
    <option value="German">German</option>
  </select> <br>
  
  <input type="submit" name="apply" value="Apply"  > 

</form> 

 </div>

</body>
</html>