<?php
require('confdb.php');

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/image-create.css">
    <title>Ajoute un genre </title>
</head>
<body>   
<style>
    /*SAME */
    body {
      background-color: aliceblue;
    }

    p {
      text-align: center;
    }

    h1 {
      text-align: center;
      margin-top: 5rem;
    }

    .genre {

      position: relative;
      z-index: 1;
      background: #FFFFFF;
      max-width: 360px;
      margin: 0 auto 100px;
      padding: 45px;
      text-align: center;
      box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
    }

    .genre input {
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
   <h1>Ajouter un genre </h1>
    <main>
      <div class='genre'>
      <!-- Form classique pour ajouter un genre  -->
        <form method='POST' action='ajout-genre.php'>
            <label for='genre'>Genre:</label>
            <input class='genre_name' type='text' id='genre_name' name='genre_name' required>
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
  if (isset($_POST['genre_name'])) { // Faut pas que le champ soit vide 
    try {
        // La requête d'insertion de genre 
        $requete = "INSERT INTO `genres` (`genre_name`) 
                    VALUES (:genre_name);"; 
      
       // Faut la préparer la requête quand même? ON SECURISE ! Adios les injections 
        $prepare = $connexion->prepare($requete);
        $prepare->execute(array(
          ":genre_name" => $_POST['genre_name']
        ));
      } catch (PDOException $e) {
        // en cas d'erreur, on récup et on affiche, grâce à notre try/catch
        exit("❌🙀💀 OOPS :\n" . $e->getMessage());
      }  //END
        
        // Petit bout de code mafois fort  sympathique  I KEEP 
        echo "<h3>Merci !</h3>";
        echo "<p>Voici un récapitulatif de votre saisie  :</p>";
        echo "<ul>" // REKT la faille XSS , // récupération de la saisie 
            ."<li>Genre : " . htmlentities($_POST["genre_name"], ENT_QUOTES) . "</li>"
            ."<ul>";
        echo "<a href='index.php'><button>Acceuil</button></a>";
      
    

    }
   ?>
</body>
</html>