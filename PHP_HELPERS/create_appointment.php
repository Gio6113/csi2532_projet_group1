<?php
    require_once 'connection_string.php';

    echo "we are trying to create an appointment<br>";
    
    print_r($_POST);

    $firstname = $_POST["firstname"];
    $lastname =  $_POST["lastname"];
    $roomnumber =  $_POST["xxx"];



    $req = "INSERT  user_id, first_name, last_name, full_name, username, user_type  FROM usr_user WHERE username='$username' AND password='$password'";
    $res = pg_query($conn, $req); 

   
?>