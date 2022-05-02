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


    echo ' <form action="./PHP_HELPERS/new_procedure.php" method="post">
        <h3> Here is a list of all clinics:</h3>
        <p>Add a new clinic here</p>
    ';
    
    $req = "SELECT  fee_id, procedure_description, fees, procedure_code  
    FROM pay_procedure_fee
    ORDER BY procedure_code"; 
    $res = pg_query($conn, $req); 
    $array_result1 = pg_fetch_all($res);


    
        echo '<table>
            <tr>
                <th class="thsmall">Fee ID</th>
                <th>Procedure Description</th>
                <th>Fees / Cost</th>
                <th class="thsmall">Procedure Code</th> 
                     
            </tr>';

        foreach ($array_result1 as $row){
            echo '<tr>
                <td>'.$row["fee_id"]. '</td>
                <td>' .$row["procedure_description"]. '</td>
                <td>' .$row["fees"]. '</td>   
                <td>' .$row["procedure_code"]. '</td>
            
                </tr>';
         

        }

    echo  '<tr>
    <td><input type="text" name="fee_id"  value="" placeholder= "fee id" size="20" required /> </td>
    <td><input type="text" name="procedure_description"  value="" procedure_description= "clinic name" size="20" required /> </td>
    <td><input type="text" name="fees"  value="" placeholder= "procedure cost" size="30" required /> </td>   
    <td><input type="text" name="procedure_code"  value="" placeholder= "procedure code" size="20" required /> </td>
     </tr>  
     </table> </div>
     <button type="submit" id="loginButton">Add Procedure</button>
     </form>';