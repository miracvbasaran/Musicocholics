<?php 
	include("session.php");
	$uid = mysqli_real_escape_string($db,$_SESSION['login_id']);


	$query = "SELECT COUNT(*) AS num_users FROM USER;";
    $result = mysqli_query($db, $query);
    $result_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $num_users = $result_array['num_users'];

    $query = "SELECT COUNT(*) AS num_albums FROM Album;";
    $result = mysqli_query($db, $query);
    $result_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $num_albums = $result_array['num_albums'];

    $query = "SELECT COUNT(*) AS num_artists FROM Artist;";
    $result = mysqli_query($db, $query);
    $result_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $num_artists = $result_array['num_artists'];

    $query = "SELECT COUNT(*) AS num_tracks FROM Track;";
    $result = mysqli_query($db, $query);
    $result_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $num_tracks = $result_array['num_tracks'];

	$query = "SELECT COUNT(*) AS num_publishers FROM Publisher;";
    $result = mysqli_query($db, $query);
    $result_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $num_publishers = $result_array['num_publishers'];

	$query = "SELECT user_id, MAX(num) AS num_listens FROM ((SELECT user_id, COUNT(*) AS num FROM Listens GROUP BY user_id) AS temp);";
    $result = mysqli_query($db, $query);
    $result_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $max_listener_id = $result_array['user_id'];
    $max_listener_num_listens = $result_array['num_listens'];

    $query = "SELECT * FROM Person WHERE person_id = {$max_listener_id};";
    $result = mysqli_query($db, $query);
    $result_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $max_listener_username = $result_array['username'];
    $max_listener_fullname = $result_array['fullname'];

	$query = "SELECT user_id, MAX(num) AS num_listens FROM ((SELECT user_id, COUNT(*) AS num FROM Buys GROUP BY user_id) AS temp);";
    $result = mysqli_query($db, $query);
    $result_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $max_buyer_id = $result_array['user_id'];
    $max_buyer_num_buys = $result_array['num_listens'];

    $query = "SELECT * FROM Person WHERE person_id = {$max_buyer_id};";
    $result = mysqli_query($db, $query);
    $result_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $max_buyer_username = $result_array['username'];
    $max_buyer_fullname = $result_array['fullname'];

    $query = "SELECT giver_id AS user_id, MAX(num) AS num_listens FROM ((SELECT giver_id, COUNT(*) AS num FROM Gift GROUP BY giver_id) AS temp);";
    $result = mysqli_query($db, $query);
    $result_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $max_gifter_id = $result_array['user_id'];
    $max_gifter_num_gifts = $result_array['num_listens'];

    $query = "SELECT * FROM Person WHERE person_id = {$max_gifter_id};";
    $result = mysqli_query($db, $query);
    $result_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $max_gifter_username = $result_array['username'];
    $max_gifter_fullname = $result_array['fullname'];

    $query = "SELECT user_id, MIN(budget) AS budget FROM USER GROUP BY user_id;";
    $result = mysqli_query($db, $query);
    $result_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $richest_id = $result_array['user_id'];
    $richest_budget = $result_array['budget'];

    $query = "SELECT * FROM Person WHERE person_id = {$richest_id};";
    $result = mysqli_query($db, $query);
    $result_array = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $richest_username = $result_array['username'];
    $richest_fullname = $result_array['fullname'];

?>

<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>Musicholics - Admin</title>
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
					<li><a href="change_password_admin.php"><span class="glyphicon glyphicon-user"></span> Change Password</a></li>
					<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
				</ul>
			</div>
		</nav>

	<div class = "container" align = "center">
		<h1>
			Welcome back Admin!
		</h1>
		<h3>
			Currently, there are <?php echo $num_users ?> users, <?php echo $num_artists ?> artists, <?php echo $num_albums ?> albums, <?php echo $num_tracks ?> tracks and <?php echo $num_publishers ?> publishers in the system.
		</h3>
	</div>

	<div class = "container" align = "center">
		<h2>Most Active User</h2></div>
		<div class="container" align = "center">
		 <table class = "table table-hover" style="width:100%">
			  <tr>
			    <th>User Name</th>
			    <th>Full Name</th> 
			    <th>Number of Listens</th>
			  </tr>
			  <?php
			    echo "<tr onclick = \"document.location = 'complete_profile.php?other_id={$max_listener_id}' \">";
			    echo "<td>" . $max_listener_username . "</td>";
			    echo "<td>" . $max_listener_fullname . "</td>";
			    echo "<td>" . $max_listener_num_listens . "</td>";
			    echo "</tr>";
			  ?>
		</table>
		</div>
	</div>
	<div class = "container" align = "center">
		<h2>Most Shopaholic User</h2></div>
		<div class="container" align = "center">
		 <table class = "table table-hover" style="width:100%">
			  <tr>
			    <th>User Name</th>
			    <th>Full Name</th> 
			    <th>Number of Songs Purchased</th>
			  </tr>
			  <?php
			    echo "<tr onclick = \"document.location = 'complete_profile.php?other_id={$max_buyer_id}' \">";
			    echo "<td>" . $max_buyer_username . "</td>";
			    echo "<td>" . $max_buyer_fullname . "</td>";
			    echo "<td>" . $max_buyer_num_buys . "</td>";
			    echo "</tr>";
			  ?>
		</table>
		</div>
	</div>
	<div class = "container" align = "center">
		<h2>Most Generous User</h2></div>
		<div class="container" align = "center">
		 <table class = "table table-hover" style="width:100%">
			  <tr>
			    <th>User Name</th>
			    <th>Full Name</th> 
			    <th>Number of Songs Gifted</th>
			  </tr>
			  <?php
			    echo "<tr onclick = \"document.location = 'complete_profile.php?other_id={$max_gifter_id}' \">";
			    echo "<td>" . $max_gifter_username . "</td>";
			    echo "<td>" . $max_gifter_fullname . "</td>";
			    echo "<td>" . $max_gifter_num_gifts . "</td>";
			    echo "</tr>";
			  ?>
		</table>
		</div>
	</div>
	<div class = "container" align = "center">
		<h2>Richest User</h2></div>
		<div class="container" align = "center">
		 <table class = "table table-hover" style="width:100%">
			  <tr>
			    <th>User Name</th>
			    <th>Full Name</th> 
			    <th>Budget</th>
			  </tr>
			  <?php
			    echo "<tr onclick = \"document.location = 'complete_profile.php?other_id={$richest_id}' \">";
			    echo "<td>" . $richest_username . "</td>";
			    echo "<td>" . $richest_fullname . "</td>";
			    echo "<td>" . $richest_budget . "</td>";
			    echo "</tr>";
			  ?>
		</table>
		</div>
	</div>
	</body>
</html>
