<?php 
	include("session.php");
	include("connection.php");
?>

<html>
	<body>
		<?php
		
		$id = $_SESSION['login_id'];
		$remove_id = $_SESSION['remove_friend_id'];
		
		$rquery = mysqli_query( $db, "DELETE * FROM Friendship 
									  WHERE (user1_id = '$id' AND user2_id = '$fid') 
										 OR (user1_id = '$fid' AND user2_id = '$id')");
		if( $rquery) //successful
			header( "Location: friends.php");
		else
			echo( "Error while deleting friend.");
		
		?>
		
	</body>
</html>
