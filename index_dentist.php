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
    ?>
   
   <h4>As a medical staff, you can view the appointments that are booked with you and accept, reject or complete them by clicking  "View and complete appointments". 
       You can also view and edit medical folders with "View and edit medical folders".
</h4>  

    <button onclick="redirectApt()">View and complete appointments </button>
    
   <button onclick="redirectDM()">View and edit Medical Folders</button>

    <script>
      function redirectDM(){
        document.location.href="dentist_search_user.php";
      }
      function redirectApt(){
        document.location.href="viewaptdentist.php";
      }
     
    </script>

</body>
</html>