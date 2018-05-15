<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
    $query = "SELECT * FROM user WHERE user_id = {$uid} ";
    $result = mysqli_query($db, $query);
    $user_array = mysqli_fetch_array($result,MYSQLI_ASSOC);


    $album_id = $_GET['album_id'];
    $query2 = "SELECT * FROM Album WHERE album_id = {$album_id} ";
    $result2 = mysqli_query($db, $query2);
    $album_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    $album_name = $album_array['album_name'];
    $album_type = $album_array['album_type'];
    $published_date = $album_array['published_date'];
    $publisher_id =$album_array['publisher_id'];

    if($album_array['picture'] == NULL)
        $picture = "nophoto.png";
    else
        $picture = $album_array['picture'];

    $query = "SELECT artist_id FROM Album_Belongs_To_Artist WHERE album_id = {$album_id}";
    $result = mysqli_query($db, $query);
    $artist_ids = array();
    while($artist_array = mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $artist_ids[] = $artist_array['artist_id'];
    }

    $artist_names = array();
    for($i = 0; $i < count($artist_ids); $i++){
        $a_id = $artist_ids[$i];
        $query = "SELECT artist_name FROM Artist WHERE artist_id = {$a_id}";
        $result = mysqli_query($db, $query);
        $artist_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $artist_names[] = $artist_array['artist_name'];
    }

    $query = "SELECT * FROM Publisher WHERE publisher_id = {$publisher_id} ";
    $result = mysqli_query($db, $query);
    $publisher_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $publisher_name = $publisher_array['publisher_name'];
    
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
    

 

<div class="container" align = "center">

 <img class="img-circle img-responsive" src="images/<?php echo $picture; ?>" width="150" height="150"></div>
  <h2><?php echo $album_name;?> by <small> 
  <?php
      for ($i=0; $i < count($artist_names); $i++) { 
        $art_id = $artist_ids[$i];
        echo "<a href = \"view_artist.php?artist_id={$art_id}\">" . $artist_names[$i] . "</a>";
        if(count($artist_names) != 1 && $i < count($artist_names) - 1){
          echo ", ";
        }
      }
    ?></small></h2>
   <br>
   <h3>
    From Publisher <?php echo "<a href = \"view_publisher.php?publisher_id={$publisher_id}\"> {$publisher_name}</a>"; ?>
   </h3>
</div>


</div> 

<div class="container" align = "center">
  <table class = "table table-hover" style="width:100%">
  <tr>
    <th>Song Name</th>
    <th>Length</th> 
    <th>Price</th>
  </tr>
  <?php
  $query_tracks = "SELECT track_id, track_name, duration, price FROM Track T WHERE T.album_id = '$album_id' ORDER BY date_of_addition";
  $result = mysqli_query($db, $query_tracks);
  
  while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
      echo "<tr onclick = \"document.location = 'view_track.php?track_id={$row[0]}' \">";
      echo "<td>" . $row[1] . "</td>";
      echo "<td>" . $row[2] . "</td>";
      echo "<td>" . $row[3] . "</td>";
      echo "</tr></a>" ;
  }
  ?>
</table>

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