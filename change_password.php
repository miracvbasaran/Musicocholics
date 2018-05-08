<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_GET['user_id']);
    $query = "SELECT * FROM user WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);
  $user_array = mysqli_fetch_array($result,MYSQLI_ASSOC);

     $query2 = "SELECT * FROM person WHERE person_id = '$uid' ";
    $result2 = mysqli_query($db, $query2);
    $person_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);

   

    $user_id = $user_array['user_id'];
    $country = $user_array['country'];
    $language = $user_array['language'];
    $date_of_registration = $user_array['date_of_registration'];
    $birthday = $user_array['birthday'];
    $gender = $user_array['gender'];
    $budget = $user_array['budget'];
	 $username = $person_array['username'];
	 $fullname = $person_array['fullname'];
	 $password = $user_array['password'];
	 $email = $person_array['email'];
    $picture = $user_array['picture'];
    $membership_type = $user_array['membership_type'];

    $set = 0;
    if(isset( ($_POST['apply']) ) ){
      if(isset( ($_POST['old_pass']) )  ){
          $query = "SELECT password FROM Person WHERE person_id = $uid' ";
          $result = mysqli_query($db, $query);
          if($_POST['old_pass']) != $password )
        {
          echo '<div class="alert alert-danger" role="alert"> Old password value is not matched.</div>';
        }  

      }
      if(isset( ($_POST['new_pass_1']) )  ){
          $newpass = ($_POST['new_pass_1']);

      }
      else{
        echo '<div class="alert alert-danger" role="alert"> You need to enter new password.</div>';
      }
      if(isset( ($_POST['new_pass_2']) )   ){
          if (  ($_POST['new_pass_2']) == $newpass ){

              $query = "UPDATE person SET password = $newpass WHERE person_id = '$uid' ";
              $result = mysqli_query($db, $query);
              $set = 1;
          }
          else{

            echo '<div class="alert alert-danger" role="alert"> Reentered password is not matched.</div>';

          }
       else{
        echo '<div class="alert alert-danger" role="alert"> You need to enter new password again.</div>';
       } 

       if($set == 1){
        echo '<div class="alert alert-success" role="alert"> Password has changed successfully.</div>';
          header("location: change_general_information.php?");
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
      <li><a href="wiev_playlists.php">Playlist</a></li>
      <li><a href="view_tracks.php">Tracks</a></li>
	<li><a href="friends_list.php">Friends</a></li>
	<li><a href="message_list.php">Messages</a></li>
	<li><a href="search_result_screen.php">Search</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="change_general_information.php"><span class="glyphicon glyphicon-user"></span> Settings</a></li>
      <li><a href="homepage.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>

<form method="post" action="">
  Old password: <input type="psw" name="old_pass" value= "" autofocus>
  <br>
  New password: <input type="psw" name="new_pass_1" value="" autofocus><br>
  Reenter new password  <input type="psw" name="new_pass_2" value=""  autofocus><br>

  <input type="submit" name="apply" value="APPLY" > 

</form> 


<div> 	
<footer>
	<?php
	$query = "SELECT L1.track_id FROM listens L1 WHERE L1.user_id = '$uid' AND 
	date = (SELECT max(L2.date) FROM listens L2 WHERE L2.user_id = '$uid') ";
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