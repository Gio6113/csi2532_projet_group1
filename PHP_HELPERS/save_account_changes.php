<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/general.css">
    <title>Login</title>
  
</head>

<body>

    <?php

    if(isset($_POST)){
            print_r($_POST);
        //     $today = date("Y-m-d");
        // $age = date_diff(date_create($array_result[0]["dob"]), date_create($today));
        // $age =  $age->format('%y');
    }else{
        echo ('<p class="errormsg">Operation failed');

    }
    ?>



</body>

</html>