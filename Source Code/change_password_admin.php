<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
    $query = "SELECT * FROM Admin WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);


    $query2 = "SELECT * FROM person WHERE person_id = '$uid' ";
    $result2 = mysqli_query($db, $query2);
    $person_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);

    $username = $person_array['username'];
    $fullname = $person_array['fullname'];
    $password = $person_array['password'];
    $email = $person_array['email'];

   if(isset( ($_POST['apply']) ) ){

          $old_pass = $_POST['old_pass'];

          if(  strcmp($old_pass, $password) != 0 )  
          {
          echo " <script type=\"text/javascript\"> alert(\"Old password value is not matched.\"); </script>";
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
                   // header("Location: admin.php");
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
      <li><a href="change_password_admin.php"><span class="glyphicon glyphicon-user"></span> Change Password</a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>


<div class="container" align="center">
<h3> Change Password </h3>
<form method="post" action="">
  Old password: <input style="height:25px;font-size:12pt;" type="password" name="old_pass" value= "" autofocus>
  <br><br><br>
  New password: <input style="height:25px;font-size:12pt;" type="password" name="new_pass_1" value="" autofocus>
  <br><br><br>
  Retype new password:  <input style="height:25px;font-size:12pt;" type="password" name="new_pass_2" value=""  autofocus>
  <br><br><br>

  <input style="height:35px;font-size:12pt;" class="btn btn-success" type="submit" name="apply" value="Apply" > 

</form> 
</div>

</body>
</html>