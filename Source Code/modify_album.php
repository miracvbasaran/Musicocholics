<?php
	include("session.php");
  $uploaddir = getcwd().'/images/';
    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
    $query = "SELECT admin_id FROM admin WHERE user_id = {$uid} ";
    $result = mysqli_query($db, $query);

    $album_id = $_GET['album_id'];
    $query2 = "SELECT * FROM Album WHERE album_id = {$album_id} ";
    $result2 = mysqli_query($db, $query2);
    $album_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    $album_name = $album_array['album_name'];
    $album_type = $album_array['album_type'];
    $published_date = $album_array['published_date'];
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
        $query = "SELECT artist_name FROM Artist WHERE artist_id = {$a_id};";
        $result = mysqli_query($db, $query);
        $artist_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $artist_names[] = $artist_array['artist_name'];
    }
    
    $query = "SELECT * FROM Publisher WHERE publisher_id = {$publisher_id};";
    $result = mysqli_query($db, $query);
    $publisher_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $publisher_name = $publisher_array['publisher_name'];
    
    if(isset($_POST['apply']))
    {
      if(isset( ($_POST['album_name']) )  ){
          $album_name = $_POST['album_name'];
          $query = "UPDATE Album SET album_name = '{$album_name}' WHERE album_id = {$album_id};";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['album_type']) )  ){
          $album_type = $_POST['album_type'];
          $query = "UPDATE Album SET album_type = '{$album_type}' WHERE album_id = {$album_id};";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['published_date']) )  ){
          $published_date = $_POST['published_date'];
          $query = "UPDATE Album SET published_date = '{$published_date}' WHERE album_id = ${album_id};";
          $result = mysqli_query($db, $query);
      }

        $name = $_FILES['userphoto']['name']; 
        $ext = pathinfo($_FILES['userphoto']['name'], PATHINFO_EXTENSION);
        $uploadfile = $uploaddir . "album" . $album_id . '.' . $ext;
        $filename = "album" . $album_id . '.' . $ext;

        $query1 = "UPDATE album SET picture = '$filename' WHERE album_id = '$album_id'";
        $result1 = mysqli_query($db, $query1);

        $picture = $filename;

        if($name == ""){
            $picture = NULL;
          }
      if (move_uploaded_file($_FILES['userphoto']['tmp_name'], $uploadfile)) {
            echo '<div class="alert alert-success" role="alert">Photo uploaded successfully. </div>';
            
        } else {    
          echo '<div class="alert alert-danger" role="alert">Error on uploading  photo. </div>';
        }

      header("location: access_album.php?album_id=".$album_id);
    }
    if(isset($_POST['delete_tracks'])){
      if(!empty($_POST['check_list'])){
        foreach($_POST['check_list'] as $selected_track_id){
            $selected_track_id = intval($selected_track_id);
            $query4 = "CALL DeleteTrack({$selected_track_id});";
            $result4 = mysqli_query($db, $query4);
        }
      }
      header("Refresh:0");
    }
    if(isset($_POST['add_track']))
    {
      $new_track_name = $_POST['new_track_name'];
      $new_track_price = $_POST['new_track_price'];
      $new_track_duration = $_POST['new_track_duration'];
      $insertion_date = date('Y-m-d');
      $query = "INSERT INTO Track(track_name, price, date_of_addition, duration, album_id) VALUES('{$new_track_name}', {$new_track_price}, '{$insertion_date}', \"{$new_track_duration}\", $album_id)";
      if(mysqli_query($db, $query)){
          $query = "SELECT LAST_INSERT_ID()";
          $result = mysqli_query($db, $query);
          $index_array = mysqli_fetch_array($result, MYSQLI_NUM);
          $album_id = $index_array[0];
          header("Refresh:0");
      }
      else{
        echo ' <script type="text/javascript"> alert("Could not add track to album."); </script>';
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
          <li><a href="admin.php">Home</a></li>
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

   
<div class = "container" align = "center">
  <h3>
<?php
      echo $album_name;
      echo "<small> by ";
      for ($i=0; $i < count($artist_names); $i++) { 
        $art_id = $artist_ids[$i];
        echo "<a href = \"access_artist.php?artist_id={$art_id}\">" . $artist_names[$i] . "</a>";
        if(count($artist_names) != 1 && $i < count($artist_names) - 1){
          echo ", ";
        }
      }
    ?>
</small>
</h3>
</div>


<form method="post" action="" enctype="multipart/form-data">
  <div class = "container" align = "center">

   <img class="img-circle img-responsive" src="images/<?php echo $picture; ?>" width="100" height="100">
  
  <input class="btn btn-primary btn-sm" type="file" name="userphoto" id="userphoto" accept="image/*"> 
  <br>

<div class = "col-xs-3" >Album Name: <input type="text" class = "form-control" name="album_name" 
    default = <?php echo "'".$album_name."'"; ?> value= <?php echo "'".$album_name."'"; ?> autofocus> 
</div>
  <div class="col-xs-3">Album Type: 
  <select class = "form-control" name="album_type">
    <option value="Album">Album</option>
    <option value="Single">Single</option>
  </select></div>
 <div class="col-xs-3">Date: <input type="date" class = "form-control" name="published_date" value= <?php echo $published_date ?> autofocus></div>
  <div class="container" align = "right"><br><input type="submit" name="apply" value="Apply"  class = "btn btn-success"> </div></div>

 </form>
<div class="container" align = "center">
  <form method="post" action="">
  <table class = "table table-hover" style="width:100%">
  <tr>
    <th>Song Name</th>
    <th>Length</th> 
    <th>Price</th>
    <th></th>
  </tr>
  <?php
  $query_album = "SELECT track_name, duration, price, track_id FROM Track WHERE Track.album_id = ${album_id} ORDER BY date_of_addition";
  $result = mysqli_query($db, $query_album);
  
  while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
      $t_id = $row[3];
      echo "<tr>";
      echo "<td><a href = \"access_track.php?track_id={$t_id}\">" . $row[0] . "</a></td>";
      echo "<td>" . $row[1] . "</td>";
      echo "<td>" . $row[2] . "</td>";
      echo "<td> <input class = \"form-control\" type = \"checkbox\" name = \"check_list[]\" value = \"{$t_id}\"></td>";
      echo "</tr>";
  }
  ?>
</table>

<div class = "container" align = "right"><input type="submit" name="delete_tracks" value="Delete Tracks" class = "btn btn-danger"></div>
</form>

</div>
 </div>
 <div class="container">

<form method="post" action="">
  <h3>Add Track</h3>
  <div class="col-xs-3">Track Name: <input type="text" class = "form-control" name="new_track_name"  autofocus></div>
  <div class="col-xs-3">Duration: <input type="time" class = "form-control" name="new_track_duration"  step="1" autofocus></div>
  <div class="col-xs-3">Price (in $): <input type="number" class = "form-control" step="0.01" name="new_track_price" style="text-align:right;" autofocus></div>

  <div class="col-xs-3"><br><input type="submit" name="add_track" value="Add Track"  class = "btn btn-success"> </div>

 </form> 
 </div>

</body>
</html>