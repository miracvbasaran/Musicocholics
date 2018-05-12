<?php
	include("session.php");
    function deleteTrack($track_id){
      $query4 = "DELETE FROM Track WHERE track_id = {$track_id}";
      $result4 = mysqli_query($db, $query4);
      $query4 = "DELETE FROM Track_Belongs_To_Artist WHERE track_id = {$track_id}";
      $result4 = mysqli_query($db, $query4);
      $query4 = "DELETE FROM Added WHERE track_id = {$track_id}";
      $result4 = mysqli_query($db, $query4);
      $query4 = "DELETE FROM Buys WHERE track_id = {$track_id}";
      $result4 = mysqli_query($db, $query4);
      $query4 = "DELETE FROM Gift WHERE track_id = {$track_id}";
      $result4 = mysqli_query($db, $query4);
      $query4 = "DELETE FROM Listens WHERE track_id = {$track_id}";
      $result4 = mysqli_query($db, $query4);
    }
    $uid = mysqli_real_escape_string($db,$_GET['login_id']);
    $query = "SELECT * FROM user WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);
    $user_array = mysqli_fetch_array($result,MYSQLI_ASSOC);


    $album_id = $_GET['album_id'];
    $query2 = "SELECT * FROM Album WHERE album_id = '$album_id' ";
    $result2 = mysqli_query($db, $query2);
    $album_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    $album_name = $album_array['album_name'];
    $picture = $album_array['picture'];
    $album_type = $album_array['album_type'];
    $published_date = $album_array['publisher_id'];


    if(isset($_POST['modify_album_button']))
    {
      header("location: modify_track.php?album_id=".$album_id);
    }
    if(isset($_POST['delete_album_button']))
    {
      $query = "SELECT track_id FROM Track WHERE album_id = {$album_id}";
      $result = mysqli_query($db, $query);
      $track_id_array = array();
      while($temp_array = mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $track_id_array[] = $temp_array['track_id'];
      }
      foreach($track_id_array as $selected_track_id){
        deleteTrack($selected_track_id);
      }
      $query = "DELETE FROM Album_Belongs_To_Artist WHERE album_id = {$album_id}";
      $result = mysqli_query($db, $query);
      $query = "DELETE FROM Album WHERE album_id = {$album_id}";
      $result = mysqli_query($db, $query);
      header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musicholics - View Album</title>
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
     
     <li><a href="search_result_screen.php">Search</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span>Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container">
    
  <div align="left" class="col-md-6 col-md-offset-3"><img class="img-circle img-responsive" src="assets/img/ <?php echo $picture; ?>" width="200" height="200"></div>
</div> 
<div class = "container">
<div class="container" align = "left">
  <h3>Album <?php echo $album_name;?></h3> by Artist <?php
   $query_art = "SELECT Max(artist_name) FROM Artist WHERE artist_id IN (SELECT artist_id FROM Album_Belongs_To_Artist A WHERE album_id = '$album_id')";
   $result_art = mysqli_query($db, $query_art);
   $artist_array = mysqli_fetch_array($result_art,MYSQLI_ASSOC);
   $artist_name = $artist_array['artist_name'];
   echo $artist_name;?>
</div>
<div class "container" align = "right">
  <form method="post" action="">
       <input id='Submit' name='modify_album_button' value='Submit' type='button' value='Modify Album'>

       <input id='Submit' name='delete_album_button' value='Submit' type='button' value='Delete Album'>
  </form>
</div>
</div>



<div class="container">
  <table style="width:100%">
  <tr>
    <th>Song Name</th>
    <th>Length</th> 
    <th>Price</th>
  </tr>
  <?php
  $query_tracks = "SELECT track_id, track_name, duration, price FROM Track T WHERE T.album_id = '$album_id' ORDER BY date_of_addition";
  $result = mysqli_query($db, $query_tracks);
  
  while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
      echo "<a href = view_track.php?track_id = ".$row[0]."><tr>";
      echo "<td>" . $row[1] . "</td>";
      echo "<td>" . $row[2] . "</td>";
      echo "<td>" . $row[3] . "</td>";
      echo "</tr></a>" 
  }
  ?>
</table>

</div>

</body>
</html>