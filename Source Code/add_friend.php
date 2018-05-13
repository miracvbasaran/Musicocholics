<?php 
	include("session.php");
	//include("connection.php");

		
	$id = $_SESSION['login_id'];
	$add_id = $_GET['other_id'];
	
	$rquery = mysqli_query( $db, "INSERT INTO friendship VALUES ({$id}, {$add_id})" ); 
									
	if( $rquery) //successful
		header("Location: friend_profile.php?other_id=$add_id");
	else
		echo( "Error while adding friend.");
		
?>
		
