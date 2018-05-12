<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_GET['login_id']);


    $artist_id = $_GET['artist_id'];
    $query2 = "SELECT * FROM Artist WHERE artist_id = '$artist_id' ";
    $result2 = mysqli_query($db, $query2);
    $artist_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    $artist_name = $artist_array['artist_name'];
    $description = $artist_array['description'];
    $picture = $artist_array['picture'];  


    if(isset($_POST['modify_artist_button']))
    {
      header("location: modify_track.php?artist_id=".$artist_id);
    }
    if(isset($_POST['delete_artist_button']))
    {
      $query = "SELECT album_id FROM Album_Belongs_To_Artist WHERE artist_id = {$artist_id}";
      $result = mysqli_query($db, $query);
      $album_id_array = array();
      while($temp_array = mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $album_id_array[] = $temp_array['album_id'];
      }
      foreach($album_id_array as $selected_album_id){
        $query = "DELETE FROM Album_Belongs_To_Artist WHERE album_id = {$selected_album_id} AND artist_id = {$artist_id}";
        $result = mysqli_query($db, $query);
        $query = "SELECT count(*) as num_entries FROM Album_Belongs_To_Artist WHERE album_id = {$selected_album_id}";
        $result = mysqli_query($db, $query);
        $temp_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $num_entries = $temp_array['num_entries'];
        if($num_entries === 0){
          $query = "DELETE FROM Album WHERE album_id = {$selected_album_id}";
          $result = mysqli_query($db, $query);
        }
      }
      $query = "DELETE FROM Artist WHERE artist_id = {$artist_id}";
      $result = mysqli_query($db, $query);
      header('Location: ' . $_SERVER['HTTP_REFERER']);
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
     
     <li><a href="search_result_screen.php">Search</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span>Logout</a></li>
    </ul>
  </div>
</nav>



<div class = "container">
<div class="container" align = "left">
  <div class="col-md-6 col-md-offset-3"><img class="img-circle img-responsive" src="assets/img/ <?php echo $picture; ?>" width="200" height="200"></div>

  <h3><?php echo $artist_name;?></h3>
  <div class = "container"><p><?php echo $description;?></p></div>
</div>
<div class = "container" align = "right">
  <form method="post" action="">
       <input id='Submit' name='modify_artist_button' value='Submit' type='button' value='Modify Artist'>

       <input id='Submit' name='delete_artist_button' value='Submit' type='button' value='Delete Artist'>
  </form>
 </div>
</div>


    
<div class="container">
  <table style="width:100%">
  <tr>
    <th>Album Name</th>
    <th>Album Type</th> 
    <th>Publish Date</th>
  </tr>
  <?php
  $query_album = "SELECT album_name, album_type, published_date FROM Album WHERE Album.album_id = IN (SELECT album_id FROM Album_Belongs_To_Artist A WHERE 
                    A.artist_id = '$artist_id$') ORDER BY published_date";
  $result = mysqli_query($db, $query_album);
  
  while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
      echo "<tr>";
      echo "<td>" . $row[0] . "</td>";
      echo "<td>" . $row[1] . "</td>";
      echo "<td>" . $row[2] . "</td>";
      echo "</tr>" 
  }
  ?>
</table>

</div>



</body>
</html>