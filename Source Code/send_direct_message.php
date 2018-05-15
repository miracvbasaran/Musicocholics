<?php
  include("session.php");
    $uid = mysqli_real_escape_string($db, $_SESSION['login_id']);
    $query1 = "SELECT * FROM user WHERE user_id = {$uid} ";
    $result1 = mysqli_query($db, $query1);
    $user_array = mysqli_fetch_array($result1, MYSQLI_ASSOC);
    
    $receiver_username = $_GET['receiver_username'];

    if(isset($_POST['send_message'])) {
      if(isset($_POST['text_message'])) {
        $text_message = $_POST['text_message'];
        $query2 = "SELECT person_id FROM person WHERE username = '$receiver_username'";
        $result2 = mysqli_query($db, $query2);
        $receiver_array = mysqli_fetch_array($result2, MYSQLI_ASSOC);
        $receiver_id = $receiver_array['person_id'];
        $date = date('Y-m-d G:i:s');
        $query3 = "INSERT INTO sends_message(sender_id, receiver_id, date, message) VALUES({$uid}, {$receiver_id}, '$date', '$text_message')";
        $result3 = mysqli_query($db, $query3);
        header("location: message_list.php");
      }
      else {
       echo ' <script type="text/javascript"> alert("Text message is not entered."); </script>';
      }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Musicholics - Send Message</title>
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
    <h3> Send Message </h3> <br>
    <h3> <?php echo $receiver_username;?> </h3> <br><br>
    <form method="post" action="">
      <label for="comment">Message:</label>
      <textarea class="form-control" rows="5" name="text_message" autofocus></textarea>
      <br><br><br>
      <input type="submit" class="btn btn-success" name="send_message" value="Send Message" > <br><br><br>
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

</body>

</html>