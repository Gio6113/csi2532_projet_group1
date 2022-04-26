<?php
    require_once 'connection_string.php';

    $username = $_POST["username"];
    $password = $_POST["password"];

    $req = "SELECT user_id, first_name, last_name, full_name, username, user_type  FROM usr_user WHERE username='$username' AND password='$password'";
    $res = pg_query($conn, $req); 
    $array_result = pg_fetch_all($res);

    if(count($array_result) < 1){
        header("location: ../index.php?error=invalidCredentials");
        exit();   
    }else{
        $_SESSION["loggedin"] = $array_result[0]['user_id'];
        $_SESSION["fullname"] = $array_result[0]['full_name'];
  
        if ($array_result[0]['user_type']=="casual"){
            $_SESSION["usertype"] = "casual";
            header("location: ../index_casual.php");       
        }else if ($array_result[0]['user_type']=="patient"){ 
            $_SESSION["usertype"] = "patient";        
            header("location: ../index_patient.php");
        } else {
            $req = "SELECT job_type  FROM usr_user A LEFT JOIN usr_employee B ON A.user_id = B.user_id WHERE username='$username' AND password='$password'";
            $res = pg_query($conn, $req); 
            $array_result1 = pg_fetch_all($res);
            $_SESSION["usertype"] =  $array_result1[0]['job_type'];
            if ($array_result1[0]['job_type']=="receptionist"){
                header("location: ../index_receptionniste.php");          
            } else {     
                header("location: ../index_dentist.php");
            }
        }
    }
?>