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
      
      <li><a href="own_profile.php">Profile</a></li>
      <li><a href="view_playlists.php">Playlist</a></li>
      <li><a href="view_tracks.php">Tracks</a></li>
  <li><a href="friends.php">Friends</a></li>
  <li><a href="message_list.php">Messages</a></li>
  <li><a href="search.php">Search</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="change_general_information.php"><span class="glyphicon glyphicon-user"></span> Settings</a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>

  <div class="container">
    <h3> Playlist </h3> <br>
    <h3> <?php echo $playlist_name;?> </h3> <p> by <?php echo $username?> </p> <br>
    <p>  <?php echo $playlist_desc;?> </p> <br>
  </div>

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
            echo "<tr onclick = \"document.location = 'view_track.php?track_id={$t_id}' \">";
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
                echo "<tr onclick = \"document.location = 'nonfriend_profile.php?other_id={$person_id}' \">";
                echo "<td>" . $row[1] . "</td>";
                echo "<td>" . $row[2] . "</td>";
                echo "</tr>" ;
              }
              else {
                echo "<tr onclick = \"document.location = 'friend_profile.php?other_id={$person_id}' \">";
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