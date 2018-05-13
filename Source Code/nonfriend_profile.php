<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
    $query = "SELECT * FROM user WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);
    $user_array = mysqli_fetch_array($result,MYSQLI_ASSOC);


    $nonfriend_id = $_GET['other_id'];
    $query2 = "SELECT * FROM person WHERE person_id = '$nonfriend_id'";
    $result2 = mysqli_query($db, $query2);
    $nonfriend_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    $username_non = $nonfriend_array['username'];
    $fullname_non = $nonfriend_array['fullname'];


    $query4 = "SELECT country, picture,gender FROM user WHERE user_id = '$nonfriend_id'";
    $result4 = mysqli_query($db, $query4);
    $nonfriend_array_u = mysqli_fetch_array($result4,MYSQLI_ASSOC);
    $country_non = $nonfriend_array_u['country'];
    $picture_non = $nonfriend_array_u['picture'];
    $gender_non = $nonfriend_array_u['gender'];

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musicholics - Profile</title>
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
  
<div class="container">

  
  <h3>This is, <?php echo $username_non;?> </h3> 
  	<p> 

      <div align="left" class="col-md-6 col-md-offset-3"><img class="img-circle img-responsive" src="assets/img/ <?php echo $picture_non; ?>" width="200" height="200"></div>
      
      
    
    <p> Fullname: <?php echo $fullname_non;?></p><br>
    <p> Country: <?php echo $country_non;?></p><br>
    <p> Gender: <?php echo $gender_non;?></p><br>
    
    </p>
    
    <div> 
    
      
        <a href="add_friend.php?other_id=<?php echo $nonfriend_id; ?> " class="btn btn-success" role="button">ADD AS FRIEND</a>
    </div>
    

</div>
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
