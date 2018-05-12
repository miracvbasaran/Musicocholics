<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_GET['user_id']);
    $query = "SELECT admin_id FROM admin WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);

    $artist_id = $_GET['artist_id'];
    $query2 = "SELECT * FROM Artist WHERE artist_id = '$artist_id' ";
    $result2 = mysqli_query($db, $query2);
    $artist_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    $artist_name = $artist_array('artist_name');
    $description = $artist_array('description');
    $picture = $artist_array('picture');
    

    if(isset($_POST['apply']))
    {
      if(isset( ($_POST['artist_name']) )  ){
          $artist_name = $_POST['artist_name'];
          $query = "UPDATE Artist SET artist_name = {$artist_name} WHERE artist_id = {$artist_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['description']) )  ){
          $description = $_POST['description'];
          $query = "UPDATE Artist SET description = {$description} WHERE artist_id = {$artist_id} ";
          $result = mysqli_query($db, $query);
      }
    }
    if(isset($_POST['delete_albums'])){
      if(!empty($_POST['check_list']){
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

      $query = "SELECT publisher_id FROM Publisher WHERE publisher_name = '{$new_album_publisher}'";
      $result = mysqli_query($db, $query);
      $index_array = mysqli_fetch_array($result, MYSQLI_NUM);
      if($index_array == FALSE){
        echo "ERROR MESSAGE: There is no such Publisher";
      }
      else{
        $publisher_id = $index_array[0];

        $query = "INSERT INTO Album(album_name, album_type, published_date, publisher_id) VALUES({$new_album_name}, {$new_album_type}, {$new_album_publish_date}, {$publisher_id})";
        mysqli_query($db, $query);
          $query = "SELECT MAX(album_id) FROM Album";
          $result = mysqli_query($db, $query);
          $index_array = mysqli_fetch_array($result, MYSQLI_NUM);
          $album_id = $index_array[0];
          header("location: modify_album.php?album_id=".$album_id);

      
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
  <div class="container" align = "center"><h3><input type="text" name="name" value= <?php echo $artist_name ?> autofocus></h3></div>
  <br>
  <input type="text" name="description" value= <?php echo "\"".$description."\"" ?> autofocus> <br>
  

  <input type="submit" name="apply" value="APPLY"  > 

 </form> 

 </div>

 <div class="container">
  <form method="post" action="">
  <table style="width:100%">
  <tr>
    <th>Album Name</th>
    <th>Album Type</th> 
    <th>Publish Date</th>
    <th></th>
  </tr>
  <?php
  $query_album = "SELECT album_name, album_type, published_date, album_id FROM Album WHERE Album.album_id = IN (SELECT album_id FROM Album_Belongs_To_Artist A WHERE 
                    A.artist_id = '$artist_id$') ORDER BY published_date";
  $result = mysqli_query($db, $query_album);
  
  while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
      $a_id = $row[3];
      echo "<a href = \"view_album.php?album_id = {$a_id}\"><tr>";
      echo "<td>" . $row[0] . "</td>";
      echo "<td>" . $row[1] . "</td>";
      echo "<td>" . $row[2] . "</td></a>";
      echo "<td> <input type = \"checkbox\" name = \"check_list[]\" value = \"{$a_id}\"></td>";
      echo "</tr>" 
  }
  ?>
</table>

<input type="submit" name="delete_albums" value="Delete"/>
</form>

</div>

 <div class="container">

<form method="post" action="">
  <h3>Add Album</h3>
  <input type="text" name="new_album_name" value= "Album Name" autofocus>
  <input type = "text" name"new_album_publisher" value "Publisher Name" autofocus>
  <select name="new_album_type">
    <option value="Album">Album</option>
    <option value="Single">Single</option>
  </select>
  <input type="text" name="new_album_publish_date" value= "Publish Date" autofocus>
  

  <input type="submit" name="apply" value="add_album"  > 

 </form> 
 </div>

</body>
</html>