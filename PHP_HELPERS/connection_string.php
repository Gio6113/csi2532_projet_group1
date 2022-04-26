<?php
    session_start();
    $host = "host=localhost";
    $port = "port=15432";
    $dbname = "dbname=dentist_clinic";
    $credentials = "user=postgres password=admin";

    $conn = pg_connect("$host $port $dbname $credentials");
    if (! $conn) {
            echo "Error : Connection to database unsuccessful\n";
    } 
?>