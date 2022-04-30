<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./CSS/general.css">
    <title>Login</title>
</head>
<body>
    <div class="header"> 
        <h1 class="header_title">Dentist Clinics Canada</h1>
         <img class="logo" src="IMG/logo.jpg">
    </div>
    <?php 
         session_start();
         $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
    
         if($curPageName == 'index.php' || $curPageName == 'signup.php' ){
         }
         else if (!isset($_SESSION['loggedin'])){
             header("location: ./redirect.php");
         }else{
             
            echo(
                '<div class="navbar">
                <ul>
                    
                    <li><a href="index.php">Logout</a></li>
                    <li><a href="account_view.php?account='.$_SESSION['loggedin'].'">My Account</a></li>
                    <li><p class="username">Logged in as: ' . $_SESSION["fullname"] . '</p></li>
                    <li><p class="username">Account type: ' . $_SESSION["usertype"] . '</p></li>
               
                </ul>
                </div>'
            );

         }
    ?>


    
</html>