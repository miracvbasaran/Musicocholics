<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_SESSION['user_id']);
    $query = "SELECT * FROM Admin WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);
    $admin_array = mysqli_fetch_array($result,MYSQLI_ASSOC);

    $query2 = "SELECT * FROM person WHERE person_id = '$uid' ";
    $result2 = mysqli_query($db, $query2);
    $person_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);


    $set = 0;
    if(isset( ($_POST['apply']) ) ){
      if(isset( ($_POST['old_pass']) )  ){
          $query = "SELECT password FROM Person WHERE person_id = '$uid' ";
          $result = mysqli_query($db, $query);
          if($_POST['old_pass'] != $password )
        {
          echo ' <script type="text/javascript"> alert("Old password value is not matched."); </script>';
        
        }  

      }
      if(isset( ($_POST['new_pass_1']) )  ){
          $newpass = ($_POST['new_pass_1']);

      }
      else{
        echo ' <script type="text/javascript"> alert("You need to enter new password."); </script>';
       
      }
      if(isset( ($_POST['new_pass_2']) )   ){
          if (  ($_POST['new_pass_2']) == $newpass ){

              $query = "UPDATE person SET password = $newpass WHERE person_id = '$uid' ";
              $result = mysqli_query($db, $query);
              $set = 1;
          }
          else{
            echo ' <script type="text/javascript"> alert("Passwords are not matched."); </script>';
            

          }
       else{
        echo ' <script type="text/javascript"> alert("You need to enter new password again."); </script>';
       
       } 

       if($set == 1){
        echo ' <script type="text/javascript"> alert("Password has changed successfully."); </script>';
       
          header("location: change_general_information.php?");
       }
      
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musicholics - Change Password</title>
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
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>

<form method="post" action="">
  Old password: <input type="psw" name="old_pass" value= "" autofocus>
  <br>
  New password: <input type="psw" name="new_pass_1" value="" autofocus><br>
  Reenter new password  <input type="psw" name="new_pass_2" value=""  autofocus><br>

  <input type="submit" name="apply" value="Apply" > 

</form> 


</body>
</html>