<?php
include('confdb.php'); //Coucou la db 
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'artiste</title>

</head>

<body>
    <style>
        /*J'ai essayé de link mon CSS ça voulait pas marcher... alors je le pose ici */
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
    // Requête de sélection qui va nous permettre de récupérer les infos du form 
    $connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
    $requete = "SELECT * FROM `artist` WHERE `artist_id`=:artist_id";
    $prepare = $connexion->prepare($requete);
    $artist_id = htmlspecialchars($_GET['id']); // C'est inutile en soi mais ça m'est utile à moi pour utiliser une variable

    $prepare->execute(array(
        ":artist_id" => $artist_id

    ));
    $prepare = $prepare->fetch();

    echo ("
     <h1>Modifier cet artiste</h1>
     <div class='artist'>
     <form method='POST' action='modif-artist.php?id=" . $prepare['artist_id'] . "'> 
     <label for='info_style'>Artiste:</label>
     <input type='text' id='artist' name='artist' value='" . $prepare['artist_name'] . "'>
     <input type='submit'  name='valider' value='Valider'> <br>
   
     <a href='../index.php'>Retour au site </a>
     </div>
 ");
    if (isset($_POST['valider'])) { // Si on valide il se passera tout ce qu'il y a en dessous
        $artist = htmlspecialchars($_POST['artist']); // Je redéfinis ici pour eviter le 'Undefined variable'
        $artist_id = htmlspecialchars($_GET['id']);




        try {
            // Notre requête de modification dans un petit try/catch pour la gestion d'erreurs
            $connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
            $requete = "UPDATE `artist`  
                SET `artist_name`=:artist_name
                    
                    
                WHERE `artist_id`=:artist_id";
            $prepare = $connexion->prepare($requete); // Quand la requête est préparée on dodge les injections SQL 
            $prepare->execute(array(
                ":artist_name" => $artist,
                ":artist_id" => $artist_id



            ));
            $res = $prepare->rowCount();

            if ($res == 1) {
                echo "<p>Modifications enregistrées!</p>"; // Si ça a marché faut prévenir quand même 
            }
        } catch (PDOException $e) {
            exit("OOPS :\n" . $e->getMessage());
        }
    }

    ?>
</body>

</html>