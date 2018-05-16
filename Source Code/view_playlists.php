<?php
	include("session.php");
   $uploaddir = getcwd().'/images/';
    $uid = mysqli_real_escape_string($db, $_SESSION['login_id']);
    $query1 = "SELECT * FROM user WHERE user_id = {$uid} ";
    $result1 = mysqli_query($db, $query1);
    $user_array = mysqli_fetch_array($result1, MYSQLI_ASSOC);

    if(isset($_POST['create_playlist'])) {
    	if(isset($_POST['playlist_name'])) {
        if(isset($_POST['playlist_description'])) {
          $playlist_name = $_POST['playlist_name'];
          $playlist_description = $_POST['playlist_description'];
          $date = date('Y-m-d');


          $query_insert = "INSERT INTO Playlist(playlist_name, description, creator_id, date) VALUES('$playlist_name', '$playlist_description',  {$uid}, '$date')";
          $result_insert = mysqli_query($db, $query_insert);
          $query5 = "SELECT MAX(playlist_id) as new_id FROM Playlist";
          $result5 = mysqli_query($db, $query5);
          $index_array = mysqli_fetch_array($result5, MYSQLI_ASSOC);
          $new_id = $index_array['new_id'];

          $name = $_FILES['userphoto']['name']; 
          $ext = pathinfo($_FILES['userphoto']['name'], PATHINFO_EXTENSION);
          $uploadfile = $uploaddir . "pl" . $new_id . '.' . $ext;
          $filename = "pl" . $new_id . '.' . $ext;
          $picture = $filename;
          if($name == ""){
              $picture = NULL;
            }

          $query1 = "UPDATE playlist SET picture = '$picture' WHERE playlist_id = '$new_id'";
          $result1 = mysqli_query($db, $query1);
          

        if (move_uploaded_file($_FILES['userphoto']['tmp_name'], $uploadfile)) {
            echo '<div class="alert alert-success" role="alert">Photo uploaded successfully. </div>';
            
        } else {    
          echo '<div class="alert alert-danger" role="alert">Error on uploading  photo. </div>';
        }
      
         

          header("location: modify_playlist_add.php?playlist_id=".$new_id);
        }
        else {
          echo ' <script type="text/javascript"> alert("Playlist description is not entered."); </script>';
        }
      }
      else {
        echo ' <script type="text/javascript"> alert("Playlist name is not entered."); </script>';
      }

    }
    		
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Musicholics - Own Playlists</title>
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
    <h3> Playlists </h3> <br>
    <form method="post" action="" enctype="multipart/form-data">

      <input class="btn btn-primary btn-sm" type="file" name="userphoto" id="userphoto" accept="image/*"> 
      <br>

      Playlist Name: <input type="text" name="playlist_name" value= "" autofocus> <br>
      Description: <textarea class="form-control" rows="2" name="playlist_description" autofocus></textarea><br>
      <input type="submit" name="create_playlist" value="Create Playlist" class="btn btn-success"> <br><br>
    </form>
  </div>

  <div class="container">
    <h3> Creator </h3> <br>
    <table class = "table table-hover" style="width:100%">
        <tr>
          <th>Name</th>
          <th>Description</th> 
        </tr>
        <?php
          $query_playlist = "SELECT P.playlist_id, P.playlist_name, P.description, P.date FROM Playlist P WHERE P.creator_id = {$uid} ORDER BY P.date";
          $result_playlist = mysqli_query($db, $query_playlist);
          while ($row = mysqli_fetch_array($result_playlist, MYSQLI_NUM)) {
              $p_id = $row[0];
              echo "<tr onclick = \"document.location = 'view_own_playlist.php?playlist_id={$p_id}' \">";
              echo "<td>" . $row[1] . "</td>";
              echo "<td>" . $row[2] . "</td>";
              echo "</tr>" ;
          }
        ?>
    </table>
  </div>

  <div class="container">
    <h3> Collaborator </h3> <br>
    <table class = "table table-hover" style="width:100%">
        <tr>
          <th>Name</th>
          <th>Description</th> 
        </tr>
        <?php
          $query_playlist = "SELECT P.playlist_id, P.playlist_name, P.description, P.date FROM Playlist P , Collaborates C WHERE C.user_id = {$uid} AND P.playlist_id = C.playlist_id ORDER BY P.date";
          $result_playlist = mysqli_query($db, $query_playlist);
          while ($row = mysqli_fetch_array($result_playlist, MYSQLI_NUM)) {
              $p_id = $row[0];
              echo "<tr onclick = \"document.location = 'view_own_playlist.php?playlist_id={$p_id}' \">";
              echo "<td>" . $row[1] . "</td>";
              echo "<td>" . $row[2] . "</td>";
              echo "</tr>" ;
          }
        ?>
    </table>
  </div>

  <div class="container">
    <h3> Follower </h3> <br>
    <table class = "table table-hover" style="width:100%">
        <tr>
          <th>Name</th>
          <th>Description</th> 
        </tr>
        <?php
          $query_playlist = "SELECT P.playlist_id, P.playlist_name, P.description, P.date FROM Playlist P , Follows F WHERE F.user_id = {$uid} AND P.playlist_id = F.playlist_id ORDER BY P.date";
          $result_playlist = mysqli_query($db, $query_playlist);
          while ($row = mysqli_fetch_array($result_playlist, MYSQLI_NUM)) {
              $p_id = $row[0];
              echo "<tr onclick = \"document.location = 'view_others_playlist.php?playlist_id={$p_id}' \">";
              echo "<td>" . $row[1] . "</td>";
              echo "<td>" . $row[2] . "</td>";
              echo "</tr>" ;
          }
        ?>
    </table>
  </div>
<br><br><br><br><br><br><br><br><br>
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