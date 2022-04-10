<?php
    require_once 'connection_string.php';

    $username = $_GET["username"];
    $password = $_GET["password"];

    $req = "SELECT first_name, last_name, full_name, username, user_type  FROM usr_user WHERE username='$username' AND password='$password'";
    $res = pg_query($conn, $req); 
    $array_result = pg_fetch_all($res);

    if(count($array_result) < 1){
        echo "Incorrect Username or Password"; 
    }else
    { echo 
        "<table>
            <tr>
            <th>Prenom</th>
            <th>nom</th>
            <th>Nom complet</th>
            <th>username</th>
            <th>user_type</th>
            </tr>";
        foreach( $array_result as $var) { 
        echo 
            "<tr>
            <td>$var[first_name]</td>
            <td>$var[last_name]</td>
            <td>$var[full_name]</td> 
            <td>$var[username]</td> 
            <td>$var[user_type]</td>  
        </tr>";
    }
    echo "</table>";
}
?>