<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_GET['user_id']);
    $query = "SELECT admin_id FROM admin WHERE user_id = {$uid} ";
    $result = mysqli_query($db, $query);

    $album_id = $_GET['album_id'];
    $query2 = "SELECT * FROM Album WHERE album_id = {$album_id} ";
    $result2 = mysqli_query($db, $query2);
    $album_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    $album_name = $album_array('album_name');
    $picture = $album_array('picture');
    $album_type = $album_array('album_type');
    $published_date = $album_array('published_date');
    $publisher_id = $album_array('publisher_id');

    $query = "SELECT artist_id FROM Album_Belongs_To_Artist WHERE album_id = {$album_id}";
    $result = mysqli_query($db, $query);
    $artist_ids = array();
    while($artist_array = mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $artist_ids[] = artist_array['artist_id'];
    }

    $artist_names = array();
    for($i = 0; $i < artist_ids.count(); $i++){
        $a_id = $artist_ids[$i];
        $query = "SELECT artist_name FROM Artist WHERE artist_id = {$a_id}";
        $result = mysqli_query($db, $query);
        $artist_array = mysqli_fetch_array($result,MYSQLI_ASSOC)
        $artist_names[] = $artist_array['artist_name'];
    }
    

    if(isset($_POST['apply']))
    {
      if(isset( ($_POST['album_name']) )  ){
          $album_name = $_POST['album_name'];
          $query = "UPDATE Album SET album_name = {$album_name} WHERE album_id = {$album_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['album_type']) )  ){
          $album_type = $_POST['album_type'];
          $query = "UPDATE Album SET album_type = {$album_type} WHERE album_id = {$album_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['published_date']) )  ){
          $published_date = $_POST['published_date']
          $query = "UPDATE Album SET published_date = {$published_date} WHERE album_id = ${album_id} ";
          $result = mysqli_query($db, $query);
      }
    }
    if(isset($_POST['delete_tracks'])){
      if(!empty($_POST['check_list']){
        foreach($_POST['check_list'] as $selected_track_id){
            $selected_track_id = intval($selected_track_id);
            $query4 = "CALL DeleteTrack({$selected_track_id})";
            $result4 = mysqli_query($db, $query4);
        }
      }
      header("Refresh:0");
    }
    if(isset($_POST['add_track']))
    {
      $new_track_name = $_POST['new_track_name']
      $new_track_price = $_POST['new_track_price']
      $insertion_date = date(Y-m-d);
      $query = "INSERT INTO Track(album_name, album_type, published_date) VALUES({$new_album_name}, {$new_album_type}, {$new_album_publish_date})";
      if(mysqli_query($db, $query) === TRUE){
          $query = "SELECT LAST_INSERT_ID()"
          $result = mysqli_query($db, $query);
          $index_array = mysqli_fetch_array($result, MYSQLI_NUM);
          $album_id = $index_array[0];
          header("location: modify_album.php?album_id=".$album_id);
      }
      else{
        echo "ERROR MESSAGE";
      }
      
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musicholics - Modify Album</title>
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

   <div align="left" class="col-md-6 col-md-offset-3"><img class="img-circle img-responsive" src="assets/img/ <?php echo $picture_v; ?>" width="200" height="200"></div>

<div class="container">

<form action="" method="post" enctype="multipart/form-data">
    <input class="btn btn-primary btn-sm" type="file" name="photo" id="photo" accept="image/*"> <button class="btn btn-success btn-sm" type="submit" name="uploadpic">Update</button>
 </form>

<form method="post" action="">
  <div class="container" align = "center"><h3><input type="text" name="album_name" value= <?php echo $album_name ?> autofocus> by 

    <?php
      for ($i=0; $i < $artist_names.count(); $i++) { 
        echo $artist_names[$i];
        if($artist_names.count() != 1 && $i < $artist_names.count() - 1){
          echo ", ";
        }
      }
    ?>
</h3></div>
  <br>
  Album Type:
  <select name="album_type">
    <option value="Album">Album</option>
    <option value="Single">Single</option>
  </select>
  <input type="text" name="published_date" value= <?php echo $published_date ?> autofocus>
  <input type="submit" name="apply" value="Apply"  > 

 </form> 
<div class="container">
  <form method="post" action="">
  <table style="width:100%">
  <tr>
    <th>Song Name</th>
    <th>Length</th> 
    <th>Price</th>
    <th></th>
  </tr>
  <?php
  $query_album = "SELECT track_name, duration, price, track_id FROM Track WHERE Track.album_id = ${album_id} ORDER BY date_of_addition";
  $result = mysqli_query($db, $query_album);
  
  while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
      $t_id = $row[3];
      echo "<a href = view_track.ph?track_id = {$t_id}<tr>";
      echo "<td>" . $row[0] . "</td>";
      echo "<td>" . $row[1] . "</td>";
      echo "<td>" . $row[2] . "</td></a>";
      echo "<td> <input type = \"checkbox\" name = \"check_list[]\" value = \"{$t_id}\"></td>";
      echo "</tr>" 
  }
  ?>
</table>

<input type="submit" name="delete_tracks" value="Delete"/>
</form>

</div>
 </div>
 <div class="container">

<form method="post" action="">
  <h3>Add Track</h3>
  <input type="text" name="new_track_name" value= "Track Name" autofocus>
  <input type="text" name="new_track_price" value= "Price" ?> autofocus>

  <input type="submit" name="add_track" value="Add Track"  > 

 </form> 
 </div>

</body>
</html>