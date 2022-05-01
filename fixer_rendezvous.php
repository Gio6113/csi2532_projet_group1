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
    <p class="phrase_accroche">
        Sur cette page, vous serez en mesure de fixer les rendez-vous des patients.
    </p>

    <p>
        Veuillez remplir les cases désirées puis cliquer sur SUBMIT.
    </p>


    First and Last Name :
        <label> Firstname: </label>   
        <input type="text" name="firstname" placeholder= "Firstname" size="15" required /> 
        <label> Lastname: </label>    
        <input type="text" name="lastname" placeholder="Lastname" size="15"required />   
        <div>  
    <label>
    
      <label> Identifiant du dentiste: </label>   
      <input type="text" name="id_dentiste" placeholder= "id_dentiste" size="15" required />    
      <div>  
      <label> 
      <label> Nom du patient: </label>   
      <input type="text" name="name_patient" placeholder= "name_patient" size="15" required />    
      <div>  
      <label>
      <label> Identifiant du patient: </label>   
      <input type="text" name="id_patient" placeholder= "id_patient" size="15" required />    
      <div>  
      <label>
   
    <label for="date du rendez-vous">Date du rendez-vous:</label>
    <input type="date" id="date" name="date">
    <div>  
    <label>
    Horaire :
      <label> Heure de debut: </label>   
      <input type="text" name="xx:xx" placeholder= "xx:xx" size="15" required /> 
      <label> Heure de fin: </label>
      <input type="text" name="yy:yy" placeholder="yy:yy" size="15"required />   
      <div>

   
      <label> Appointment Identifiant: </label>   
      <input type="text" name="id_appointment" placeholder= "id_appointment" size="15" required />    
      <div>  
      <label>

      <label> Room number: </label>   
      <input type="text" name="room_number" placeholder= "room_number" size="15" required />    
      <div>  
      <label>

    Status:  
      </label>   
      <select>  
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


    Choisissez le type de procedure que le patient souhaite faire:  
      </label>   
      <select>  
      <option value="Fluorure pour les dents">Fluorure pour les dents</option>  
      <option value="Detartrage">Detartrage</option>  
      <option value="retrait">retrait</option>  
      <option value="guerir carie">guerir carie</option>  
      </select>  
      </div>  
      <div>  
      <label>

    <label> Sur combien de dents le patient sera-t-il opere ? : </label>   
    <input type="text" name="quantite" placeholder= "quantite" size="15" required />    
    <div>  
    <label>

    
    <button type="submit">SUBMIT </Button>
    
  </body>
</html>