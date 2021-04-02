<?php
require_once('confdb.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le musicien là</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Ma bibliothèque musicale</h1>
    <a href='ajout-genre.php'><button> Ajouter un genre</button></a>
    <a href='ajout-style.php'><button>Ajouter un style</button></a>
    <a href='ajout-artist.php'><button>Ajouter un artiste</button></a>

  </header>
<h1>Genres</h1>
<div class='genre'>
<?php
// On va faire une première requête pour afficher les genres
  $connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS); // On établit la connexion
  $tableau = []; // A revoir 
  $requete = "SELECT * FROM `genres`"; // On sélectionne la table
 //On prépare la requête dans un petit try / catch pour la gestion d'erreur
  try {
    $prepare = $connexion->prepare($requete);
    $prepare->execute();
    $affichageGenre = $prepare->rowCount();
    if ($affichageGenre) $tableau = $prepare->fetchAll();
    else echo "<pre>✖️ La requête SQL ne retourne aucun résultat</pre>";
  } catch (PDOException $e) {
    echo "<pre>✖️ Erreur liée à la requête SQL :\n" . $e->getMessage() . "</pre>";
  }
// Petit foreach pour tout afficher 
  foreach ($tableau as $genre) {
    echo "<section>";
    echo "<p>" . htmlentities($genre["genre_name"], ENT_QUOTES) . "</p>"; // Ajout du HTML entities pour éviter les failles XSS GET REKT 
    echo ("<a id='mod1' href='modif-genre.php/?id=".$genre["genre_id"]."'> Modifier ce genre </a> <br>");
    echo ("<a id='mod1' href='supp2.php/?id=".$genre["genre_id"]."'> Supprimer ce genre </a> <br>");
    echo "</section>";
  }

?> 
</div>
<h1>Styles</h1>
<div class='style'>
<?php
// On va faire une seconde requête pour afficher les styles
  $connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS); // On établit la connexion
  $tableau = []; // A revoir 
  $requete = "SELECT * FROM `styles`"; // On sélectionne la table
 //On prépare la requête dans un petit try / catch pour la gestion d'erreur
  try {
    $prepare = $connexion->prepare($requete);
    $prepare->execute();
    $affichageStyle = $prepare->rowCount();
    if ($affichageStyle) $tableau = $prepare->fetchAll();
    else echo "<pre>✖️ La requête SQL ne retourne aucun résultat</pre>";
  } catch (PDOException $e) {
    echo "<pre>✖️ Erreur liée à la requête SQL :\n" . $e->getMessage() . "</pre>";
  }
// Petit foreach pour tout afficher 
  foreach ($tableau as $style) {
    echo "<section>";
    echo "<p>" . htmlentities($style["style_name"], ENT_QUOTES) . "</p>"; // Ajout du HTML entities pour éviter les failles XSS GET REKT 
    echo ("<a id='mod1' href='modif-style.php/?id=".$style["style_id"]."'> Modifier ce style </a> <br>");
    echo ("<a id='mod1' href='supp-style.php/?id=".$style["style_id"]."'> Supprimer ce style </a> <br>");
    echo "</section>";
  }

?> 
</div>
<h1> Artistes </h1>
<div class='artist'>
<?php
// On va faire une seconde requête pour afficher les styles
$connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS); // On établit la connexion
$tableau = []; // A revoir 
$requete = "SELECT * FROM `artist`"; // On sélectionne la table
//On prépare la requête dans un petit try / catch pour la gestion d'erreur
try {
  $prepare = $connexion->prepare($requete);
  $prepare->execute();
  $affichageArtist = $prepare->rowCount();
  if ($affichageArtist) $tableau = $prepare->fetchAll();
  else echo "<pre>✖️ La requête SQL ne retourne aucun résultat</pre>";
} catch (PDOException $e) {
  echo "<pre>✖️ Erreur liée à la requête SQL :\n" . $e->getMessage() . "</pre>";
}
// Petit foreach pour tout afficher 
foreach ($tableau as $artist) {
  echo "<section>";
  echo "<p>" . htmlentities($artist["artist_name"], ENT_QUOTES) . "</p>";
  echo "<p>" . htmlentities($style["style_name"], ENT_QUOTES) . "</p>";// Ajout du HTML entities pour éviter les failles XSS GET REKT 
  echo ("<a id='mod1' href='modif-artist.php/?id=".$artist["artist_id"]."'> Modifier cet artiste </a> <br>");
  echo ("<a id='mod1' href='supp-artist.php/?id=".$artist["artist_id"]."'> Supprimer cet artiste </a> <br>");
  echo "</section>";
}


?> 
</div>


</body>
</html>