<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db, $_SESSION['login_id']);
    $query1 = "SELECT * FROM person WHERE person_id = {$uid}";
    $result1 = mysqli_query($db, $query1);
    $user_array = mysqli_fetch_array($result1, MYSQLI_ASSOC);
    $username = $user_array['username'];

    $query5 = "SELECT * FROM user WHERE user_id = {$uid}";
    $result5 = mysqli_query($db, $query5);
    $u_user_array = mysqli_fetch_array($result5, MYSQLI_ASSOC);
    $membership_type = $u_user_array['membership_type'];

    $playlist_id = $_GET['playlist_id'];
    $query2 = "SELECT * FROM playlist WHERE playlist_id = {$playlist_id}";
    $result2 = mysqli_query($db, $query2);
    $playlist_array =  mysqli_fetch_array($result2, MYSQLI_ASSOC);
    $playlist_name = $playlist_array['playlist_name'];
    $playlist_desc = $playlist_array['description'];
    $playlist_creator = $playlist_array['creator_id'];

    $query_creator_username = "SELECT U.username as creator_username FROM person U, playlist P WHERE P.creator_id = U.person_id AND P.playlist_id = {$playlist_id}";
    $result_creator_username = mysqli_query($db, $query_creator_username);
    $array_creator_username = mysqli_fetch_array($result_creator_username, MYSQLI_ASSOC);
    $creator_username = $array_creator_username['creator_username'];

    if($playlist_array['picture'] == NULL)
    	$picture = "nopl.png";
    else
        $picture = $playlist_array['picture']; 

    $query_sum = "SELECT SUM(T.duration) as sum_duration FROM Track T , Added A WHERE A.playlist_id = {$playlist_id} AND A.track_id = T.track_id";
    $result_sum = mysqli_query($db, $query_sum);
    $sum_array =  mysqli_fetch_array($result_sum, MYSQLI_ASSOC);
    $playlist_sum = $sum_array['sum_duration'];

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

    if(isset($_POST['modify_info'])) {
    	if( $playlist_creator == $uid ) {
    		header("location: modify_playlist_info.php?playlist_id=".$playlist_id);
    	}
    	else {
    		echo ' <script type="text/javascript"> alert("You are a collaborator but not the creator of the playlist."); </script>';
    	}
    }

    if(isset($_POST['add_tracks'])) {
    	header("location: modify_playlist_add.php?playlist_id=".$playlist_id);
    }

    if(isset($_POST['delete_tracks'])) {
    	header("location: modify_playlist_delete.php?playlist_id=".$playlist_id);
    }

    if(isset($_POST['delete_playlist'])) {
    	if( $playlist_creator == $uid ) {
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
	    	header("location: view_playlists.php");
    	}
    	else {
    		echo ' <script type="text/javascript"> alert("You are a collaborator but not the creator of the playlist."); </script>';
    	}
    }

    if(isset($_POST['listen_playlist'])) {
    	$added_query = "SELECT * FROM added WHERE playlist_id = {$playlist_id}";
    	$added_result = mysqli_query($db, $added_query);
	  	while ($row = mysqli_fetch_array($added_result, MYSQLI_ASSOC)) {
      		$t_id = $row['track_id'];
		    $insertion_date = date("Y-m-d H:i:s");
		    $flag = TRUE;
		    if($membership_type == "normal") {
		    	$query = "SELECT count(*) AS num_listens FROM Listens WHERE track_id NOT IN (SELECT track_id FROM Buys WHERE user_id = {$uid}) AND user_id = {$uid} AND date_format(date, '%Y-%m-%d') = '" . date('Y-m-d') ."'";
		        $result = mysqli_query($db, $query);
		        $result_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
		        $num_listens = $result_array['num_listens'];
		        $query = "SELECT * FROM Buys WHERE user_id = {$uid} AND track_id = {$t_id};";
		        $result = mysqli_query($db, $query);
		        if(mysqli_num_rows($result) != 0){
		        	$flag = TRUE;
		        }
		        else if($num_listens > 5){
		        	$flag = FALSE;
		        }
		        else{
		        	$flag = TRUE;
		        }
		    }
		    if($flag) {
		        $query4 = "INSERT INTO Listens VALUES({$uid}, {$t_id}, '$insertion_date');";
		        $result4 = mysqli_query($db, $query4);
		    }
		    else {
		        echo " <script type=\"text/javascript\"> alert(\"PARA BİRİKTİR DE PREMIUM AL!.\"); </script>";
		    }
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
	<title>Musicholics - Own Playlist</title>
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
		<img class="img-circle img-responsive" src="images/<?php echo $picture; ?>" width="150" height="150"></div>
     <br>
		<h1 align="center"> <small> Playlist: </small> <?php echo $playlist_name;?> </h1>
		<h3 align="center"> by <?php echo $creator_username?> </h3> <br>
		<p align="center">  <?php echo $playlist_desc;?> </p> <br>
	</div>

	<div class="container" alight="left">
		<p>
			<form method="post" action="">
				<input id='Submit' name='modify_info' type='Submit' value='Modify Info' class="btn btn-primary">
			</form>
		</p>
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
		</form>
	</div>
	<br><br>

	<div class="container" alight="left">
		<p>
			<form method="post" action="">
				<input id='Submit' name='listen_playlist' type='Submit' value='Listen Playlist' class="btn btn-primary">
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
     				echo "<tr onclick = \"document.location = 'view_track.php?track_id={$t_id}' \">";
     				echo "<td>" . $row[1] . "</td>";
     				echo "<td>" . $row[2] . "</td>";
    				echo "<td>" . $row[3] . "</td>";
     				echo "</tr>";
	  			}
	  		?>
		</table>
	</div>

	<div class="container" align="left">
		<p>
			<form method="post" action="">
				<input id='Submit' name='add_tracks' type='Submit' value='Add Tracks' class="btn btn-success">
				<input id='Submit' name='delete_tracks' type='Submit' value='Delete Tracks' class="btn btn-warning">
			</form>
		</p>
	</div>

	<br><br><br>
	
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