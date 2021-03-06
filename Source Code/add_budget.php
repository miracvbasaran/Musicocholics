<?php
	  include("session.php");
    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
    $query = "SELECT budget FROM user WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);
    $user_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    
    $budget = $user_array['budget'];

    if(isset( ($_POST['apply']) ) ){

      if(( ($_POST['amount']) ) &&  ( ($_POST['cardno']) != "" ) &&
      ( ($_POST['holdername']) != "" ) && ( ($_POST['securityno']) != "")  ){
        
        $newbudget = $budget+($_POST['amount']);

          $query = "UPDATE user SET budget = '$newbudget' WHERE user_id = '$uid' ";
          $result = mysqli_query($db, $query);

          echo ' <script type="text/javascript"> alert("Amount is added to budget succesfully."); </script>';
          header("Refresh:0");
      }
      else{
        echo ' <script type="text/javascript"> alert("missed to enter some credit card information or the amount."); </script>';
 
      }
    
    }
    if( isset( ($_POST['cancel']) ) ){
      header("location: change_general_information.php");
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musicholics - Add Budget</title>
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
<form method="post" action="">
<h4> Current Budget : <?php echo $budget ?> </h4>
  Amount: $ <input style="height:25px;font-size:12pt;" type="text" name="amount" autofocus> 
  <br><br><br>
  Cardholder's Name: <input style="height:25px;font-size:12pt;" type="text" name="holdername"  autofocus>
  <br><br><br>
  Credit Card Number:  <input style="height:25px;font-size:12pt;" type="text" name="cardno" autofocus>
  <br><br><br>
  
  Expires on: 
  <select name="month" style="height:25px;font-size:12pt;" >
    <option value=1 >1</option>
    <option value=2 >2</option>
    <option value=3 >3</option>
    <option value=4 >4</option>
    <option value=5 selected>5</option>
    <option value=6 >6</option>
    <option value=7 >7</option>
    <option value=8 >8</option>
    <option value=9 >9</option>
    <option value=10 >10</option>
    <option value=11 >11</option>
    <option value=12 >12</option>
  </select> 
  <br><br><br>
  <select name="year" style="height:25px;font-size:12pt;" >
    <option value=2018 selected>2018</option>
    <option value=2019 >2019</option>
    <option value=2020 >2020</option>
    <option value=2021 >2021</option>
    <option value=2022 >2022</option>
    <option value=2023 >2023</option>
    <option value=2024 >2024</option>
    <option value=2025 >2025</option>
    <option value=2026 >2026</option>
  </select> 
  <br><br><br>

  Credit Cart Security Code:  <input style="height:25px;font-size:12pt;" type="text" name="securityno" autofocus><br>
  <br><br><br>
  <input style="height:35px;font-size:12pt;" class="btn btn-success" type="submit" name="apply" value="SUBMIT"  > 
  <input style="height:35px;font-size:12pt;" class="btn btn-danger" type="submit" name="cancel" value= "CANCEL">
  <br><br><br><br>
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

  <h4> <?php if($track_name != "") {echo $track_name; ?> <?php echo "(".$duration.")" ;} ?>  </h4>
  
  <div class="progress">
  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="70"
  aria-valuemin="0" aria-valuemax="100" style="width:70%">
    <span class="sr-only"> </span> 
  </div>
</div>
</body>
</html>
