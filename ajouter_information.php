<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Ajout des informations des patients</title>
    <style>
      .phrase_accroche {
        font-weight: bold;
      }
    </style>
  </head>
  <body>
    <p class="phrase_accroche">
        Sur cette page, vous serez en mesure d’ajouter des informations sur les
        patients.
    </p>

    <p>
        Veuillez remplir les cases désirées puis cliquer sur SUBMIT.
    </p>

    <form>  
        <div class="container">  
        <hr>
        First and Last Name :
        <label> Firstname: </label>   
        <input type="text" name="firstname" placeholder= "Firstname" size="15" required /> 
        <label> Lastname: </label>    
        <input type="text" name="lastname" placeholder="Lastname" size="15"required />   
        <div>  
        <label>
        Adresse :
        <label> Rue: </label>   
        <input type="text" name="rue" placeholder= "rue" size="15" required /> 
        <label> Ville: </label>    
        <input type="text" name="ville" placeholder="ville" size="15"required />  
        <label> Province: </label>    
        <input type="text" name="province" placeholder="province" size="15"required /> 
        <div>  
        <label>
        Date:
        <label for="birthday">Date of birth:</label>
        <input type="date" id="birthday" name="birthday">
        <div>  
        <label>
        SSN:
            <label> Social security number: </label>   
            <input type="text" name="SSN" placeholder= "SSN" size="15" required />    
            <div>  
            <label> 
        Adresse email:
            <label> Email: </label>   
            <input type="text" name="email" placeholder= "email" size="15" required />    
            <div>  
            <label>   
        Insurance type :  
        </label>   
        <select>  
        <option value="Individual">Individual</option>  
        <option value="Family">Family</option>  
        <option value="Senior">Senior</option>  
        <option value="Student">Student</option>  
        <option value="Government">Government</option>   
        </select>  
        </div>  
        <div>  
        <label>   
        Gender :  
        </label>  
        <br>  
        <input type="radio" value="Male" name="gender" checked > Male   
        <input type="radio" value="Female" name="gender"> Female  
        <input type="radio" value="Non-Binary" name="gender">Non-Binary  
        </div>  
        <button type="submit">SUBMIT </Button>  
          
    </form>

  </body>
</html>