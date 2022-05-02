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


    echo '
        <h2> Here is a list of all upcoming appointments at clinics:</h2>
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

    foreach ($array_result1 as $row){
        echo '<h4>'.$row["clinic_name"].'</h4>';
        echo '<table>
        <tr>
            <th class="thsmall">Apt ID</th>
            <th>Patient Name</th>
            <th>Specialist Name</th> 
            <th class="thsmall">Date </th>
            <th class="thsmall">Starts </th>
            <th class="thsmall">Ends </th>
            <th class="thsmall">Type of apt </th>
            <th >Status </th>
            <th class="thsmall">Room  </th>      
        </tr>';

            $req2 = "SELECT  A.apt_id, A.patient_id, A.dentist_id, A.clinic_id, A.date, A.start_time, A.end_time, A.type, A.status, A.room_number, BB.full_name as patient_name, CC.full_name as specialist_name, D.clinic_name
            FROM rdv_appointment A  
            LEFT JOIN usr_patient B
            ON A.patient_id = B.patient_id
            LEFT JOIN usr_user BB
            ON B.user_id = BB.user_id
            LEFT JOIN usr_employee C
            ON A.dentist_id = C.employee_id
            LEFT JOIN usr_user CC
            ON C.user_id = CC.user_id
            LEFT JOIN usr_clinic D
            ON A.clinic_id = D.clinic_id
            WHERE A.clinic_id = ".$row["clinic_id"]. "AND a.status ='normal' 
            ORDER BY A.date,A.start_time"; 
            $res = pg_query($conn, $req2); 
            $array_result2 = pg_fetch_all($res);
          
            foreach ($array_result2 as $row1){
                echo '<tr>
                    <td>'.$row1["apt_id"]. '</td>
                    <td>' .$row1["patient_name"]. '</td>
                    <td>' .$row1["specialist_name"]. '</td> 
                    <td>' .$row1["date"]. '</td>
                    <td>' .$row1["start_time"]. '</td>
                    <td>' .$row1["end_time"]. '</td>
                    <td>' .$row1["type"]. '</td>
                    <td>' .$row1["status"]. '</td> 
                    <td>' .$row1["room_number"]. '</td>   
                    </tr>';

           
            }
            echo '</table><br><br>';

    }

    ?>



</body>

</html>