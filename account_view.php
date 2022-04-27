<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/general.css">
    <title>Login</title>
    <script src="login.js"></script>
</head>
<body>


<?php     
       require_once './PHP_HELPERS/connection_string.php';
       $userid = $_GET['account'];
       if($_GET['account'] != $_SESSION['loggedin'] &&  $_SESSION['usertype'] != 'receptionist'){
           echo ("You are not allowed to view this content");
       }else{
            $req = "SELECT user_id, first_name, last_name, full_name, username, user_type, dob, age  FROM usr_user WHERE user_id='$userid'";
            $res = pg_query($conn, $req); 
            $array_result = pg_fetch_all($res);

            if(count($array_result) < 1){
                echo '<p class="errormsg">Account not found. Please go back and try again.</p>';
            }else{
 
                $today = date("Y-m-d");
                $age = date_diff(date_create($array_result[0]["dob"]), date_create($today));
                $age=  $age->format('%y');
                echo ('

                <h1>Personal information here</h1>
                <h3>If necessary, you can change value of fields and click Save to update your account\'s information.</h3>
                <div class="container">  
                <hr>

                <label> Username: </label>   
                <input type="text" name="firstname"  disabled="disabled" value="'. $array_result[0]["username"] .'" placeholder= "Firstname" size="20" required /> 
                <label> Account Type: </label>    
                <input type="text" disabled="disabled" value="'. $array_result[0]["user_type"] .'"/>  
                
                <div>  
               
                <label> Full Name: </label>    
                <input type="text" disabled="disabled" value="'. $array_result[0]["full_name"] .'"/>  
                <label> Firstname: </label>   
                <input type="text" name="firstname"  value="'. $array_result[0]["first_name"] .'"size="20" required /> 
                <label> Lastname: </label>    
                <input type="text" name="lastname" value="'. $array_result[0]["last_name"] .'" size="20"required />   
                <div>  
                <label>
            
            
                <div>  
                <label>
                <label for="birthday">Date of birth:</label>
                <input type="date" id="birthday" name="birthday" value="'. $array_result[0]["dob"] .'">
                <label for="birthday">Age:</label>
                <input type="text" id="birthday"  disabled="disabled" name="birthday" value="'. $array_result[0]["age"] .'">
                <div>          
               ');

              if ($array_result[0]['user_type']=="employee"){ 
                   
                } else  if ($array_result[0]['user_type']=="patient"){
                    $req = "SELECT A.ssn, A.address, A.phone, A.email, A.insurance_type, A.gender, A.is_currently_employee, A.employee_id, B.username 
                            FROM usr_user C 
                            LEFT JOIN usr_patient A
                            ON A.user_id = C.user_id 
                            LEFT JOIN usr_user B ON 
                            A.employee_id = B.user_id 
                            WHERE C.user_id='$userid'";
                    $res = pg_query($conn, $req); 
                    $array_result1 = pg_fetch_all($res);
                    print_r($array_result1);
                }
             //  <div class="container">
            //    <label>  Adresse : </label>   
            //     <input type="text" name="address" value="'. $array_result[0]["address"] .'" size="50" required /> 
              
            //     <label>
            
            //         <label> Social security number: </label>   
            //         <input type="text" name="SSN" placeholder= "SSN" size="15" required />    
            //         <div>  
            //         <label> 
             
            //         <label> Email: </label>   
            //         <input type="text" name="email" placeholder= "email" size="15" required />    
            //         <div>  
            //         <label>   
            //     Insurance type :  
            //     </label>   
            //     <select>  
            //     <option value="Individual">Individual</option>  
            //     <option value="Family">Family</option>  
            //     <option value="Senior">Senior</option>  
            //     <option value="Student">Student</option>  
            //     <option value="Government">Government</option>   
            //     </select>  
            //     </div>  
            //     <div>  
            //     <label>  
            //     <br>   
            //     Gender :  
            //     </label>  
            //     <br>  
            //     <input type="radio" value="Male" name="gender" checked > Male   
            //     <input type="radio" value="Female" name="gender"> Female  
            //     <input type="radio" value="Non-Binary" name="gender">Non-Binary  
            //     </div>  
                print_r($array_result);
                // if ($array_result[0]['user_type']=="patient"){ 
                //     $_SESSION["usertype"] = "patient";        
                //     header("location: ../index_patient.php");
                // } else  if ($array_result[0]['user_type']!="casual"{
                //     $req = "SELECT address, phone, email, insurance_type  FROM usr_user A LEFT JOIN usr_employee B ON A.user_id = B.user_id WHERE username='$username' AND password='$password'";
                //     $res = pg_query($conn, $req); 
                //     $array_result1 = pg_fetch_all($res);
                //     $_SESSION["usertype"] =  $array_result1[0]['job_type'];
                //     if ($array_result1[0]['job_type']=="receptionist"){
                //         header("location: ../index_receptionniste.php");          
                //     } else {     
                //         header("location: ../index_dentist.php");
                //     }
                // }

                echo '<br><button type="submit">Save Account Information</Button>';  
            }
        
        
        

    
        }
        
    ?>

    
   
</body>
</html>