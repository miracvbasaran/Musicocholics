<?php
    include("connection.php");
    session_start();

    $user_check = $_SESSION['login_user'];
    
   $ses_sql = mysqli_query($db, "SELECT * FROM person WHERE username = '{$user_check}'");
   
   $row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
   
   $login_session = $row['username'];
   $login_id = $row['person_id'];
   $fullname = $row['fullname'];
   $email = $row['email'];
   $password = $row['password'];
   $_SESSION["login_id"] = $login_id;
   
   if(!isset($_SESSION['login_user'])){
      header("location: login.php");
   }
?>