<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Signup</title>
    <link rel="stylesheet" href="CSS/general.css">
    <script src="signup.js"></script>
</head>
<body>
    <?php
        include_once 'header.php';
    ?>
    <h1>Signup</h1>
    <div class="dropdown">
        <button class="dropbtn">Account Type</button>
        <div class="dropdown-content">
          <option id="medicalStaff" onclick="showExtraFields('employee'); hideExtraFields('employeePatient'); 
          hideExtraFields('patient'); hideExtraFields('underage')">Doctor/medical staff</option>
          <option id="patient"  onclick="showExtraFields('employeePatient'); showExtraFields('patient'); 
          hideExtraFields('employee'); ; hideExtraFields('underage')">Patient</option>
          <option id="user" onclick="hideExtraFields('underage'); hideExtraFields('employeePatient');
          hideExtraFields('patient'); hideExtraFields('underage'); hideExtraFields('employee')">User</option>
          <option id="admin" onclick="showExtraFields('employee') ; hideExtraFields('underage'); hideExtraFields('employeePatient');
           hideExtraFields('patient')">Admin/Receptionist</option>
        </div>
      </div>
    <div>
      <br>
      <label for="firstName"><b>First Name:</b></label>
      <input id="firstName" name="firstName" rows="1" cols="30" required maxlength="255">
      <br>
      <label for="lastName"><b>Last Name:</b></label>
      <input id="lastName" name="lastName" rows="1" cols="30" required maxlength="255">
      <br>
      <label for="username"><b>Username:</b></label>
      <input id="userName" name="username" rows="1" cols="30" required maxlength="255">
      <br>
      <label for="password"><b>Password:</b></label>
      <input type="password" id="password" name="password" rows="1" cols="30" required maxlength="255">
      <br>
      <label for="start"><b>Date of Birth:</b></label>
      <input type="date" id="dob" name="DateOfBirth"
        value="2022-04-18" required
        min="1900-01-01" max="2022-12-31" oninput="isOldEnough()">
      <br>
      <div>
        <label for="gender"><b>Gender:</b></label>
        <br>
        <input type="radio" id="male" name="male" value="male">
        <label for="male">male</label>
        <br>
        <input type="radio" id="female" name="female" value="female">
        <label for="female">female</label>
        <br>
      </div>
      <br>
      <label for="homeAdress"><b>Home Adress:</b></label>
      <input id="homeAdress" name="homeAdress" rows="1" cols="30" required maxlength="255">
      <br>
    </div>
    

    <div id="employeePatient" hidden>
      <br>
      <label for="employeeId"><b>employeId: (if you are an employee)</b></label>
      <input id="employeeId" name="employeeID" rows="1" cols="30" maxlength="255">
      <br>
    </div>

    <div id="underage" hidden>
      <br>
      <label for="responsibleAdult"><b>Please enter the username associated with the account of your legal guardian:</b></label>
      <input id="responsibleAdult" name="responsibleAdult" rows="1" cols="30" required maxlength="255">
      <br>
    </div>

    <div id="employee" hidden>
      <br>
      <label for="workAdress"><b>work Adress:</b></label>
      <input id="workAdress" name="workAdress" rows="1" cols="30" required maxlength="255">
      <br>
      <div>
        <label for="jobType"><b>Job type:</b></label>
        <br>
        <input type="radio" id="dentist" name="dentist" value="dentist">
        <label for="dentist">Dentist</label>
        <br>
        <input type="radio" id="hygenist" name="hygenist" value="hygenist">
        <label for="hygenist">hygenist</label>
        <br>
        <input type="radio" id="receptionist" name="receptionist" value="receptionist">
        <label for="receptionist">receptionist/admin</label>
        <br>
      </div>
    </div>
    <div id="patient" hidden>
      <br>
      <label for="phone"><b>Enter your phone number:</b></label>
      <input type="tel" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
      <br>
      <label for="email"><b>Enter your email:</b></label>
      <input type="email" id="email" name="email">
    </div>
    <div hidden>
      <p></p>
    </div>
    
    <button type="button">Create Account</button>
    <?php
      $host = "host=localhost";
      $port = "port=5432";
      $dbname = "dbname=dentist_clinic";
      $credentials = "user=postgres password=admin";
    
      $conn = pg_connect("$host $port $dbname $credentials");
      if (! $conn) {
              echo "Error : Connection to database unsuccessful\n";
      } 
      //find a solution for user id and age
      $first_name = $_GET['firstName']; 
      $last_name = $_GET['lastName']; 
      $username = $_GET['userName'];
      $password = $_GET['password'];
      $user_type = $_GET['']; //tbd
      $dob = $_GET['dob'];
      echo $age = "<script>calculateAge($dob);</script>";
      $sql = "INSERT INTO usr_user 
      (user_id, first_name, last_name, full_name, username, usr_user.password, user_type, dob, age) 
      VALUES (1, $first_name, $last_name, $first_name $last_name, $username, $password, $user_type, $dob,  "
    ?>

</body>
</html>