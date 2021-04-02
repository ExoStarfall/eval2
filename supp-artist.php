<?php
include('confdb.php');
// Requête pour récupérer le style
$connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
$requete = "SELECT * FROM `styles` WHERE `style_id`=:style_id";
$prepare = $connexion->prepare($requete);
$style_id = htmlspecialchars($_GET['id']);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Supprimer un artiste</title>
</head>

<body>
  <style>
    /*SAME */
    body {
      background-color: #edd6fc;
    }

    p {
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
  </style>
  <?php
  
  if (isset($_GET['id']) and is_numeric($_GET['id'])) { // Je lui fait passer l'ID que je récupère

    $artist_id = htmlspecialchars($_GET['id']);
    $connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);

    //récupérer les infos du form
    $requete = "SELECT * FROM `artist` WHERE `artist_id`=:artist_id";
    $prepare = $connexion->prepare($requete);
    $prepare->execute(array(
      "artist_id" => $artist_id
    ));
    $prepare = $prepare->fetch();

    echo ("
        <h1>Supprimer cet artiste?</h1>
        <div class='artist'>
        <form method='POST' action='supp-artist.php?id=" . $prepare['artist_id'] . "'>
        <label for='style'>Style:</label>
        <input type='text' id='artist' name='artist' value='" . $prepare['artist_name'] . "' required>
        
        <input type='hidden' name='id_artist' value='" . $prepare['artist_id'] . "'>
        <input type='submit' name='valider' value='Supprimer'> <br>
        
        <a href='../index.php'>Retour au site </a>
        </form>
        </div>
    ");
  }


  if (isset($_POST['valider'])) {
// On va d'abord délier le style et l'artiste dans la table associative 
    try {
      $artist_id = htmlspecialchars($_POST['id_artist']);
      $style_id = htmlspecialchars($_GET['id']);
      $connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
      $requete =     "DELETE FROM `assoc_style_artist`
                        WHERE `assoc_artist_id` = :artist_id";
      $prepare = $connexion->prepare($requete);
      $prepare->execute(array(
        ":artist_id" => $artist_id


      ));
    } catch (PDOException $e) {
      exit("❌🙀❌ OOPS :\n" . $e->getMessage());
    }
// Pour ensuite supprimer l'artiste

    $connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
    $artist_id = htmlspecialchars($_POST['id_artist']);
    try {

      $requete = "DELETE FROM `artist` WHERE `artist_id`=:artist_id";
      $prepare = $connexion->prepare($requete);
      $prepare->execute(array(
        ":artist_id" => $artist_id



      ));
      $res = $prepare->rowCount();

      if ($res == 1) {
        echo "<p>Artiste supprimé !</p>";
       
      }
    } catch (PDOException $e) {
      exit("OOPS :\n" . $e->getMessage());
    }
  }

  ?>
</body>

</html>