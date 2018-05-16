<?php
  include("session.php");
    $uid = mysqli_real_escape_string($db, $_SESSION['login_id']);
    $query1 = "SELECT * FROM person WHERE person_id = {$uid} ";
    $result1 = mysqli_query($db, $query1);
    $user_array = mysqli_fetch_array($result1, MYSQLI_ASSOC);

    $playlist_id = $_GET['playlist_id'];
    $query2 = "SELECT * FROM playlist WHERE playlist_id = {$playlist_id}";
    $result2 = mysqli_query($db, $query2);
    $playlist_array =  mysqli_fetch_array($result2, MYSQLI_ASSOC);
    $playlist_name = $playlist_array['playlist_name'];
    $playlist_desc = $playlist_array['description'];
    $playlist_creator = $playlist_array['creator_id'];

     if($playlist_array['picture'] == NULL)
        $picture = "nopl.png";
      else
        $picture = $playlist_array['picture']; 

    $query_sum = "SELECT SUM(T.duration) as sum_duration FROM Track T , Added A WHERE A.playlist_id = {$playlist_id} AND A.track_id = T.track_id";
    $result_sum = mysqli_query($db, $query_sum);
    $sum_array =  mysqli_fetch_array($result_sum, MYSQLI_ASSOC);
    $playlist_sum = $sum_array['sum_duration'];

    $query5 = "SELECT * FROM person WHERE person_id = {$playlist_creator}";
    $result5 = mysqli_query($db, $query5);
    $creator_array =  mysqli_fetch_array($result5, MYSQLI_ASSOC);
    $username = $creator_array['username'];

    $query_c = "SELECT COUNT(rate) as cnt_rate FROM rates WHERE playlist_id = {$playlist_id}";
    $result_c = mysqli_query($db, $query_c);
    $rates_array_c =  mysqli_fetch_array($result_c, MYSQLI_ASSOC);
    $cnt_rate_c = $rates_array_c['cnt_rate'];

    $query3 = "SELECT AVG(rate) as avg_rate FROM rates WHERE playlist_id = {$playlist_id}";
    $result3 = mysqli_query($db, $query3);
    $rates_array =  mysqli_fetch_array($result3, MYSQLI_ASSOC);
    $avg_rate = $rates_array['avg_rate'];

    if(isset($_POST['delete_playlist'])) {
      $queryD2 = "DELETE FROM added WHERE playlist_id = {$playlist_id} ";
      $resultD2 = mysqli_query($db, $queryD2);
      $queryD3 = "DELETE FROM follows WHERE playlist_id = {$playlist_id} ";
      $resultD3 = mysqli_query($db, $queryD3);
      $queryD4 = "DELETE FROM rates WHERE playlist_id = {$playlist_id} ";
      $resultD4 = mysqli_query($db, $queryD4);
      $queryD5 = "DELETE FROM comments WHERE playlist_id = {$playlist_id} ";
      $resultD5 = mysqli_query($db, $queryD5);
      $queryD6 = "DELETE FROM collaborates WHERE playlist_id = {$playlist_id} ";
      $resultD6 = mysqli_query($db, $queryD6);
      $queryD1 = "DELETE FROM playlist WHERE playlist_id = {$playlist_id} ";
      $resultD1 = mysqli_query($db, $queryD1);
      header("location: access_playlists.php?other_id=".$playlist_creator);
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Musicholics - Playlist</title>
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

  <div class="container" align="center">
    <h3> Playlist </h3> <br>
     <img class="img-circle img-responsive" src="images/<?php echo $picture; ?>" width="150" height="150"></div>
     <br>
     
    <h3 align="center"> <?php echo $playlist_name;?> </h3> <p align="center"> by <?php echo $username?> </p> <br>
    <p align="center">  <?php echo $playlist_desc;?> </p> <br>
    
  </div>

  <div class="container" alight="left">
    <p>
      <form method="post" action="">
        <input id='Submit' name='delete_playlist' type='Submit' value='Delete Playlist' class="btn btn-danger">
      </form>
    </p>
  </div>
  <br><br><br>

  <div class="container">
    <table class = "table table-hover" style="width:100%">
        <tr>
          <th>Song name</th>
          <th>Length</th>
          <th>Price</th> 
        </tr>
        <?php
          $query_playlist = "SELECT A.track_id , T.track_name , T.duration , T.price FROM added A , Track T WHERE A.track_id = T.track_id AND A.playlist_id = {$playlist_id}";
          $result_playlist = mysqli_query($db, $query_playlist);
          while ($row = mysqli_fetch_array($result_playlist, MYSQLI_NUM)) {
              $t_id = $row[0];
            echo "<tr onclick = \"document.location = 'access_track.php?track_id={$t_id}' \">";
            echo "<td>" . $row[1] . "</td>";
            echo "<td>" . $row[2] . "</td>";
            echo "<td>" . $row[3] . "</td>";
            echo "</tr>";
          }
        ?>
    </table>
  </div>

  <div class="container">
    <table class = "table table-hover" style="width:100%">
        <tr>
          <th>Username</th>
          <th>Comment</th> 
        </tr>
        <?php
          $query_comment = "SELECT P.person_id , P.username , C.comment FROM person P , comments C WHERE P.person_id = C.user_id AND C.playlist_id = {$playlist_id}";
          $result_comment  = mysqli_query($db, $query_comment);
          while ($row = mysqli_fetch_array($result_comment, MYSQLI_NUM)) {
              $person_id = $row[0];
              $query_friend = "SELECT COUNT(*) as cntfriend FROM friendship F WHERE (F.user1_id={$uid} AND F.user2_id={$person_id}) OR (F.user2_id={$uid} AND F.user1_id={$person_id})";
              $result_friend = mysqli_query($db, $query_friend);
              $friend_array = mysqli_fetch_array($result_friend, MYSQLI_ASSOC);
              $cnt_friend = $friend_array['cntfriend'];
              if( $row[0] == $uid ) {
                echo "<tr onclick = \"document.location = 'own_profile.php' \">";
                echo "<td>" . $row[1] . "</td>";
                echo "<td>" . $row[2] . "</td>";
                echo "</tr>" ;
              }
              else if( $cnt_friend == 0 ) {
                echo "<tr onclick = \"document.location = 'complete_profile.php?other_id={$person_id}' \">";
                echo "<td>" . $row[1] . "</td>";
                echo "<td>" . $row[2] . "</td>";
                echo "</tr>" ;
              }
              else {
                echo "<tr onclick = \"document.location = 'complete_profile.php?other_id={$person_id}' \">";
                echo "<td>" . $row[1] . "</td>";
                echo "<td>" . $row[2] . "</td>";
                echo "</tr>" ;
              }
          }
        ?>
    </table>
  </div>

<br><br><br><br><br>

<style>
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   text-align: center;
}
</style>

</body>

</html>