<?php
	include("session.php");
  $uploaddir = getcwd().'/images/';
    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
    $query = "SELECT admin_id FROM admin WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);

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


    if(isset($_POST['apply']))
    {
      if(isset( ($_POST['artist_name']) )  ){
          $artist_name = $_POST['artist_name'];
          $query = "UPDATE Artist SET artist_name = '{$artist_name}' WHERE artist_id = {$artist_id};";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['description']) )  ){
          $description = $_POST['description'];
          $query = "UPDATE Artist SET description = '{$description}' WHERE artist_id = {$artist_id};";
          $result = mysqli_query($db, $query);

      }
          $name = $_FILES['userphoto']['name']; 
        $ext = pathinfo($_FILES['userphoto']['name'], PATHINFO_EXTENSION);
        $uploadfile = $uploaddir . "art" . $artist_id . '.' . $ext;
        $filename = "art" . $artist_id . '.' . $ext;
        $query1 = "UPDATE artist SET picture = '$filename' WHERE artist_id = '$artist_id'";
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
         

      header("location: access_artist.php?artist_id=".$artist_id);
    }
    if(isset($_POST['delete_albums']))
    {
      if(!empty($_POST['check_list'])){
        foreach($_POST['check_list'] as $selected_album_id){
            $selected_album_id = intval($selected_album_id);
            $query = "CALL DeleteAlbumFromArtist({$selected_album_id}, {$artist_id})";
            $result = mysqli_query($db, $query);
        }
      }
      header("Refresh:0");
    }
    if(isset($_POST['add_album']))
    {
      $new_album_name = $_POST['new_album_name'];
      $new_album_type = $_POST['new_album_type'];
      $new_album_publish_date = $_POST['new_album_publish_date'];
      $new_album_publisher = $_POST['new_album_publisher'];

      $query = "SELECT * FROM Publisher WHERE publisher_name = '$new_album_publisher';";
      $result = mysqli_query($db, $query);
      if($result){
        $index_array = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $publisher_id = $index_array['publisher_id'];
        $query = "INSERT INTO Album(album_name, album_type, published_date, publisher_id) VALUES('{$new_album_name}', '{$new_album_type}', '{$new_album_publish_date}', {$publisher_id})";
        if(mysqli_query($db, $query) === TRUE){
          $query = "SELECT LAST_INSERT_ID()";
          $result = mysqli_query($db, $query);
          $index_array = mysqli_fetch_array($result, MYSQLI_NUM);
          $album_id = $index_array[0];

          $query = "INSERT INTO Album_Belongs_To_Artist(album_id, artist_id) VALUES({$album_id}, {$artist_id});";
          $result = mysqli_query($db, $query);
          echo "<script type=\"text/javascript\"> alert(\"Succesfully added album to artist.\"); </script>";

          header("location: modify_album.php?album_id=".$album_id);
        }
        else{
          echo ' <script type="text/javascript"> alert("Could not add album to artist."); </script>';
        }
      
      }
      else{
        echo ' <script type="text/javascript"> alert("There is no such publisher"); </script>';
        
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musicholics - Modify Artist</title>
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

  

<form method="post" action="" enctype="multipart/form-data">
<div class="container" align = "center">

 <img class="img-circle img-responsive" src="images/<?php echo $picture; ?>" width="100" height="100">
  
  <input class="btn btn-primary btn-sm" type="file" name="userphoto" id="userphoto" accept="image/*"> 
  <br>
  
   <div class="form-group"><div class="col-xs-4"><input type="text" class = "form-control" name="artist_name" default = <?php echo "'".$artist_name."'"; ?> value= <?php echo "'".$artist_name."'"; ?> autofocus>
  <br></div>
  <div class="col-xs-4"><input type="text" class = "form-control" name="description" value= <?php echo "'".$description."'"; ?> autofocus> <br></div>
  <div class="col-xs-4"><input type="submit" name="apply" value="Apply"  class = "btn btn-success"> </div></div>
</div>
 </form> 

 </div>

 <div class="container">
  <form method="post" action="">
  <table class ="table table-hover" style="width:100%">
  <tr>
    <th>Album Name</th>
    <th>Album Type</th> 
    <th>Publish Date</th>
    <th></th>
  </tr>
  <?php
  $query_album = "SELECT album_name, album_type, published_date, album_id FROM Album WHERE Album.album_id IN (SELECT album_id FROM Album_Belongs_To_Artist A WHERE A.artist_id = '$artist_id$') ORDER BY published_date DESC";
  $result = mysqli_query($db, $query_album);
  
  while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
      $a_id = $row[3];
      echo "<tr>";
      echo "<td><a href = \"access_album.php?album_id={$a_id}\">" . $row[0] . "</a></td>";
      echo "<td>" . $row[1] . "</td>";
      echo "<td>" . $row[2] . "</td>";
      echo "<td> <input class = \"form-control\" type = \"checkbox\" name = \"check_list[]\" value = \"{$a_id}\"></td>";
      echo "</tr>";
  }
  ?>
</table>
<div class = "container" align = "right">
<input type="submit" name="delete_albums" value="Delete" class = "btn btn-danger"></div>
</form>

</div>

 <div class="container">
<h3>Add Album</h3>
<form method="post" action="">
  
  <div class="col-xs-3">Album Name: <input class = "form-control" type="text" name="new_album_name"  autofocus></div>
  <div class="col-xs-3">Album Publisher: <input class = "form-control" type = "text" name = "new_album_publisher"  autofocus></div>
   <div class="col-xs-3">Album Type: <select class = "form-control" name="new_album_type">
    <option  value="Album">Album</option>
    <option  value="Single">Single</option>
  </select></div>
  <div class="col-xs-3">Publish Date: <input type="date" class = "form-control" name="new_album_publish_date" autofocus></div>
  

  <div class = "container" align = "right"><input type="submit" name="add_album" value="Add Album" class = "btn btn-success"> </div>

 </form> 
 </div>

</body>
</html>