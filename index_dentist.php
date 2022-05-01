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
   
   <h1>You are a dentist</h1>  

   <button onclick="redirectDM()">Voir les dossiers medicales</button>
   <button onclick="redirectApt()">Voir et Completer les rendez-vous </button>
    
    <script>
      function redirectDM(){
        document.location.href="ajouter_information.php";
      }
      function redirectApt(){
        document.location.href="modifier_information.php";
      }
     
    </script>

</body>
</html>