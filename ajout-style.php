<?php
require('confdb.php'); // Récupérer les constantes ici 

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/image-create.css">
    <title>Ajoute un style </title>
</head>
<body>   
<style>
    /*SAME */
    body {
      background-color: lightgoldenrodyellow;
    }

    p {
      text-align: center;
    }

    h1 {
      text-align: center;
      margin-top: 5rem;
    }

    .style {

      position: relative;
      z-index: 1;
      background: #FFFFFF;
      max-width: 360px;
      margin: 0 auto 100px;
      padding: 45px;
      text-align: center;
      box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
    }

    .style input {
      font-family: "Roboto", sans-serif;
      outline: 0;
      background: #f2f2f2;
      width: 100%;
      border: 0;
      margin: 0 0 15px;
      padding: 15px;
      box-sizing: border-box;
      font-size: 14px;
    }
   
    .gros-btn {
      font-family: "Roboto", sans-serif;
      outline: 0;
      background: #f2f2f2;
      width: 10%;
      border: 0;
      margin-left: 45%;
      padding: 15px;
      box-sizing: border-box;
      font-size: 14px;

    }
    </style>
   <h1>Ajouter un style </h1>
    <main>
      <div class='style'>
      <!-- Formulaire d'ajout de style  -->
        <form method='POST' action='ajout-style.php'>
            <label for='style'>Style:</label>
            <input class='style_name' type='text' id='style_name' name='style_name' required>
            <input class='submit' type='submit' value='Valider'>
        </form>
  </div>
    </main>
    <footer>
        <form method='post' action='index.php'>
            <button class='gros-btn' type='submit'>Retour</button>
        </form>
    </footer>
    <?php
  $connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
  if (isset($_POST['style_name'])) {
    try {
        // La requête d'insertion de styles
        $requete = "INSERT INTO `styles` (`style_name`) 
                    VALUES (:style_name);"; 
      
       // Faut la préparer la requête quand même? ON SECURISE ! Adios les injections 
        $prepare = $connexion->prepare($requete);
        $prepare->execute(array(
          ":style_name" => $_POST['style_name']
        ));
      } catch (PDOException $e) {
        // en cas d'erreur, on récup et on affiche, grâce à notre try/catch
        exit("❌🙀💀 OOPS :\n" . $e->getMessage());
      }  //END
        
        
        echo "<h3>Merci !</h3>";
        echo "<p>Voici un récapitulatif de votre saisie :</p>";
        echo "<ul>" // REKT la faille XSS , récupération de la saisie 
            ."<li>Style : " . htmlentities($_POST["style_name"], ENT_QUOTES) . "</li>"
            ."<ul>";
        echo "<a href='index.php'><button>Acceuil</button></a>";
      
    

    }
   ?>
</body>
</html>