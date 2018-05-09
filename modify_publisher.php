<?php
	include("session.php");
    $uid = mysqli_real_escape_string($db,$_GET['login_id']);

    $publisher_id = $_GET['publisher_id'];
    $query2 = "SELECT * FROM Publisher WHERE publisher_id = {$publisher_id} ";
    $result2 = mysqli_query($db, $query2);
    $publisher_array = mysqli_fetch_array($result2,MYSQLI_ASSOC);
    $publisher_name = $publisher_array('publisher_name');
    $country = $publisher_array('country');
    $city = $publisher_array('city');
    

    if(isset($_POST['apply']))
    {
      if(isset( ($_POST['country']) )  ){
        $country = $_POST['country'];
          $query = "UPDATE Publisher SET country = {$country} WHERE publisher_id = {$publisher_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['city']) )  ){
          $country = $_POST['city'];
          $query = "UPDATE Publisher SET city = {$city} WHERE publisher_id = {$publisher_id} ";
          $result = mysqli_query($db, $query);
      }
      if(isset( ($_POST['publisher_name']) )  ){
          $publisher_name = $_POST['publisher_name']
          $query = "UPDATE Publisher SET publisher_name = {$publisher_name} WHERE publisher_id = {$publisher_id} ";
          $result = mysqli_query($db, $query);
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Musicholics - Modify Publisher</title>
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
     
	   <li><a href="search_result_screen.php">Search</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span>Logout</a></li>
    </ul>
  </div>
</nav>

   <div align="left" class="col-md-6 col-md-offset-3"><img class="img-circle img-responsive" src="assets/img/ <?php echo $picture_v; ?>" width="200" height="200"></div>

<div class="container">
  <h3>Publisher <?php echo $publisher_name;?></h3> 


<form method="post" action="">
  Name: <input type="text" name="name" value= <?php echo $publisher_name ?> autofocus>
  <br>
  Country: <select name="country">
    <option value="Turkey">Turkey</option>
    <option value="USA">USA</option>
    <option value="England">England</option>
    <option value="Germany">Germany</option>
  </select> <br>
  City:  <input type="text" name="city" value= <?php echo $city ?> autofocus>
  

  <input type="submit" name="apply" value="APPLY"  > 

</form> 

 </div>

</body>
</html>