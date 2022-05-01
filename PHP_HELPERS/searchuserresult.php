<?php
    require_once 'connection_string.php';
    $_redirect = "location: ../receptionist_search_user.php?search=" . $_POST["searchval"];
     header( $_redirect);
?>