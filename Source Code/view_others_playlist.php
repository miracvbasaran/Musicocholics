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

    $query_my_rate_count = "SELECT count(*) as my_rate_count FROM rates WHERE user_id = {$uid} AND playlist_id = {$playlist_id}";
    $result_my_rate_count = mysqli_query($db, $query_my_rate_count);
    $array_my_rate_count =  mysqli_fetch_array($result_my_rate_count, MYSQLI_ASSOC);
    $my_rate_count = $array_my_rate_count['my_rate_count'];

    $query_my_rate_value = "SELECT rate as my_rate_value FROM rates WHERE user_id = {$uid} AND playlist_id = {$playlist_id}";
    $result_my_rate_value = mysqli_query($db, $query_my_rate_value);
    $array_my_rate_value =  mysqli_fetch_array($result_my_rate_value, MYSQLI_ASSOC);
    $my_rate_value = $array_my_rate_value['my_rate_value'];

    if(isset($_POST['collaborate_playlist'])) {
    	$query4 = "INSERT INTO Collaborates(user_id, playlist_id) VALUES({$uid} , {$playlist_id})";
    	$result4 = mysqli_query($db, $query4);
    	header("location: view_own_playlist.php?playlist_id=".$playlist_id);
    }

    if(isset($_POST['follow_playlist'])) {
      $query9 = "INSERT INTO Follows(user_id, playlist_id) VALUES({$uid} , {$playlist_id})";
      $result9 = mysqli_query($db, $query9);
      header("location: view_others_playlist.php?playlist_id=".$playlist_id);
    }

    if(isset($_POST['post_comment'])) {
    	if(isset($_POST['text_comment'])) {
    		$text_comment = $_POST['text_comment'];
    		$date = date('Y-m-d G:i:s');
    		$query7 = "INSERT INTO Comments(user_id, playlist_id, comment, date) VALUES({$uid}, {$playlist_id}, '$text_comment', '$date')";
          	$result7 = mysqli_query($db, $query7);
		}
		else {
			echo " <script type=\"text/javascript\"> alert(\"Comment is not entered.\"); </script>";
		}
    }

    if(isset($_POST['rate_button'])) {
    	if(isset($_POST['rate_choice'])) {
    		$my_rate = $_POST['rate_choice'];
    		$query8 = "SELECT COUNT(*) as cnt_rate FROM Rates WHERE user_id = {$uid} AND playlist_id = {$playlist_id}";
    		$result8 = mysqli_query($db, $query8);
    		$r_rates_array =  mysqli_fetch_array($result8, MYSQLI_ASSOC);
    		$cnt_rates = $r_rates_array['cnt_rate'];
        if( $cnt_rates == 0 ) {
          $query88 = "INSERT INTO Rates(user_id, playlist_id, rate) VALUES({$uid}, {$playlist_id}, {$my_rate})";
          $result88 = mysqli_query($db, $query88);
          header("Refresh:0");
        }
        else {
          $query99 = "UPDATE Rates SET rate = {$my_rate} WHERE user_id = {$uid} AND playlist_id = {$playlist_id}";
          $result99 = mysqli_query($db, $query99);
          header("Refresh:0");
        }
    	}
    	else {
    		echo " <script type=\"text/javascript\"> alert(\"Rate is not entered.\"); </script>";
    	}
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

	<div class="container" align="center">
		<h3 align="center"> Playlist </h3> <br>
    <img class="img-circle img-responsive" src="images/<?php echo $picture; ?>" width="150" height="150"></div>
     <br>
		<h3 align="center"> <?php echo $playlist_name;?> </h3> <p align="center"> by <?php echo $username?> </p> <br>
		<p align="center">  <?php echo $playlist_desc;?> </p> <br>
	</div>

  <div align="center">
    <form method="post" action="#" onsubmit="">
      <div class="container" align="left">
        <h4> Your Rate: <?php if($my_rate_count == 0) echo "N/A"; else echo $my_rate_value;?> </h4>
        <h4> Average Rate: <?php if($cnt_rate_c == 0) echo "N/A"; else echo $avg_rate;?> </h4>
        <input type="submit" name="rate_button" value="Rate" class="btn btn-danger">
        <select name="rate_choice">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
        <br>
      </div>
      <div class="container" align="right">
        <input id='Submit' name='collaborate_playlist' type='Submit' value='Collaborate Playlist' class="btn btn-primary">
        <input id='Submit' name='follow_playlist' type='Submit' value='Follow Playlist' class="btn btn-primary">
      </div>
      <br/>
    </form>
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

  	<div class="container" align="center">
    	<form method="post" action="">
      		<input type="text" name="text_comment" value= "Comment" autofocus>
          <input id='Submit' name='post_comment' type='Submit' value='Post Comment' class="btn btn-success">
    	</form>
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