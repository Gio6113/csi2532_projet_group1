<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Fixer les rendez-vous</title>
    <style>
      .phrase_accroche {
        font-weight: bold;
      }
    </style>
  </head>
  <body>
    
  <?php include_once "header.php";?>
    <p class="phrase_accroche">
        Sur cette page, vous serez en mesure de fixer les rendez-vous des patients.
    </p>

    <p>
        Veuillez remplir les cases désirées puis cliquer sur CREATE APPOINTMENT.
    </p>

      
    <form action="./PHP_HELPERS/create_appointment.php" method="post">
    
    
    
      <label> Identifiant du patient: </label> 
      <?php   echo '<input type="text" name="patient_id" class="readonly" readonly value="'.$_GET["account"].'" placeholder= "id_dentiste" size="15" required /> '
       ?>
      <div>  
      <label>
      <label> Identifiant du dentiste: </label>   
      <input type="text" name="id_dentiste" placeholder= "id_dentiste" size="15" required />    
      <div>  
      <label> 
     
   
    <label for="date du rendez-vous">Date du rendez-vous:</label>
    <input type="date" id="date" name="date">
    <div>  
    <label>
    Horaire :
      <label> Heure de debut: </label>   
      <input type="text" name="start_time" placeholder= "xx:xx:xx" size="15" required /> 
      <label> Heure de fin: </label>
      <input type="text" name="end_time" placeholder="yy:yy:yy" size="15"required />   
      <div>


      <label> Room number: </label>   
      <input type="text" name="room_number" placeholder= "room_number" size="15" required />    
      <div>  
      <label>

    Status:  
      </label>   
      <select name="status">  
      <option value="not determined">not determined</option>  
      <option value="canceled">canceled</option>  
      <option value="late cancelation">late cancelation</option>  
      <option value="unforseen">unforeseen</option>
      <option value="finished">finished</option>
      <option value="rejected by dentist">rejected by dentist</option>
      <option value="normal">normal</option>   
      </select>  
      </div>  
      <div>  
      <label>
        <br>


    Choisissez le type de procedure que le patient souhaite faire:  
      </label>   
      <select name="procedure">  
      <?php

      $req2 = "SELECT fee_id, procedure_description, fees, procedure_code
      FROM pay_procedure_fee"; 
      $res = pg_query($conn, $req2); 
      $array_result2 = pg_fetch_all($res);

      foreach ($array_result2 as $row1){
        echo ' <option value="'.$row1["procedure_description"].'">'.$row1["procedure_description"] .'</option>';
      }
      ?>  
      </select>  
      </div>  
      <div>  
      <label>

    <label> Combien d'applicage de cette procedure? : </label>   
    <input type="text" name="quantite" placeholder= "quantite" size="15" required />    
    <div> 
    <label> Sur Quel dents le patient sera-t-il opere ? : </label>   
    <input type="text" name="teeth" placeholder= "dents" size="15" required />    
    <div>  
    <label>

    
    <button type="submit">Create Appointment</Button>
    </form>
  </body>
</html>