
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
    if(isset($_GET["patient"]) && $_GET["patient"]!= "" ){ 
        $searchName = $_GET["patient"];
        echo '<h4>Showing search results for: '.$searchName.'</h4>';

    } 

    

    $req = "SELECT  A.user_id as user_id, patient_id, full_name 
    FROM usr_patient A 
    LEFT JOIN usr_user C 
    ON A.user_id = C.user_id 
    WHERE LOWER(C.full_name) LIKE '%". strtolower($searchName) ."%'
    ORDER BY A.user_id ";
    $res = pg_query($conn, $req); 
    $array_result1 = pg_fetch_all($res);


    if(count($array_result1)<1){
        echo '<p class="successmsg">No users found.</p>';
    } else{
        echo '<table>
            <tr>
                <th class="thsmall">User ID</th>
                <th>Patient Full Name</th>
                <th>Patient ID</th>
                <th class="thsmall">View Medical folder</th>           
            </tr>';

        foreach ($array_result1 as $row){
            echo '<tr>
                <td>'.$row["user_id"]. '</td>
                <td>' .$row["full_name"]. '</td>
                <td>' .$row["patient_id"]. '</td>   
                <td>
                        <a class="imgbtn" href="./medical_folder.php?patient='.$row["patient_id"].'">
                            <img border="0" alt="viedmdf" src="./IMG/mdfbtn.png" width="30" height="30">
                        </a>
                    </td>
                </tr>';
         

        }



    }
 

    ?>
   


</body>

</html>
