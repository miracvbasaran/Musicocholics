<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
    $query = "SELECT * FROM user WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);
    $user_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
 
    $user_id = $user_array['user_id'];
    
    $budget = $user_array['budget'];


    $track_id = mysqli_real_escape_string($db,$_GET['track_id']);
    $query3 = "SELECT * FROM track WHERE track_id = '$track_id' ";
    $result3 = mysqli_query($db, $query3);
    $track_array = mysqli_fetch_array($result3,MYSQLI_ASSOC);

    $track_name = $track_array['track_name'];
    $price = $track_array['price'];

    if(isset( ($_POST['purchase']) ) ){
        
        if($budget >= $price){


          if(isset( ($_POST['giftname']) ) ){

            $giftedname = ($_POST['giftname']) ;
            $query = "SELECT * FROM Person WHERE username = '$giftedname' ";
            $result = mysqli_query($db, $query);


            if(mysqli_num_rows($result) > 0){
                $gifted_array = mysqli_fetch_array($result,MYSQLI_ASSOC);

                $gifted_id = $gifted_array['person_id'];
                //Check if gifted_user has the track
                $query = "SELECT * FROM Buys WHERE user_id = {$gifted_id} AND track_id = {$track_id} ";
                $result = mysqli_query($db, $query);
                if(mysqli_num_rows($result) === 0){
                  $query = " INSERT INTO gift VALUES('$uid', '$gifted_id', '$track_id' )";
                  $result = mysqli_query($db, $query);

                  $newbudget = $budget-$price;

                  $query = "UPDATE user SET budget = '$newbudget' WHERE user_id = '$uid' ";
                  $result = mysqli_query($db, $query);

                  //$query = "INSERT INTO buys VALUES({$gifted_id}, {$track_id})";
                  //$result = mysqli_query($db, $query);
                  if($result){
                    echo ' <script type="text/javascript"> alert("You purchased the track as a gift successfully!"); </script>';
                  }
                }
                else{
                  echo ' <script type="text/javascript"> alert("He already has this track!"); </script>';
                }
                
                //header("Location: view_track.php?track_id=".$track_id);

            }
            else{
              echo ' <script type="text/javascript"> alert("There is no such user."); </script>';
            }
                     
          }
          else{
             echo ' <script type="text/javascript"> alert("You need to give name the user that will receive the gift!"); </script>';
  
          }
          
        }
        else{
          echo ' <script type="text/javascript"> alert("Your budget is not sufficient!"); </script>';
          
          
        }   
    }
        
    if( isset( ($_POST['cancel']) )){
      header("Location: view_track.php?track_id=".$track_id);
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

<h> 
Purchase <?php echo $track_name; ?> <br> 

Price of <?php echo $track_name; echo ": ";  echo $price; ?> <br>

Your budget: $<?php echo $budget; ?> <br>

</h>

<form method="post" action="">
   
  Name of the user that you purchase a gift: <br>
 <input type="text" name="giftname"  autofocus><br>
  <input type="submit" name="purchase" class = "btn btn-success"value="Purchase"  > 
  <input type="submit" class = "btn btn-danger" name = "cancel" value= "Cancel">
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
