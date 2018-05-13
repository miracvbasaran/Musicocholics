<?php
	  include("session.php");
    $dir = getcwd().'/assets/img/';
    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
    $query = "SELECT * FROM user WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);
    $user_array = mysqli_fetch_array($result,MYSQLI_ASSOC);

    $query2 = "SELECT * FROM person WHERE person_id = '$uid' ";
    $result2 = mysqli_query($db, $query2);
    $person_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);

   
    $fullname = $person_array['fullname'];
    $password = $person_array['password'];
    $user_id = $person_array['person_id'];
    $email = $person_array['email'];
    $username = $person_array['username'];

    $country = $user_array['country'];
    $language = $user_array['language'];
    $date_of_registration = $user_array['date_of_registration'];
    $birthday = $user_array['birthday'];
    $gender = $user_array['gender'];
    $budget = $user_array['budget'];
    $picture = $user_array['picture'];
    $membership_type = $user_array['membership_type'];

    if( isset( $_POST["apply"] ) ) {
      if(isset( ($_POST["country"]) ))  {
          $country = $_POST["country"];
          $query = "UPDATE user SET country = '$country' WHERE user_id = '$uid' ";
          $result = mysqli_query($db, $query);

      }
      if(isset( ($_POST['fullname']) ) )  {
          $fullname = $_POST['fullname'];
          $query = "UPDATE user SET fullname = '$fullname' WHERE user_id = '$uid' ";
          $result = mysqli_query($db, $query);
          $resultP = mysqli_query($db,  "UPDATE person SET fullname = '$fullname' WHERE person_id = '$uid' ");

      }
      if(isset( ($_POST['username']) ) )  {
          $username = $_POST['username'];
          $query = "UPDATE user SET username = '$username' WHERE user_id = '$uid' ";
          $result = mysqli_query($db, $query);
          $resultP = mysqli_query($db,  "UPDATE person SET username = '$username' WHERE person_id = '$uid' ");

      }
      if(isset( ($_POST['email']) ) )  {
          $email = $_POST['email'];
          $query = "UPDATE user SET email = '$email' WHERE user_id = '$uid' ";
          $result = mysqli_query($db, $query);
          $resultP = mysqli_query($db,  "UPDATE person SET email = '$email' WHERE person_id = '$uid' ");

      }
      if(isset( ($_POST['birthday']) ) )  {
          $query = "UPDATE user SET birthday = '$birthday' WHERE user_id = '$uid' ";
          $result = mysqli_query($db, $query);

      }
      if(isset( ($_POST['language']) ) )  {
          $language = $_POST['language'];
          $query = "UPDATE user SET language = '$language' WHERE user_id = '$uid' ";
          $result = mysqli_query($db, $query);

      }
      if(isset( ($_POST['gender']) ) )  {
          $gender = $_POST['gender'];
          $query = "UPDATE user SET gender = '$gender' WHERE user_id = '$uid' ";
          $result = mysqli_query($db, $query);

      }
      echo ' <script type="text/javascript"> alert("Profile information is changed successfully."); </script>';
  
      header("Refresh:0");
    }

     if(isset($_POST["uploadpic"]))
    {
        $name       = $_FILES['photo']['name']; 
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $uploadfile = $dir . $uid . '.' . $ext;
        $filename = $login_id . '.' . $ext;
        $query = "UPDATE User SET picture = '$filename' WHERE user_id = '$uid'";
        $result = mysqli_query($db, $query);
        
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile) ) {
          echo ' <script type="text/javascript"> alert("Profile photo uploaded successfully."); </script>';
          
        } else {
            echo ' <script type="text/javascript"> alert("Error on uploading profile photo."); </script>';
           
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

<div align="left" class="col-md-6 col-md-offset-3"><img class="img-circle img-responsive" src="assets/img/ <?php echo $picture; ?>" width="200" height="200"></div>

<form action="" method="post" enctype="multipart/form-data">
    <input class="btn btn-primary btn-sm" type="file" name="photo" id="photo" accept="image/*"> <button class="btn btn-success btn-sm" type="submit" name="uploadpic">Update</button>
 </form>

<form method="post" action="">
  Fullname: <input type="text" name="fullname" value= <?php echo "{$fullname}"; ?> autofocus>
  <br><br>

  Username: <input type="text" name="username" value= <?php echo "{$username}";?> autofocus>
  <br><br>
  
  E-mail address:   <input type="email" name="email" value= <?php echo "{$email}";?> autofocus>
  <br><br>

  Birthday: <input type="date" name="birthday" value= <?php echo "{$birthday}";?> autofocus> 
  <br><br>

  Contry: <select name="country">
    <option value="Turkey">Turkey</option>
    <option value="USA">USA</option>
    <option value="England">England</option>
    <option value="Germany">Germany</option>
  </select> <br>

  Language: <select name="language">
    <option value="Turkish">Turkish</option>
    <option value="English">English</option>
    <option value="German">German</option>
    
  </select> <br>

  Gender: <select name="gender">
    <option value="Female">Female</option>
    <option value="Male">Male</option>
  </select> <br>

  Membership Type : <?php echo $membership_type; ?>
  <br><br>

  Current Budger : <?php echo $budget; ?>
  <br><br>
  <input type="submit" class="btn btn-success" name="apply" value="APPLY" > 

</form> 

<div class="container">
    <br> <br>

      <a href="purchase_packet_with_budget.php" class="btn btn-success" role="button">CHANGE PACKET</a>
     <br><br>

      <a href="add_budget.php" class="btn btn-success" role="button"> UPLOAD MONEY TO BUDGET</a>
      <br><br>

      <a href="change_password.php" class="btn btn-success" role="button">PASSWORD CHANGE</a>
      <br><br>

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
