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

    <button onclick="redirectAjouter()">Ajouter les informations des patients</button>
    <button onclick="redirectModifier()">Modifier les informations des patients</button>
    <button onclick="redirectFixer()">Fixer les rendez-vous des patients</button>

    <script>
      function redirectAjouter(){
        document.location.href="ajouter_information.html";
      }
      function redirectModifier(){
        document.location.href="modifier_information.html";
      }
      function redirectFixer(){
        document.location.href="fixer_rendezvous.html";
      }
    </script>

  </body>
</html>