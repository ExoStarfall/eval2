<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer le style</title>
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
  </style>
<?php
include('confdb.php');
if (isset($_GET['id']) and is_numeric($_GET['id'])){
    
    $style_id = htmlspecialchars($_GET['id']);
    $connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);

    //récupérer les infos du film
    $requete = "SELECT * FROM `styles` WHERE `style_id`=:style_id";
    $prepare = $connexion->prepare($requete);
    $prepare->execute(array(
        "style_id"=> $style_id
    ));
    $prepare = $prepare->fetch();

    echo("
        <h1>Supprimer ce style?</h1>
        <div class='style'>
        <form method='POST' action='supp-style.php?id=".$prepare['style_id']."'>
        <label for='style'>Style:</label>
        <input type='text' id='style' name='style' value='".$prepare['style_name']."' required>
        
        <input type='hidden' name='id_style' value='".$prepare['style_id']."'>
        <input type='submit' value='Supprimer'> <br>
        
        <a href='../index.php'>Retour au site </a>
        </form>
        </div>
    ");
}


 if (isset($_POST['style'])) {
    
    $connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
    $style_id = htmlspecialchars($_POST['id_style']); 
try {

$requete = "DELETE FROM `styles` WHERE `style_id`=:style_id";
$prepare = $connexion->prepare($requete);
$prepare->execute(array(
     ":style_id"=> $style_id
  
    

));
$res = $prepare->rowCount();

if ($res == 1) {
echo "<p>Style supprimé!</p>";

}
} catch (PDOException $e) {
exit( "OOPS :\n" . $e->getMessage());
}
}

?>
</body>
</html>