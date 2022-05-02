<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Page Réceptionniste</title>
    <style>
      .phrase_accroche {
        font-weight: bold;
      }
    </style>
  </head>
  <body>
     <?php
       include_once 'header.php';
    ?>
    <p class="phrase_accroche">
      Bienvenue à l'interface utilisateur du réceptionniste.
    </p>

    <p>
      Sur cette page, vous serez en mesure d’ajouter des informations sur les
      patients, de modifier les informations sur les patients et de fixer les
      rendez-vous des patients.
    </p>

    <p>
      Veuillez cliquer sur le module qui vous intéresse afin de procéder aux étapes nécessaires.
    </p>

    <button onclick="redirectAjouter()">Voir les cliniques et leurs employés</button>
    <button onclick="redirectModifier()">Voir les procedures disponibles </button>
    <button onclick="redirectUser()">Voir les utilisateurs</button>
    <button onclick="redirectFixer()">Voir les rendez-vous par clinique</button>

    <script>
      function redirectAjouter(){
        document.location.href="clinics.php";
      }
      function redirectModifier(){
        document.location.href="procedures.php";
      }
      function redirectFixer(){
        document.location.href="voir_rendez_vous.php";
      }

      function redirectUser(){
        document.location.href="receptionist_search_user.php";
      }
      
    </script>

  </body>
</html>