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
    Dentiste:
      <label> dentiste responsable: </label>   
      <input type="text" name="xxx" placeholder= "xxx" size="15" required />    
      <div>  
      <label> 
    Date:
    <label for="date du rendez-vous">Date du rendez-vous:</label>
    <input type="date" id="date" name="date">
    <div>  
    <label>
    Horaire :
      <label> Heure de debut: </label>   
      <input type="text" name="xx:xx" placeholder= "xx:xx" size="15" required /> 
      <label> Heure de fin: </label>
      <input type="text" name="xx:xx" placeholder="xx:xx" size="15"required />   
      <div>
    
    <button type="submit">SUBMIT </Button>
    
  </body>
</html>