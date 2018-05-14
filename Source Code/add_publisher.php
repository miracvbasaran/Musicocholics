
<?php
	include("session.php");
	$uid = mysqli_real_escape_string($db,$_SESSION['login_id']);


	$publisher_name = "John Doe" . rand(0,1000);
	$query = "INSERT INTO Publisher(publisher_name) VALUES('$publisher_name');";
    $result = mysqli_query($db, $query);
    $query = "SELECT LAST_INSERT_ID();";
    $result = mysqli_query($db, $query);
    $index_array = mysqli_fetch_array($result, MYSQLI_NUM);
    $publisher_id = $index_array[0];

	header("location: modify_publisher.php?publisher_id=".$publisher_id);
?> 
