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
    if (!isset($_GET['patient'])) {
        echo '<p class="errormsg">Patient medical folder not found.</p>';
    } else {
        $patientid = $_GET['patient'];

        if ($_GET['patient'] != $_SESSION['loggedin'] &&  $_SESSION['usertype'] != 'dentist') {
            echo ("You are not allowed to view this content");
        } else {
            $mdfheader = "SELECT A.folder_id, A.patient_id, creation_date, language, emergency_contact, SSN, dob, emergency_phone, full_name   
                        FROM mdf_medical_folder A
                        LEFT JOIN usr_patient B
                        ON B.patient_id = A.patient_id
                        LEFT JOIN usr_user C
                        ON B.user_id = C.user_id
                         WHERE A.patient_id='$patientid'";
            $res = pg_query($conn, $mdfheader);
            $mdfheader_result = pg_fetch_all($res);

            
            $mdfcondition = "SELECT A.folder_id, line_no, condition_name, description , patient_id
                             FROM mdf_condition A
                             LEFT JOIN mdf_medical_folder B
                             ON B.folder_id = A.folder_id
                             WHERE patient_id='$patientid'
                             ORDER BY line_no";
            $res = pg_query($conn, $mdfcondition);
            $mdfcondition_result = pg_fetch_all($res);
            
            $mdfmedication = "SELECT A.folder_id,line_no,medication_name,description,dosage , patient_id
                             FROM mdf_medication A
                             LEFT JOIN mdf_medical_folder B
                             ON B.folder_id = A.folder_id
                             WHERE patient_id='$patientid'
                             ORDER BY line_no";
            $res = pg_query($conn, $mdfmedication);
            $mdfmedication_result = pg_fetch_all($res);
           
            $mdfvaccination = "SELECT A.folder_id, line_no, vaccine_name, date_taken, patient_id
                            FROM mdf_vaccination A
                            LEFT JOIN mdf_medical_folder B
                            ON B.folder_id = A.folder_id
                            WHERE patient_id='$patientid'
                            ORDER BY date_taken ";
            $res = pg_query($conn, $mdfvaccination);
            $mdfvaccination_result = pg_fetch_all($res);
          
            $mdfvisits = "SELECT A.folder_id, line_no, specialist_name, enter_date, summary, apt_id, apt_type, diagnosis, tests_made,test_result, medication_prescribed, teeths, notes, patient_id
            FROM mdf_visit_treatment A
            LEFT JOIN mdf_medical_folder B
            ON B.folder_id = A.folder_id
            WHERE patient_id='$patientid'
            ORDER BY line_no";
            $res = pg_query($conn, $mdfvisits);
            $mdf_visit_treatment_res = pg_fetch_all($res);
          


            echo ('<form  action="./PHP_HELPERS/save_medical_changes.php" method="post">
                     <h3>Medical Folder of: ' . $mdfheader_result[0]["full_name"] . '</h3>
                     <div class="mdfheader">  
                     <hr>
                     <label> Name: </label>   
                     <input type="text" name="full_name"  class="readonly" readonly value="' . $mdfheader_result[0]["full_name"] . '" size="30" required /> 
                     <label>  Date of birth: </label>   
                     <input type="text" name="dob"  class="readonly" readonly value="' . $mdfheader_result[0]["dob"] . '" placeholder= "Firstname" size="20" required /> 
                     <label> Social Security No: </label>   
                     <input type="text" name="SSN"  class="readonly" readonly value="' . $mdfheader_result[0]["ssn"] . '" placeholder= "Firstname" size="20" required /> 
                     <br>
                     <label>Emergency Contact Name: </label>    
                     <input type="text" name="emergency_contact" class="readonly" readonly value="' . $mdfheader_result[0]["emergency_contact"] . '"/>  
                      <label>Emergency Contact Phone: </label>    
                     <input type="text" name="emergency_phone" class="readonly" readonly value="' . $mdfheader_result[0]["emergency_phone"] . '"/>  
                     <br>
                     <label>Date of folder creation: </label>    
                     <input type="text" name="date_created" class="readonly" readonly value="' . $mdfheader_result[0]["creation_date"] . '"/>  
                     <label>Patients prefered language: </label>    
                     <input type="text" name="language" class="readonly" readonly value="' . $mdfheader_result[0]["language"] . '"/>  
                    
                     <hr>
                    
                     ');

            echo '
                    <div class="medication_table">
                    <h4>Medication</h4>
                    <table>
                     <tr>
                         <th>Name</th>
                         <th>Description</th>
                         <th>Dosage</th>
                     </tr>';

            foreach ($mdfmedication_result as $row) {

                echo '<tr>
                     <td>' . $row["medication_name"] . '</td>
                     <td>' . $row["description"] . '</td>
                     <td>' . $row["dosage"] . '</td>
                     <tr> ';
            }
            echo'</table> </div>';

            echo '
            <div class="condition_table">
            <h4>Health Conditions/Allergies</h4>
            <table>
             <tr>
                 <th>Name</th>
                 <th>Description</th>
             </tr>';

            foreach ($mdfcondition_result as $row) {

                echo '<tr>
                    <td>' . $row["condition_name"] . '</td>
                    <td>' . $row["description"] . '</td>                  
                    <tr> ';
            }
            echo'</table> </div>';

            echo '
            <div class="vaccination_table">
            <h4>Vaccination</h4>
            <table>
             <tr>
                 <th>Name</th>
                 <th>Description</th>
             </tr>';

            foreach ($mdfvaccination_result as $row) {

                echo '<tr>
                    <td>' . $row["vaccine_name"] . '</td>
                    <td>' . $row["date_taken"] . '</td>                  
                    <tr> ';
            }
            echo'</table> </div>';


            foreach ($mdfcondition_result as $row) {

                echo '<tr>
                    <td>' . $row["condition_name"] . '</td>
                    <td>' . $row["description"] . '</td>                  
                    <tr> ';
            }
            echo'</table> </div>';

            echo '
            <div class="vaccination_table">
            <h4>Vaccination</h4>
            <table>
             <tr>
                 <th>Name</th>
                 <th>Description</th>
             </tr>';

            foreach ($mdfvaccination_result as $row) {

                echo '<tr>
                    <td>' . $row["vaccine_name"] . '</td>
                    <td>' . $row["date_taken"] . '</td>                  
                    <tr> ';
            }
            echo'</table> </div>';

            
            echo '
            <div class="visits_table">
            <h4>Medical checkup history</h4>
            <table>
             <tr>
                <th>Specialist Name</th>
                 <th>Date</th>
                 <th>Summary</th>                
                 <th>Apt Type</th>
                 <th>Tests made</th>
                 <th>Test results</th>
                 <th>Diagnosis</th>
                 <th>Medication Prescribed</th>
                 <th>Teeth</th>
                 <th>Notes</th>
             </tr>';

            foreach ($mdf_visit_treatment_res as $row) {

                echo '<tr>
                    <td>' . $row["specialist_name"] . '</td>
                    <td>' . $row["enter_date"] . '</td>   
                    <td>' . $row["summary"] . '</td>
                    <td>' . $row["apt_type"] . '</td>    
                
                    <td>' . $row["tests_made"] . '</td>    
                    <td>' . $row["test_result"] . '</td>
                    <td>' . $row["diagnosis"] . '</td>
                    <td>' . $row["medication_prescribed"] . '</td>    
                    <td>' . $row["teeths"] . '</td>
                    <td>' . $row["notes"] . '</td>                   
                    <tr> ';
            }
            echo'</table> </div>';

        }

        
    }

    ?>



</body>

</html>