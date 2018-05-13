<?php
	  include("session.php");
    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);

    $query = "SELECT * FROM person WHERE person_id = '$uid'";
    $result = mysqli_query($db, $query);
    $person_array = mysqli_fetch_array($result,MYSQLI_ASSOC);

	  $username = $person_array['username'];
	  $fullname = $person_array['fullname'];
	  $password = $person_array['password'];
	  $email = $person_array['email'];


    $set = 0;
    if(isset( ($_POST['apply']) ) ){

          $old_pass = $_POST['old_pass'];

          if(  strcmp($old_pass, $password) != 0 )  
          {
          echo ' <script type="text/javascript"> alert("Old password value is not matched."); </script>';
          }
          else{
              if(isset( ($_POST['new_pass_1']) )  ){
                  $newpass = ($_POST['new_pass_1']);
              }
              else{
                echo ' <script type="text/javascript"> alert("You need to enter new password."); </script>'; 
              }

              if(isset( ($_POST['new_pass_2']) )   ){
                  if (  ($_POST['new_pass_2']) == $newpass   ){

                      $query1 = "UPDATE person SET password = '$newpass' WHERE person_id = '$uid'";
                      $result1 = mysqli_query($db, $query1);
                      echo ' <script type="text/javascript"> alert("Password has changed successfully."); </script>';
                      header("location: change_general_information.php");
                  }
                  else{
                    echo ' <script type="text/javascript"> alert("Passwords are not matched."); </script>';  
                  }
              }   
              else{
                echo ' <script type="text/javascript"> alert("You need to enter new password again."); </script>';
              } 

          }  

 
      
        
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

<form method="post" action="">
  Old password: <input type="psw" name="old_pass" value= "" autofocus>
  <br><br><br>
  New password: <input type="psw" name="new_pass_1" value="" autofocus>
  <br><br><br>
  Reenter new password  <input type="psw" name="new_pass_2" value=""  autofocus>
  <br><br><br>

  <input type="submit" name="apply" value="APPLY" > 

</form> 

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
