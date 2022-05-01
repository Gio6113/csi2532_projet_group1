<?php
    if ($_GET["acctype"]=="casual"){      
        header("location: ../index_casual.php");       
    }else if ($_GET["acctype"]=="patient"){     
        header("location: ../index_patient.php");
    } else if ($_GET["acctype"]=="receptionist"){          
            header("location: ../index_receptionniste.php");          
    } else {     
            header("location: ../index_dentist.php");           
    }
?>