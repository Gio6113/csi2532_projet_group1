<?php
   

    require_once 'connection_string.php';

    if(!isset( $_GET["delete"])){
        echo "cannot delete this account";
    }else
        $account = $_GET["delete"];
    

        $req = "DELETE FROM usr_user
               WHERE user_id='$account'";
        $res = pg_query($conn, $req); 
        $array_result = pg_fetch_all($res);

        if( $res){
            header("location: ../receptionist_search_user.php");
         
    }
?>