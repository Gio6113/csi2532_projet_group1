<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/general.css">
    <title>Login</title>
  
</head>

<body>

    <?php
   
     require_once 'connection_string.php';

    if(isset($_POST)){
        
        $_redirect = null;
        $user_id = $_POST["user_id"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $fullname = $firstname . " ". $lastname;
        $dob =  $_POST["birthday"];
        $today = date("Y-m-d");
        $age = date_diff(date_create($dob), date_create($today));
        $age =  $age->format('%y');
      
        $queryres1 = true;
        $queryres2 = true;

        $req = "UPDATE usr_user
                SET first_name = '$firstname', 
                    last_name = '$lastname',
                    full_name = '$fullname',
                    dob = '$dob',
                    age = '$age'    
                WHERE user_id = '$user_id'";
        $queryres1 = pg_query($conn, $req); 
        
        if($_POST["user_type"]=="employee"){

            $address = $_POST["address"];
            $gender = $_POST["gender"];
            $workclinic = $_POST["clinic_id"]; 
            $salary = $_POST["salary"]; 
            $req2 = "UPDATE usr_employee
            SET address = '$address', 
                gender = '$gender',
                work_clinic = '$workclinic',
                salary = '$salary'          
            WHERE user_id = '$user_id'";    
            $queryres2 = pg_query($conn, $req2); 
        }
        else if($_POST["user_type"]=="patient"){
            $address = $_POST["address"];
            $gender = $_POST["gender"];
            $insurancetype = $_POST["insurance"]; 
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $isemployee = "t";
            $employee_id = $_POST["emp_id"];


            if($employee_id == null){
                
                $req3 = "UPDATE usr_patient
                        SET employee_id = null  
                        WHERE user_id = '$user_id'";    
                $queryres3 = pg_query($conn, $req3); 
                $isemployee = "f";
               
            } else{
                $req = "SELECT employee_id FROM usr_employee WHERE employee_id='$employee_id'";
                $queryres3 = pg_query($conn, $req); 
                $result = pg_fetch_all($queryres3);
            
                if( count($result)<1 || !$queryres3){
                    $_redirect = "location: ../account_view.php?account=" .($_POST["user_id"])."&error=222";
                    header( $_redirect);
                }
                else{
                $req3 = "UPDATE usr_patient
                SET employee_id = $employee_id  
                WHERE user_id = '$user_id'";    
                $queryres3 = pg_query($conn, $req3);        
                }
            }

        
            $responsible_id = $_POST["responsible_id"];

            if ($responsible_id == null && $age<15){               
                $_redirect = "location: ../account_view.php?account=" .($_POST["user_id"])."&error=111";
                header( $_redirect);
            } 
            else if($responsible_id == null){
                
                $req3 = "UPDATE usr_patient
                        SET responsible_id = null  
                        WHERE user_id = '$user_id'";    
                $queryres3 = pg_query($conn, $req3); 
             
               
            } else{
                $req = "SELECT user_id,  user_type  FROM usr_user WHERE user_id='$responsible_id'";
                $queryres3 = pg_query($conn, $req); 
                $result = pg_fetch_all($queryres3);
            
                if(($queryres3 && $result[0]["user_type"]=="patient") || !$queryres3){
                    $_redirect = "location: ../account_view.php?account=" .($_POST["user_id"])."&error=333";
                    header( $_redirect);
                }
                else{
                $req3 = "UPDATE usr_patient
                SET responsible_id = $responsible_id  
                WHERE user_id = '$user_id'";    
                $queryres3 = pg_query($conn, $req3); 
               
                }
            }
  
            $req2 = "UPDATE usr_patient
            SET address = '$address', 
                gender = '$gender',
                insurance_type = '$insurancetype',
                email = '$email', 
                phone = '$phone', 
                is_currently_employee = '$isemployee'   
            WHERE user_id = '$user_id'";    
            $queryres2 = pg_query($conn, $req2); 
            
        }
        
        if($_redirect != null){
            header( $_redirect);
        }
        else if($queryres1 && $queryres2){
            $_redirect = "location: ../account_view.php?account=" .($_POST["user_id"])."&success=999";
             header( $_redirect);
        }else{
            $_redirect = "location: ../account_view.php?account=" .($_POST["user_id"])."&error=999";
            header( $_redirect);
        }
    }else{
        echo('<p class="errormsg">Something went wrong</p>');
    }
    ?>



</body>

</html>