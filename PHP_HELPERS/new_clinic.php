<?php
   

    require_once 'connection_string.php';

    print_r($_POST);
    if(!isset( $_POST)){
        echo "Failed insert";
    }
    else{
        $clinic_id = (int) $_POST["clinic_id"];
        $clinic_name = "'" .$_POST["clinic_name"] .  "'";
        $address = "'" . $_POST["address"].  "'";
        $city = "'" . $_POST["city"]. "'";
        $director = (int) $_POST["director_id"];
        if($director==""){
            $director = NULL;

        }
       

        $req = "INSERT INTO usr_clinic (clinic_id, clinic_name, address, city, director)
                VALUES (".$clinic_id.", ".$clinic_name.", ".$address. ",".$city.",".$director.")";
        $res = pg_query($conn, $req); 
        if( $res){
            header("location: ../clinics.php");
         
        }else{
                echo "error with adding new clinic";
        }
    }
?>