<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_SESSION['login_id']);

    $publisher_id = $_GET['publisher_id'];
    $query2 = "SELECT * FROM Publisher WHERE publisher_id = {$publisher_id} ";
    $result2 = mysqli_query($db, $query2);
    if($result2 === FALSE){
      echo "<script type=\"text/javascript\"> alert(\"There is no publisher to show!\"); </script>";
    }
    else{
      $publisher_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
      $publisher_name = $publisher_array['publisher_name'];
      $country = $publisher_array['country'];
      $city = $publisher_array['city'];
    }

    if(isset($_POST['modify_publisher_button']))
    {
      header("location: modify_publisher.php?publisher_id=".$publisher_id);
    }
    if(isset($_POST['delete_publisher_button']))
    {
      $query = "CALL DeletePublisher({$publisher_id})";
      $result = mysqli_query($db, $query);
      if($result === FALSE){
        echo "<script type=\"text/javascript\"> alert(\"Publisher could not be deleted.\"); </script>";
      }
      else{
        echo "<script type=\"text/javascript\"> alert(\"Publisher deleted succesfully.\"); </script>";
        header("Location: admin.php");
      }
      
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musicholics - Access Publisher</title>
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

   <div align="center" class="col-md-6 col-md-offset-3"><img class="img-circle img-responsive" src="assets/img/ <?php echo $picture_v; ?>" width="200" height="200"></div>
<div class = "container">
<div class="container" align = "center">
  <h2><?php echo $publisher_name;?></h2> 
  <p>Country: <?php echo $country ?>
  <p>City:  <?php echo $city ?>

 </div>
 <div class = "container" align = "right">
    <form method="post" action="">
       <input id='Submit' name='modify_publisher_button' type='Submit' type='button' value='Modify Publisher' class = "btn btn-warning">

       <input id='Submit' name='delete_publisher_button' type='Submit' type='button' value='Delete Publisher' class = "btn btn-danger">
       </form>
    </p>
 </div>
</div>
<div class = "container" align = "center"> 

<table class = "table table-hover" style="width:100%">
  <tr>
    <th>Album Name</th>
    <th>Album Type</th> 
    <th>Publish Date</th>
  </tr>
  <?php
  $query_album = "SELECT album_name, album_type, published_date, album_id FROM Album WHERE Album.publisher_id = {$publisher_id} ORDER BY published_date";
  $result = mysqli_query($db, $query_album);
  
  while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
      $a_id = $row[3];
      echo "<tr onclick = \"document.location = 'access_album.php?album_id={$a_id}' \">";
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