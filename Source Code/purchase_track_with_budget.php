<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_GET['login_id']);
    $query = "SELECT budget FROM user WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);
    $user_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    
   
    $query2 = "SELECT * FROM person WHERE person_id = '$uid' ";
    $result2 = mysqli_query($db, $query2);
    $person_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);

    $username = $person_array['username'];
  	$fullname = $person_array['fullname'];
  	$email = $person_array['email'];
    $user_id = $person_array['person_id'];
    
    $budget = $user_array['budget'];
    $membership_type = $user_array['membership_type'];


    $track_id = mysqli_real_escape_string($db,$_GET['track_id']);
    $query3 = " SELECT * FROM track WHERE track_id = '$track_id' ";
    $result3 = mysqli_query($db, $query3);
    $track_array = mysqli_fetch_array($result3,MYSQLI_ASSOC);

    $track_name = $track_array['track_name'];
    $price = $track_array['price'];

    if(isset( ($_POST['purchase']) ) ){
        
        if($budget >= $price){

          $newbudget = $budget-$price;
          
          $query = "UPDATE user SET budget = $newbudget WHERE user_id = '$uid' ";
          $result = mysqli_query($db, $query);

          $query = "INSERT INTO buys VALUES( '$uid', '$track_id' ) ";
          $result = mysqli_query($db, $query);

          echo ' <script type="text/javascript"> alert("You purchased {$track_name} successfully."); </script>';

          header("location: search_result_screen.php?");
        }
        else{
          echo ' <script type="text/javascript"> alert("Your budget is not sufficient."); </script>';
        }
    }
        
    if( isset( ($_POST['cancel']) )){
      header("location: search_result_screen.php?");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musicholics - Purchase Track With Budget</title>
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
	<li><a href="search_result_screen.php">Search</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="change_general_information.php"><span class="glyphicon glyphicon-user"></span> Settings</a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>

<h> 
Purchase <?php echo $track_name; ?> <br> 

Price of <?php echo $track_name echo ": ";  echo $price; ?> <br>

Your budget: $<?php echo $budget; ?> <br>

</h>

<form method="post" action="">
  <input type="submit" name="purchase" value="Purchase"  > 
  <input type="reset" name=cancel value= "Cancel">
</form> 

 

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
