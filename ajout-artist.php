<?php
// On va faire un select sur les styles
require('confdb.php');
$connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS); // On établit la connexion
$tableau = []; // A revoir pas compris mais ça marche, donc ça m'arrange
$requete = "SELECT * FROM `styles`"; // On sélectionne la table
//On prépare la requête dans un petit try / catch pour la gestion d'erreur
try {
  $prepare = $connexion->prepare($requete);
  $prepare->execute();
  $affichageStyle = $prepare->rowCount();
  if ($affichageStyle) $tableau = $prepare->fetchAll(); // fetchAll pour tout récupérer
  else echo "<pre>✖️ La requête SQL ne retourne aucun résultat</pre>";
} catch (PDOException $e) {
  echo "<pre>✖️ Erreur liée à la requête SQL :\n" . $e->getMessage() . "</pre>";
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/image-create.css">
  <title>Ajouter un artiste </title>
</head>
<style>
    /*SAME */
    body {
      background-color: #edd6fc;
    }

    p {
      text-align: center;
    }
    ul li{
      text-align: center;
    }

    h1 {
      text-align: center;
      margin-top: 5rem;
    }

    .artist {

      position: relative;
      z-index: 1;
      background: #FFFFFF;
      max-width: 360px;
      margin: 0 auto 100px;
      padding: 45px;
      text-align: center;
      box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
    }

    .artist input {
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
    .artist select{
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
<body>
  <h1>Ajouter un artiste </h1>
  <main>
    <div class='artist'>
    <form method='POST' action='ajout-artist.php'>
      <label for='artist'>Artiste:</label>
      <input class='artist_name' type='text' id='artist_name' name='artist_name' required>
      <select name="style_name" id="style_name">
        <?php foreach ($tableau as $style) : ?>
          <!-- On récupère les valeurs via un foreach pour notre dropdown menu là -->
          <option><?= $style["style_name"] ?></option>
        <?php endforeach ?>
      </select>


      <input type='submit' value='Valider'>
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
  if (isset($_POST['artist_name'])) {
    try {
      // La requête d'insertion 
      $requete = "INSERT INTO `artist` (`artist_name`) 
                    VALUES (:artist_name);"; // Requête d'insertion d'artiste  

      // Faut la préparer la requête quand même? ON SECURISE ! Adios les injections 
      $prepare = $connexion->prepare($requete);
      $prepare->execute(array(
        ":artist_name" => $_POST['artist_name']
      ));
      $lastInsertedId = $connexion->lastInsertId(); // On récupère l'id précédemment crée 
    } catch (PDOException $e) {
      // en cas d'erreur, on récup et on affiche, grâce à notre try/catch
      exit("❌🙀💀 OOPS :\n" . $e->getMessage());
    }

    //END
    try {
      // La requête d'insertion dans la table associative 
      $requete = "INSERT INTO `assoc_style_artist` (`assoc_style_id`, `assoc_artist_id`) 
                    VALUES (:style_id, :artist_id);";

      // Faut la préparer la requête quand même? ON SECURISE ! Adios les injections 
      $prepare = $connexion->prepare($requete);
      $prepare->execute(array(
        ":artist_id" => $lastInsertedId, // Pour l'utiliser ici 
        ":style_id" => $style["style_id"] // On va associer un artiste au style 
      ));
      $resultat = $prepare->rowCount(); // rowCount() nécessite PDO::MYSQL_ATTR_FOUND_ROWS => true
    } catch (PDOException $e) {
      // en cas d'erreur, on récup et on affiche, grâce à notre try/catch
      exit("❌🙀💀 OOPS :\n" . $e->getMessage());
    }  //END

         
    echo "<h3>Merci !</h3>";
    echo "<p>Voici un récapitulatif de votre saisie :</p>";
    echo "<ul>" // REKT la faille XSS 
      . "<li>Artiste : " . htmlentities($_POST["artist_name"], ENT_QUOTES) . "</li>" //Affiche ce que je veux rentrer
      . "<li>Style : " . htmlentities($_POST["style_name"], ENT_QUOTES) . "</li>"
      . "<ul>";
    echo "<a href='index.php'><button>Acceuil</button></a>";
  }
  ?>
</body>

</html>