<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_GET['login_id']);
    $query = "SELECT * FROM user WHERE user_id = {$uid} ";
    $result = mysqli_query($db, $query);
    $user_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $membership_type = $user_array['membership_type'];


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
    if(isset($_POST['purchase_track_button']))
    {
      header("location: purchase_track_with_budget.php?track_id=".$track_id);
    }
    if(isset($_POST['gift_button']))
    {
      
    }
    if(isset($_POST['play_track_button']))
    {
      $insertion_date = date("Y-m-d H:i:s");
      if($membership_type === "Normal"){
        $flag = TRUE;
        $query = "SELECT count(*) AS num_listens FROM Listens WHERE user_id = {$user_id} AND DATE(Listens.date) = " . date(Y-m-d);
        $result = mysqli_query($db, $query);
        $result_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $num_listens = $result_array['num_listens'];

        if($num_listens > 20){
          $flag = FALSE;
          
        }
      }
      if($flag === TRUE){
        $query4 = "INSERT INTO Listens ($user_id, $track_id, $insertion_date)";
        $result4 = mysqli_query($db, $query4);
      }
      else{
        echo "Biz bu sorunun cevabını 15 Temmuz'da verdik!";
      }
      
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musicholics - View Track</title>
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
      <li><a href="view_playlists.php">Playlist</a></li>
      <li><a href="view_tracks.php">Tracks</a></li>
  <li><a href="friends_list.php">Friends</a></li>
  <li><a href="message_list.php">Messages</a></li>
  <li><a href="search_result_screen.php">Search</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="change_general_information.php"><span class="glyphicon glyphicon-user"></span>Settings</a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span>Logout</a></li>
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
       <input id='Submit' name='purchase_track_button' value='Submit' type='button' value='PURCHASE TRACK'>

       <input id='Submit' name='gift_button' value='Submit' type='button' value='GIFT'>

       <input id='Submit' name='play_track_button' value='Submit' type='button' value='PLAY TRACK'>
       </form>
    </p>
 </div>
</div>  


<div>   
<footer>
  <?php
  $query = "SELECT L1.track_id FROM listens L1 WHERE L1.user_id = '$uid' AND 
  date = SELECT max(L2.date) FROM listens L2 WHERE L2.user_id = '$uid'";
  $result = mysqli_query($db, $query);
  $query2 = "SELECT track_name,duration FROM track WHERE track_id = $result";
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