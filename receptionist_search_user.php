
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/general.css">
    <title>Login</title>
    
</head>

<body>

 
    
    <?php
    include_once 'header.php';

    ?>
    <br><br>
    <form action="./PHP_HELPERS/searchuserresult.php" method="post">
        <label for="searchval"><b>Search:</b></label> <br>
            <input id="searchval" placeholder="Search by name of user" name="searchval" rows="1" cols="30" maxlength="30">
            
            <button type="submit" id="searchButton">Search</button>
    </form>

    
    
    <?php

    
    $searchName ="";
    if(isset($_GET["search"]) && $_GET["search"]!= "" ){ 
        $searchName = $_GET["search"];
        echo '<h4>Showing search results for: '.$searchName.'</h4>';

    } 

    

    $req = "SELECT full_name, job_type, A.user_id as user_id, patient_id, B.employee_id , 
    CASE 
        WHEN patient_id  IS NULL AND B.employee_id IS NULL THEN 'casual'
        WHEN patient_id IS NOT NULL  THEN 'patient'
        WHEN B.employee_id IS NOT NULL THEN CAST(job_type AS VARCHAR)
        ELSE 'error'
    END AS user_type

    FROM usr_user A 
    LEFT JOIN usr_employee B
    ON A.user_id = B.user_id 
    LEFT JOIN usr_patient C 
    ON A.user_id = C.user_id 
    WHERE LOWER(A.full_name) LIKE '%". strtolower($searchName) ."%'
    ORDER BY A.user_id ";
    $res = pg_query($conn, $req); 
    $array_result1 = pg_fetch_all($res);


    if(count($array_result1)<1){
        echo '<p class="successmsg">No users found.</p>';
    } else{
        echo '<table>
            <tr>
                <th class="thsmall">User ID</th>
                <th>Full Name</th>
                <th>User/Job type</th>
                <th class="thsmall">Patient or Employee ID</th>
                <th class="thsmall">New appointment</th>
                <th class="thsmall">View account</th>
                <th class="thsmall">Delete account</th>
            </tr>';

        foreach ($array_result1 as $row){
            echo '<tr>
                <td>'.$row["user_id"]. '</td>
                <td>' .$row["full_name"]. '</td>
                <td>' .$row["user_type"]. '</td>';
            
            if($row["user_type"]=="casual"){
                echo '<td class="td"></td>';
            }else if($row["user_type"]=="patient"){
                echo '<td class="td">'.$row["patient_id"].'</td>';
            }else{
                echo '<td class="td">'.$row["employee_id"].'</td>';
            }

            if($row["user_type"]=="patient"){
                echo '<td>
                        <a class="imgbtn" href="./fixer_rendezvous.php?account='.$row["user_id"].'">
                            <img border="0" alt="viewaccount" src="./IMG/newapt.png" width="30" height="30">
                        </a>
                    </td>';
            }else{
                echo '<td></td>';
            }
            echo'
                <td> 
                <a class="imgbtn" href="./account_view.php?account='.$row["user_id"].'">
                    <img border="0" alt="viewaccount" src="./IMG/modaccnt.png" width="30" height="30">
                </a>
                </td>
                <td>
                    <a class="imgbtn" href="./PHP_HELPERS/deleteaccount.php?delete='.$row["user_id"].'">
                         <img border="0" alt="deletebtn" src="./IMG/deletebtn.jpg" width="30" height="30">
                    </a>
                </td>
                <tr>';

        }



    }
 

    ?>
   


</body>

</html>
