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
    if(!isset($_GET['account'])){
        echo '<p class="errormsg">Account not specified.</p>';
    }else{
    $userid = $_GET['account'];
        
         if ($_GET['account'] != $_SESSION['loggedin'] &&  $_SESSION['usertype'] != 'receptionist') {
            echo ("You are not allowed to view this content");
        } else {
            $req = "SELECT user_id, first_name, last_name, full_name, username, user_type, dob, age  FROM usr_user WHERE user_id='$userid'";
            $res = pg_query($conn, $req);
            $array_result = pg_fetch_all($res);

            if (count($array_result) < 1) {
                echo '<p class="errormsg">Account not found. Please go back and try again.</p>';
            } else {

                echo (' <h1>Personal information here</h1>');
                
                if($array_result[0]['user_type'] == "casual"){
                echo ('
                    <form  action="./PHP_HELPERS/save_account_changes.php" method="post">
                    <h3>If necessary, you can change value of fields and click Save to update your account\'s information.</h3>
                    <div class="container">  
                    <hr>

                    <label> Username: </label>   
                    <input type="text" name="username"  readonly value="' . $array_result[0]["username"] . '" placeholder= "Firstname" size="20" required /> 
                    <label> Account Type: </label>    
                    <input type="text" readonly value="' . $array_result[0]["user_type"] . '"/>  
                    
                    <div>  
                
                    <label> Full Name: </label>    
                    <input type="text" readonly value="' . $array_result[0]["full_name"] . '"/>  
                    <label> Firstname: </label>   
                    <input type="text" name="firstname"  value="' . $array_result[0]["first_name"] . '"size="20" required /> 
                    <label> Lastname: </label>    
                    <input type="text" name="lastname" value="' . $array_result[0]["last_name"] . '" size="20" required />   
                    <div>  
                    <label>
                
                
                    <div>  
                    <label>
                    <label for="birthday">Date of birth:</label>
                    <input type="date" id="birthday" name="birthday" value="' . $array_result[0]["dob"] . '">
                    <label for="birthday">Age:</label>
                    <input type="text" id="birthday" size="5" readonly name="birthday" value="' . $array_result[0]["age"] . '">
                    <br>
                    <br>
                    <button type="submit">Save Account Information</button>
                    </form>    
                ');

                }else if ($array_result[0]['user_type'] == "employee") {
                    $req = "SELECT B.clinic_name as clinic_name, A.ssn, A.address, A.gender, A.work_clinic, A.salary, A.gender, A.job_type, A.employee_id, C.username 
                                FROM usr_user C 
                                LEFT JOIN usr_employee A
                                ON A.user_id = C.user_id 
                                LEFT JOIN usr_clinic B ON 
                                A.work_clinic = B.clinic_id       
                                WHERE C.user_id='$userid'";
                    $res = pg_query($conn, $req);
                    $array_result1 = pg_fetch_all($res);
          

                    echo ('
                            <form  action="./PHP_HELPERS/save_account_changes.php" method="post">
                            <h3>If necessary, you can change value of fields and click Save to update your account\'s information.</h3>
                            <div class="container">  
                            <hr>

                            <label> Username: </label>   
                            <input type="text" name="firstname"  readonly value="' . $array_result[0]["username"] . '" placeholder= "Firstname" size="20" required /> 
                            <label> Account Type: </label>    
                            <input type="text" readonly value="' . $array_result[0]["user_type"] . '"/>  
                            
                            <div>  
                        
                            <label> Full Name: </label>    
                            <input type="text" readonly value="' . $array_result[0]["full_name"] . '"/>  
                            <label> Firstname: </label>   
                            <input type="text" name="firstname"  value="' . $array_result[0]["first_name"] . '"size="20" required /> 
                            <label> Lastname: </label>    
                            <input type="text" name="lastname" value="' . $array_result[0]["last_name"] . '" size="20" required />   
                            <div>  
                            <label>
                        
                        
                            <div>  
                            <label>
                            <label for="birthday">Date of birth:</label>
                            <input type="date" id="birthday" name="birthday" value="' . $array_result[0]["dob"] . '">
                            <label for="birthday">Age:</label>
                            <input type="text" id="birthday" size="5" readonly name="birthday" value="' . $array_result[0]["age"] . '">
                        <div class="container">
                        <hr>
                            <label>  Adresse : </label>   
                            <input type="text" name="address" value="' . $array_result1[0]["address"] . '" size="40" required /> 
                        
                            <label>
                    
                            <label> Social security number: </label>   
                            <input type="text" name="SSN" readonly value="' . $array_result1[0]["ssn"] . '" size="11" required />    
                            <div>  
                            <label> 

                            <label> Job Title </label>   
                            <input type="text" name="SSN" readonly value="' . $array_result1[0]["job_type"] . '" size="16" required />    
                            <div>  
                            <label> 
                                        
                            ');

                    $genders = array('Male', 'Female', 'Non-Binary');
                    $output = '';
                    for ($i = 0; $i < count($genders); $i++) {
                        $output .= '<option '
                            . ($array_result1[0]["gender"] == $genders[$i] ? 'selected="selected"' : '') . '>'
                            . $genders[$i]
                            . '</option>';
                    }

                    echo ('
                            <label>
                            Gender :  
                            </label>   
                            <select name="gender">
                            ' . $output . '  
                        </select> 
                        <br>
                        <br>
                        <hr>
                        
                    ');

                    if ($_SESSION['usertype'] == 'receptionist') {
                        echo ('
                        <div class="container">
                        
                            <label> Work clinic: </label>   
                            <input type="text" readonly name="work_clinic" value="' . $array_result1[0]["clinic_name"] . '" size="50" required />    
                            <div>  
                            <label> 
                            <label> Salary: </label>   
                            <input type="text" name="salary"   value="' . $array_result1[0]["salary"] . '" size="50" required />    
                            <div>  
                            <label>                    
                            <br>
                            <br>
                            <button type="submit">Save Account Information</button>
                            </form>
                            ');
                    } else {
                        echo ('
                    
                        <h5>These informations can only be changed by a receptionnist. Contact your clinic if changes are required.</h5>
                        <div class="container">
                        
                            
                        <label> Work clinic: </label>   
                        <input type="text" name="responsible" readonly value="' . $array_result1[0]["clinic_name"] . '" size="50" required />    
                        <div>  
                        <label> 
                        <label> Salary: </label>   
                        <input type="text" name="insurance"  readonly value="' . $array_result1[0]["salary"] . '" size="50" required />    
                        <div>  
                        <label>                    
                        <br>
                        <br>
                        <button type="submit">Save Account Information</button>
                        </form>
                            ');
                    }
                } else  if ($array_result[0]['user_type'] == "patient") {
                    $req = "SELECT D.full_name as responsible_name, A.ssn, A.address, A.phone, A.email, A.insurance_type, A.gender, A.is_currently_employee, A.employee_id, B.username 
                                FROM usr_user C 
                                LEFT JOIN usr_patient A
                                ON A.user_id = C.user_id 
                                LEFT JOIN usr_user B ON 
                                A.employee_id = B.user_id 
                                LEFT JOIN usr_user D ON 
                                A.responsible_id = D.user_id 
                                WHERE C.user_id='$userid'";
                    $res = pg_query($conn, $req);
                    $array_result1 = pg_fetch_all($res);
                

                    echo ('
                            <form  action="./PHP_HELPERS/save_account_changes.php" method="post">
                            <h3>If necessary, you can change value of fields and click Save to update your account\'s information.</h3>
                            <div class="container">  
                            <hr>

                            <label> Username: </label>   
                            <input type="text" name="username"  readonly value="' . $array_result[0]["username"] . '" placeholder= "Firstname" size="20" required /> 
                            <label> Account Type: </label>    
                            <input type="text" readonly value="' . $array_result[0]["user_type"] . '"/>  
                            
                            <div>  
                        
                            <label> Full Name: </label>    
                            <input type="text" readonly value="' . $array_result[0]["full_name"] . '"/>  
                            <label> Firstname: </label>   
                            <input type="text" name="firstname"  value="' . $array_result[0]["first_name"] . '"size="20" required /> 
                            <label> Lastname: </label>    
                            <input type="text" name="lastname" value="' . $array_result[0]["last_name"] . '" size="20" required />   
                            <div>  
                            <label>
                        
                        
                            <div>  
                            <label>
                            <label for="birthday">Date of birth:</label>
                            <input type="date" id="birthday" name="birthday" value="' . $array_result[0]["dob"] . '">
                            <label for="birthday">Age:</label>
                            <input type="text" id="birthday" size="5" readonly name="birthday" value="' . $array_result[0]["age"] . '">
                        <div class="container">
                        <hr>
                            <label>  Adresse : </label>   
                            <input type="text" name="address" value="' . $array_result1[0]["address"] . '" size="40" required /> 
                        
                            <label>
                    
                            <label> Social security number: </label>   
                            <input type="text" name="SSN" readonly value="' . $array_result1[0]["ssn"] . '" size="11" required />    
                            <div>  
                            <label> 
                    
                            <label> Email: </label>   
                            <input type="text" name="email" value="' . $array_result1[0]["email"] . '"size="40" required />  
                            <label> Phone: </label>   
                            <input type="text" name="phone" value="' . $array_result1[0]["phone"] . '"size="15" required />    
                            <div>  
                            <label>                         
                            ');

                    $genders = array('Male', 'Female', 'Non-Binary');
                    $output = '';
                    for ($i = 0; $i < count($genders); $i++) {
                        $output .= '<option '
                            . ($array_result1[0]["gender"] == $genders[$i] ? 'selected="selected"' : '') . '>'
                            . $genders[$i]
                            . '</option>';
                    }

                    echo ('
                        <label>
                        Gender :  
                        </label>   
                        <select name="gender">
                        ' . $output . '  
                        </select> 
                        <br>
                        <br>
                        <hr>
                        
                    ');

                    $employed = "yes";
                    if ($array_result1[0]["is_currently_employee"]=="f"){
                        $employed = "no";
                    }

                    if ($_SESSION['usertype'] == 'receptionist') {
                        echo ('
                        <div class="container">
                        
                            <label> Person Responsible: </label>   
                            <input type="text" name="responsible" value="' . $array_result1[0]["responsible_name"] . '" size="50" required />    
                            <div>  
                            <label> 
                            <label> Insurance type: </label>   
                            <input type="text" name="insurance" value="' . $array_result1[0]["insurance_type"] . '" size="50" required />    
                            <div>  
                            <label> 
                    
                            <label> User currently also an employee: </label>   
                            <input type="text" name="employed" readonly value="' . $employed . '"size="3" required />  
                            <label> Employee account username: </label>   
                            <input type="text" name="emp_account" value="' . $array_result1[0]["username"] . '"size="15"  />    
                            <div>  
                            <label> 
                            <br>
                            <br>
                            <button type="submit">Save Account Information</button>
                            </form>
                            ');
                    } else {
                        echo ('
                    
                        <h5>These informations can only be changed by a receptionnist. Contact your clinic if changes are required.</h5>
                        <div class="container">
                        
                            <label> Person Responsible: </label>   
                            <input type="text" readonly name="responsible" value="' . $array_result1[0]["responsible_name"] . '" size="50" required />    
                            <div>  
                            <label> 
                            <label> Insurance type: </label>   
                            <input type="text" readonly name="insurance" value="' . $array_result1[0]["insurance_type"] . '" size="50" required />    
                            <div>  
                            <label> 
                    
                            <label> User currently also an employee: </label>   
                            <input type="text" name="employed" readonly value="' . $employed . '"size="3" required />  
                            <label> Employee account username: </label>   
                            <input type="text" name="emp_account" readonly value="' . $array_result1[0]["username"] . '"size="15"  />    
                            <div>  
                            <label> 
                            <br>
                            <br>
                            <button type="submit">Save Account Information</button>
                            </form>
                            ');
                    }
                }
            }
        }
    }

    ?>



</body>

</html>