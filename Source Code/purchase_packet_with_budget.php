<?php
	  include("session.php");
    $uid = mysqli_real_escape_string($db,$_POST'login_id']);
    $query = "SELECT budget FROM user WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);
    $user_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $premium_fee = 9.99;
    $artist_fee = 4.99;
   
    $query2 = "SELECT * FROM person WHERE person_id = '$uid' ";
    $result2 = mysqli_query($db, $query2);
    $person_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);

    $username = $person_array['username'];
  	$fullname = $person_array['fullname'];
  	$email = $person_array['email'];
    $user_id = $person_array['person_id'];
    
    $budget = $user_array['budget'];
    $membership_type = $user_array['membership_type'];

    if(isset( ($_POST['up_premium']) ) && ($membership_type != "premium" || $membership_type != "premium-artist") ){
        
        if($budget >= $premium_fee){

          $newbudget = $budget-$premium_fee;
          
          $query = "UPDATE user SET budget = $newbudget WHERE user_id = '$uid' ";
          $result = mysqli_query($db, $query);

          if( $membership_type == "artist" ){
            $membership_type = "premium-artist";
          }
          if( $membership_type == "normal"){
            $membership_type = "premium";
          }

          $query = "UPDATE user SET membership_type = $membership_type WHERE user_id = '$uid' ";
          $result = mysqli_query($db, $query);

          echo ' <script type="text/javascript"> alert("You are upgraded to premium."); </script>';

          header("location: change_general_information.php?");
        }
        else{
          echo ' <script type="text/javascript"> alert("Your budget is not sufficient. "); </script>';
         
        }
    }
    else{
      echo ' <script type="text/javascript"> alert("You have already premium account."); </script>';
    }
        
    if(isset( ($_POST['up_artist']) ) && ($membership_type != "artist" || $membership_type != "premium-artist") ){
        
        if($budget >= $artist_fee){

          $newbudget = $budget-$artist_fee;
          
          $query = "UPDATE user SET budget = $newbudget WHERE user_id = '$uid' ";
          $result = mysqli_query($db, $query);

          if( $membership_type == "premium" ){
            $membership_type = "premium-artist";
          }
          if( $membership_type == "normal"){
            $membership_type = "artist";
          }

          $query = "UPDATE user SET membership_type = $membership_type WHERE user_id = '$uid' ";

          $result = mysqli_query($db, $query);

          echo ' <script type="text/javascript"> alert("You are upgraded to artist. "); </script>';

          header("location: change_general_information.php?");
        }
        else{
          echo ' <script type="text/javascript"> alert("Your budget is not sufficient."); </script>';
        }
    }
     else{
      echo ' <script type="text/javascript"> alert("You have already artist account."); </script>';
      
    }

    if( isset( ($_POST['cancel']) )){
      header("location: change_general_information.php?");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musicholics - Purchase Packet With Budget</title>
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
      <li><a href="view_own_playlists.php">Playlist</a></li>
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

<h> 
UPGRADE TO PREMIUM
</h>
<h2>
Premium membership fee: <?php echo $premium_fee; ?> <br>

</h2>
<form method="post" action="">

  <input type="submit" name="up_premium" value="Upgrade To Premium"  > 


</form> 

<h> 
UPGRADE TO ARTIST
</h>
<h2>
Artist membership fee: <?php echo $artist_fee; ?> <br>

</h2>
<form method="post" action="">
  <input type="submit" name="up_artist" value="Upgrade To Artist"  > 
 
</form> 

Your budget: $<?php echo $budget; ?> <br>
 <input type="reset" name=cancel value= "Cancel">

<div>
  <footer>
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
          echo $track_name;
          echo $duration;
          ?>
  </footer>
  </div>
</body>
</html>
