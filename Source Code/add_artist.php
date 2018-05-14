
<?php
	include("session.php");
	$uid = mysqli_real_escape_string($db,$_SESSION['login_id']);


	$artist_name = "John Doe";
	$query = "INSERT INTO Artist(artist_name) VALUES('$artist_name');";
    $result = mysqli_query($db, $query);
    $query = "SELECT LAST_INSERT_ID();";
    $result = mysqli_query($db, $query);
    $index_array = mysqli_fetch_array($result, MYSQLI_NUM);
    $artist_id = $index_array[0];

	header("location: modify_artist.php?artist_id=".$artist_id);
?> 
