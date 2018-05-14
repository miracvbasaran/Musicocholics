
<?php
	include("session.php");
	$uid = mysqli_real_escape_string($db,$_SESSION['login_id']);


	header("location: advanced_artist_search_admin.php");
?> 
