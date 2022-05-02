<?php
   

    require_once 'connection_string.php';

    print_r($_POST);
    if(!isset( $_POST)){
        echo "Failed insert";
    }
    else{
        $fee_id = (int) $_POST["fee_id"];
        $clinic_name = "'" .$_POST["procedure_description"] .  "'";
        $fees = (float)  $_POST["fees"];
        $procedure_code = (int) $_POST["procedure_code"];
      
       

        $req = "INSERT INTO pay_procedure_fee
                (fee_id, procedure_description, fees, procedure_code)
                VALUES (".$fee_id.", ".$clinic_name.", ".$fees. ",".$procedure_code.")";
        $res = pg_query($conn, $req); 
        if( $res){
            header("location: ../procedures.php");
         
        }else{
                echo "error with adding new procedure";
        }
    }
?>