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
    include_once 'header.php';


    echo ' <form action="./PHP_HELPERS/new_clinic.php" method="post">
        <h3> Here is a list of all clinics:</h3>
        <p>Add a new clinic here</p>
    ';
    
    $req = "SELECT  clinic_id, clinic_name, A.address, city, director, C.full_name as director_name
    FROM usr_clinic A 
    LEFT JOIN usr_employee B 
    ON A.director = B.employee_id 
    LEFT JOIN usr_user C 
    ON B.user_id = C.user_id
    ORDER BY clinic_id"; 
     $res = pg_query($conn, $req); 
    $array_result1 = pg_fetch_all($res);


    
        echo '<table>
            <tr>
                <th class="thsmall">Clinic ID</th>
                <th>Clinic Name</th>
                <th>Address</th>
                <th class="thsmall">City</th> 
                <th>Director_name</th>          
            </tr>';

        foreach ($array_result1 as $row){
            echo '<tr>
                <td>'.$row["clinic_id"]. '</td>
                <td>' .$row["clinic_name"]. '</td>
                <td>' .$row["address"]. '</td>   
                <td>' .$row["city"]. '</td>
                <td>' .$row["director_name"]. '</td>  
                </tr>';
         

        }

    echo  '<tr>
    <td><input type="text" name="clinic_id"  value="" placeholder= "clinic id" size="20" required /> </td>
    <td><input type="text" name="clinic_name"  value="" placeholder= "clinic name" size="20" required /> </td>
    <td><input type="text" name="address"  value="" placeholder= "address" size="30" required /> </td>   
    <td><input type="text" name="city"  value="" placeholder= "city" size="20" required /> </td>
    <td><input type="text" name="director_id"  value="" placeholder= "director id" size="20"  /> </td>  
    </tr>  
     </table> </div>
     <button type="submit" id="loginButton">Add Clinic</button>
     </form>';

    


 

    foreach ($array_result1 as $row){
        echo '<h4>'.$row["clinic_name"].'</h4>';
        echo '<table>
        <tr>
            <th class="thsmall">Employee ID</th>
            <th>Staff Name</th>
            <th>Job title</th>        
        </tr>';

            $req2 = "SELECT  clinic_id, clinic_name, A.address, city, B.employee_id, director, B.job_type, C.full_name as full_name
            FROM usr_employee B  
            LEFT JOIN usr_clinic A
            ON A.clinic_id = B.work_clinic
            LEFT JOIN usr_user C
            ON B.user_id = C.user_id
            WHERE B.work_clinic = ".$row["clinic_id"]. " 
            ORDER BY clinic_id"; 
            $res = pg_query($conn, $req2); 
            $array_result2 = pg_fetch_all($res);
          
            foreach ($array_result2 as $row1){
                echo '<tr>
                    <td>'.$row1["employee_id"]. '</td>
                    <td>' .$row1["full_name"]. '</td>
                    <td>' .$row1["job_type"]. '</td>   
                    </tr>';
           
            }
            echo '</table><br><br>';

    }

    ?>



</body>

</html>