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

    if(isset( ($_POST['submit']) ) ){

      if(isset( ($_POST['amount']) ) &&  isset( ($_POST['cardno']) ) &&
      isset( ($_POST['holdername']) ) && isset( ($_POST['securityno']) )  ){
        
        $newbudget = $budget+($_POST['amount']);

          $query = "UPDATE user SET budget = $newbudget WHERE user_id = '$uid' ";
          $result = mysqli_query($db, $query);

          echo ' <script type="text/javascript"> alert("Amount is added to budget succesfully."); </script>';
          
          header("location: change_general_information.php?");
      }
      else{
        echo ' <script type="text/javascript"> alert("You missed to enter some credit card information or the amount."); </script>';
      }
    
    }
    else if( isset( ($_POST['cancel']) ) ){
      header("location: change_general_information.php?");
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
	<li><a href="friends_list.php">Friends</a></li>
	<li><a href="message_list.php">Messages</a></li>
	<li><a href="search_result_screen.php">Search</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="change_general_information.php"><span class="glyphicon glyphicon-user"></span> Settings</a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>


<form method="post" action="">

  Amount: $ <input type="number" name="amount" autofocus> 
  <br>
  Cardholder's Name: <input type="text" name="holdername"  autofocus><br>

  Credit Card Number:  <input type="number" name="cardno" autofocus><br>
  
  Expires on: 
  <select name="month">
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

  <select name="year">
    <option value=2018 selected>2018</option>
    <option value=2019 >2019</option>
    <option value=2020 >2020</option>
    <option value=2021 >2021</option>
    <option value=2022 >2022</option>
    <option value=2023 >2023</option>
    <option value=2024 >2024</option>
    <option value=2025 >2025</option>
    <option value=2026 >2026</option>
  </select> <br>

  Credit Cart Security Code:  <input type="number" name="securityno" autofocus><br>
  
  <input type="submit" name="apply" value="SUBMIT"  > 
  <input type="reset" name=cancel value= "CANCEL">

</form> 


<div > 	
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
