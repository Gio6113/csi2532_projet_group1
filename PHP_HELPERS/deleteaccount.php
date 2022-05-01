<?php
    echo 'yo';

    require_once 'connection_string.php';

    if(!isset( $_GET["delete"])){
        echo "cannot delete this account";
    }else
        $account = $_GET["delete"];
    

        $req = "DELETE FROM usr_user
               WHERE user_id='$account'";
        $res = pg_query($conn, $req); 
        $array_result = pg_fetch_all($res);

        echo 'repeat';
        if(count($array_result) > 10){
            header("location: ../index.php?error=invalidCredentials");
            exit();   
    }
?>