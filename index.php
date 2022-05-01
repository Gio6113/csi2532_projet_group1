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
        session_start();
        session_destroy();
       include_once 'header.php';
    ?>
   
   <h1>Login</h1>

   <?php
        if(isset($_GET["error"])){
            if($_GET["error"] == "invalidCredentials"){
                echo '<p class="errormsg">Invalid username or password. Please try again</p>';
            }
        } 
   ?>
   


    <form action="./PHP_HELPERS/login.php" method="post">
            <label for="username"><b>Username:</b></label>
            <input id="username" name="username" rows="1" cols="30" required maxlength="255">
            <br>
            <label for="password"><b>Password:</b></label>
            <input type="password" id="password" name="password" rows="1" cols="30" required maxlength="255">
            <br>
        <button type="submit" id="loginButton">Login</button>
    </form> 

    <h3>Don't have an account? Create one here to join Canada's best dentist clinic system</h3>
    <a href="./signup.php">
        <button type="button" id="createAccountButton">Create Account</button>
    </a>
    
</body>
</html>