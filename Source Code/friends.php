<?php
// Turn off all error reporting
error_reporting(0);
?>
<?php 
	include("session.php");
	$uid = mysqli_real_escape_string($db,$_SESSION['login_id']);
    $query = "SELECT * FROM user WHERE user_id = '$uid' ";
    $result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Musicholics - Friends</title>
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
		<h3> Friends </h3> <br>
	</div>


		<div class="container">
    <table class = "table table-hover" style="width:60%">
		<tr>
          <th>Username</th>
          <th>Fullname</th>
        </tr>
		<?php
		$query = mysqli_query( $db, "SELECT F.user2_id FROM Friendship F WHERE user1_id = '$uid'");
    $query2 = mysqli_query($db, "SELECT F.user1_id FROM Friendship F WHERE user2_id = '$uid'");
		
   /* while( $row = $query->fetch_assoc()){
			if( $user2_id === $uid)
				$fid = $row[user1_id];
			else 
				$fid = $row[user2_id];*/  
      while($row = $query->fetch_assoc()){

        $fid = $row['user2_id'];
        $query_p = mysqli_query( $db, "SELECT username, fullname FROM Person WHERE '$fid' = person_id");
        $row_big = $query_p->fetch_assoc();
  			
        echo "<tr onclick = \"document.location = 'friend_profile.php?other_id={$fid}' \">";
                  echo "<td>" . $row_big['username'] . "</td>";
                  echo "<td>" . $row_big['fullname'] . "</td>";
        echo "</tr>" ;
    }
      while($row2 = $query2->fetch_assoc()){

        $fid = $row2['user1_id'];
        $query_p = mysqli_query( $db, "SELECT username, fullname FROM Person WHERE '$fid' = person_id");
        $row_big = $query_p->fetch_assoc();
        
        echo "<tr onclick = \"document.location = 'friend_profile.php?other_id={$fid}' \">";
                  echo "<td>" . $row_big['username'] . "</td>";
                  echo "<td>" . $row_big['fullname'] . "</td>";
        echo "</tr>" ;

			//echo( "<tr><td><a href='friend_profile.php?other_id=".$fid."'>".$row['username']."</a></td></tr><br><br/>");
			
		}
		
		
		?>
		
	 </table>
  </div>

<style>
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   text-align: center;
}
</style>
<div class = "footer">

  <?php
  $query = "SELECT L1.track_id FROM listens L1 WHERE L1.user_id = '$uid' AND 
  date = (SELECT max(L2.date) FROM listens L2 WHERE L2.user_id = '$uid') ";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_array($result, MYSQLI_NUM);
  $query2 = "SELECT track_name,duration FROM track WHERE track_id = '$row[0]' ";
  $result2 = mysqli_query($db, $query2);
  $track_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);

  $track_name = $track_array['track_name'];
  $duration = $track_array['duration'];
  ?>

  <h4> <?php echo $track_name; ?> (<?php echo $duration; ?> ) </h4>
  
  <div class="progress">
  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="70"
  aria-valuemin="0" aria-valuemax="100" style="width:70%">
    <span class="sr-only"> </span> 
  </div>
</div>
</body>
</html>
