<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_GET['login_id']);

    $publisher_id = $_GET['publisher_id'];
    $query2 = "SELECT * FROM Publisher WHERE publisher_id = {$publisher_id} ";
    $result2 = mysqli_query($db, $query2);
    $publisher_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    $publisher_name = $publisher_array('publisher_name');
    $country = $publisher_array('country');
    $city = $publisher_array('city');

    if(isset($_POST['modify_publisher_button']))
    {
      header("location: modify_track.php?publisher_id=".$publisher_id);
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
          <li class="active"><a href="#">Home</a></li>
          <li><a href="search_admin.php">Search</a></li>
          <li><a href="add_track.php">Add Track</a></li>
          <li><a href="add_album.php">Add Album</a></li>
          <li><a href="add_artist.php">Add Artist</a></li>
          <li><a href="add_publisher.php">Add Publisher</a></li>
        </ul>
        
        <ul class="nav navbar-nav navbar-right">
          <li><a href="change_password.php"><span class="glyphicon glyphicon-user"></span> Change Password</a></li>
          <li><a href="homepage.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
      </div>
    </nav>

   <div align="left" class="col-md-6 col-md-offset-3"><img class="img-circle img-responsive" src="assets/img/ <?php echo $picture_v; ?>" width="200" height="200"></div>
<div class = "container">
<div class="container" align = "left">
  <h3>Publisher <?php echo $publisher_name;?></h3> 
  <p>Country: <?php echo $country ?>
  <p>City:  <?php echo $city ?>

 </div>
 <div class = "container" align = "right">
    <form method="post" action="">
       <input id='Submit' name='modify_publisher_button' value='Submit' type='button' value='Modify Publisher'>

       <input id='Submit' name='delete_publisher_button' value='Submit' type='button' value='Delete Publisher'>
       </form>
    </p>
 </div>
</div>
<div class = "container"> 

<table style="width:100%">
  <tr>
    <th>Album Name</th>
    <th>Album Type</th> 
    <th>Publish Date</th>
  </tr>
  <?php
  $query_album = "SELECT album_name, album_type, published_date, album_id FROM Album WHERE Album.publisher_id = {$publisher_id} ORDER BY published_date";
  $result = mysqli_query($db, $query_album);
  
  while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
      $a_id = $row[3];
      echo "<a href = \"view_album.php?album_id = {$a_id}\"<tr>";
      echo "<td>" . $row[0] . "</td>";
      echo "<td>" . $row[1] . "</td>";
      echo "<td>" . $row[2] . "</td>";
      echo "</tr></a>" 
  }
  ?>
</table>
</div>
</body>
</html>