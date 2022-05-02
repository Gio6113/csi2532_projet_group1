<?php
    require_once 'connection_string.php';

  


    $req = "SELECT max(apt_id)+1  as nextID
    FROM rdv_appointment"; 
    $res = pg_query($conn, $req); 
    $array_result1 = pg_fetch_all($res);



    $apt_id = (int)  $array_result1[0]["nextid"];
    $patient_id = (int) $_POST["patient_id"];
    $dentist_id = (int) $_POST["id_dentiste"];
    $start_time =  "'" .$_POST["start_time"].  "'";
    $end_time =  "'" . $_POST["end_time"].  "'";
    $date =  "'" . $_POST["date"] . "'";
    $status =  "'" . $_POST["status"] .  "'";
    $type = "'" . $_POST["procedure"] .  "'";
    $room_number = "'" . $_POST["room_number"] .  "'";

    $req2 = "SELECT  D.clinic_id
    FROM  usr_employee C
    LEFT JOIN usr_clinic D
    ON C.work_clinic = D.clinic_id
    WHERE C.employee_id = ".$dentist_id.""; 
    $res = pg_query($conn, $req2); 
    $array_result2 = pg_fetch_all($res);
   
    $clinic_id = (int)  $array_result2[0]["clinic_id"];
  


    // $req = "INSERT  user_id, first_name, last_name, full_name, username, user_type  FROM usr_user WHERE username='$username' AND password='$password'";
    // $res = pg_query($conn, $req); 
            $req = "INSERT INTO rdv_appointment (apt_id, patient_id, dentist_id, clinic_id, date, start_time, end_time, type, status, room_number)
            VALUES (".$apt_id.", ".$patient_id.",".$dentist_id.", ".$clinic_id. ",".$date.",".$start_time.",".$end_time.",".$type.",".$status.",".$room_number.")";
        $res = pg_query($conn, $req); 
        if( $res){
       echo ("Appointment successfully created!");

        }else{
            echo "error with adding new clinic";
}

   
?>