<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);


    $artist_id = $_GET['artist_id'];
    $query2 = "SELECT * FROM Artist WHERE artist_id = '$artist_id' ";
    $result2 = mysqli_query($db, $query2);
    if($result2 === FALSE){
      echo ' <script type="text/javascript"> alert("There is no artist to show!"); </script>';
      header("Location: admin.php");
    }
    else{
      $artist_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
      $artist_name = $artist_array['artist_name'];
      $description = $artist_array['description'];
     

      if($artist_array['picture'] == NULL)
        $picture = "nophoto.png";
      else
        $picture = $artist_array['picture']; 
    }

    if(isset($_POST['modify_artist_button']))
    {
      header("location: modify_artist.php?artist_id=".$artist_id);
    }
    if(isset($_POST['delete_artist_button']))
    {
      $query = "CALL DeleteArtist({$artist_id})";
      $result = mysqli_query($db, $query);
      if($result === FALSE){
        echo ' <script type="text/javascript"> alert("Could not delete artist!"); </script>';
      }
      else{
        echo ' <script type="text/javascript"> alert("Artist successfully deleted!"); </script>';
        header("Location: admin.php");
      }
      
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musicholics - Access Artist</title>
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
		  <li><a href="admin.php">Admin</a></li>
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



<div class = "container">
<div class="container" align = "center">
  <img class="img-circle img-responsive" src="images/<?php echo $picture; ?>" width="150" height="150"></div>

  <div class = "container" align = "center"><h2><?php echo $artist_name;?></h2></div>
  <div class = "well"><p><?php echo $description;?></p></div>
</div>
<div class = "container" align = "right">
  <form method="post" action="">
       <input id='Submit' name='modify_artist_button' type='Submit' class="btn btn-warning" value='Modify Artist'>

       <input id='Submit' name='delete_artist_button' type='Submit' class="btn btn-danger" value='Delete Artist'>
  </form>
 </div>
</div>


    
<div class="container">
  <table class = "table table-hover" style="width:100%">
  <tr>
    <th>Album Name</th>
    <th>Album Type</th> 
    <th>Publish Date</th>
  </tr>
  <?php
  $query_album = "SELECT album_name, album_type, published_date, album_id FROM Album WHERE Album.album_id IN (SELECT album_id FROM Album_Belongs_To_Artist A WHERE A.artist_id = {$artist_id}) ORDER BY published_date DESC";
  $result = mysqli_query($db, $query_album);
  
  while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
      echo "<tr onclick = \"document.location = 'access_album.php?album_id={$row[3]}' \">";
      echo "<td>" . $row[0] . "</td>";
      echo "<td>" . $row[1] . "</td>";
      echo "<td>" . $row[2] . "</td>";
      echo "</tr>";
  }
  ?>
</table>

</div>



</body>
</html>