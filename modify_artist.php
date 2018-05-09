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
      if(isset( ($_POST['country']) )  ){
        $country = $_POST['country'];
          $query = "UPDATE Publisher SET country = {$country} WHERE publisher_id = {$publisher_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['city']) )  ){
          $country = $_POST['city'];
          $query = "UPDATE Publisher SET city = {$city} WHERE publisher_id = {$publisher_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['publisher_name']) )  ){
          $publisher_name = $_POST['publisher_name']
          $query = "UPDATE Publisher SET publisher_name = {$publisher_name} WHERE publisher_id = ${publisher_id} ";
          $result = mysqli_query($db, $query);
      }
    }
    if(isset($_POST['add_album']))
    {
      $new_album_name = $_POST['new_album_name']
      $new_album_type = $_POST['new_album_type']
      $new_album_publish_date = $_POST['new_album_publish_date']
      $query = "INSERT INTO Album(album_name, album_type, published_date) VALUES({$new_album_name}, {$new_album_type}, {$new_album_publish_date})";
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
  City:  <input type="text" name="city" value= <?php echo "\"".$city."\"" ?> autofocus>
  

  <input type="submit" name="apply" value="APPLY"  > 

 </form> 

 </div>
 <div class="container">
  <form action="" method="post" enctype="multipart/form-data">
    <input class="btn btn-primary btn-sm" type="file" name="photo" id="photo" accept="image/*"> <button class="btn btn-success btn-sm" type="submit" name="uploadpic">Update</button>
 </form>

<form method="post" action="">
  <h3>Add Album</h3>
  <input type="text" name="new_album_name" value= "Album Name" autofocus>
  <input type="text" name="new_album_type" value= <?php echo "\"".$city."\"" ?> autofocus>
  <input type="text" name="new_album_publish_date" value= "Publish Date" autofocus>
  

  <input type="submit" name="apply" value="add_album"  > 

 </form> 
 </div>

</body>
</html>