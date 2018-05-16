<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db, $_SESSION['login_id']);
    $query1 = "SELECT * FROM user WHERE user_id = {$uid} ";
    $result1 = mysqli_query($db, $query1);
    $user_array = mysqli_fetch_array($result1, MYSQLI_ASSOC);
    
    $query_sum = "SELECT sum(is_not_read) as no_of_new_messages FROM sends_message WHERE receiver_id = {$uid}";
    $result_sum = mysqli_query($db, $query_sum);
    $sum_array = mysqli_fetch_array($result_sum, MYSQLI_ASSOC);
    $no_of_new_messages = $sum_array['no_of_new_messages'];

    if(isset($_POST['sent_box_button'])) {
      header("location: sent_message_list.php");
    }
    if(isset($_POST['mark_read_button'])) {
      $query_update = "UPDATE sends_message SET is_not_read = 0 WHERE receiver_id = {$uid}";
      $result_update = mysqli_query($db, $query_update);
      header("Refresh:0");
    }
    if(isset($_POST['send_optional_message'])) {
    	header("location: send_optional_message.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Musicholics - Message List</title>
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
		<h3> Inbox </h3> <br>
    <h4> <?php echo $no_of_new_messages?> New Messages </h4> <br>
		<div align="right" class="container"></div>
		<p>
			<form method="post" action="">
        <input id='Submit' name='sent_box_button' type='Submit' value='Sent Box' class="btn btn-primary"> <br><br>
        <input id='Submit' name='mark_read_button' type='Submit' value='Mark as Read' class="btn btn-warning"> <br><br>
				<input id='Submit' name='send_optional_message' type='Submit' value='Send Message' class="btn btn-success"> <br><br>
			</form>
		</p>
	</div>

	<div class="container">
		<table class = "table table-hover" style="width:100%">
	  		<tr>
	    		<th>Name</th>
	    		<th>Message</th> 
          <th>Read Status</th>
	  		</tr>
	  		<?php
	  			$query_message = "SELECT P.person_id, P.fullname, M.message, M.is_not_read FROM sends_message M , person P WHERE P.person_id = M.sender_id AND M.receiver_id = {$uid} ORDER BY M.date";
	  			$result_message = mysqli_query($db, $query_message);
	  			while ($row = mysqli_fetch_array($result_message, MYSQLI_NUM)) {
      				$p_id = $row[0];
      				$query_friend = "SELECT COUNT(*) as cntfriend FROM friendship F WHERE (F.user1_id={$uid} AND F.user2_id={$p_id}) OR (F.user2_id={$uid} AND F.user1_id={$p_id})";
      				$result_friend = mysqli_query($db, $query_friend);
      				$friend_array = mysqli_fetch_array($result_friend, MYSQLI_ASSOC);
      				$cnt_friend = $friend_array['cntfriend'];
      				if( $cnt_friend === 0 ) {
      					echo "<tr onclick = \"document.location = 'nonfriend_profile.php?other_id={$p_id}' \">";
	      				echo "<td>" . $row[1] . "</td>";
	      				echo "<td>" . $row[2] . "</td>";
                if( $row[3] == 1 ) {
                  echo "<td>" . "You haven't read yet!" . "</td>";
                }
                else {
                  echo "<td>" . "You have already read." . "</td>";
                }
	      				echo "</tr>" ;
	      			}
	      			else {
      					echo "<tr onclick = \"document.location = 'friend_profile.php?other_id={$p_id}' \">";
	      				echo "<td>" . $row[1] . "</td>";
	      				echo "<td>" . $row[2] . "</td>";
                if( $row[3] == 1 ) {
                  echo "<td>" . "You haven't read yet!" . "</td>";
                }
                else {
                  echo "<td>" . "You have already read." . "</td>";
                }
	      				echo "</tr>" ;
	      			}
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