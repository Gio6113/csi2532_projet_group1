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

    
       $req = "SELECT  patient_id
       FROM usr_patient A 
       LEFT JOIN usr_user C 
       ON A.user_id = C.user_id 
       WHERE A.user_id = " . $_SESSION["loggedin"]. "
       ORDER BY A.user_id ";
       $res = pg_query($conn, $req); 
       $array_result1 = pg_fetch_all($res);
       echo '

       <h4>As a medical staff, you can view the appointments that are booked with you and accept, reject or complete them by clicking  "View and complete appointments". 
       You can also view and edit medical folders with "View and edit medical folders".
</h4>  

    <button onclick="redirectApt()">View My appointments </button>
    
   <button onclick="redirectDM()">View My Medical Folders</button>

    <script>
      function redirectDM(){
        document.location.href="./medical_folder.php?patient='.$array_result1[0]["patient_id"].'";
      }
      function redirectApt(){
        document.location.href="viewaptpatient.php";
      }
    </script> 
      '
    ?>
   
   

</body>
</html>