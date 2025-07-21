<?php
    //Connexion à la BDD avec XAMPP
    $host = 'localhost';
    $dbname = 'exercicebibliotheque';
    $user = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
        // Active les erreurs PDO en exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        
    </body>
</html>
<?php
    if(!isset($_SESSION['user'])){
        echo '
        <form method="POST">
            <label>Nom</label>
            <br>
            <input type="text" name="nom">
            <br>
            <label>Mail</label>
            <br>
            <input type="password" name="mail">
            <br>
            <br>
            <input type="submit" name="submitConnect" value="Se connecter">
        </form>
        <p><a href="?page=createAccount">Créer un compte</a><p>
        ';    
    }
    else {
        echo '
        <form method="POST">
            <input type="submit" name="deconnexion" value="Se déconnecter">
        </form>
        ';
    }

    if(isset($_POST['submitConnect'])){
        $nom = $_POST['nom'];
        $mail = $_POST['mail'];
        
        $sql = "SELECT * FROM `utilisateurs` WHERE mailUtilisateurs = '$mail'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if($results){
            $_SESSION['user'] = [
                "id_utilisateurs" => htmlspecialchars($results[0]["id_utilisateurs"]),
                "nomUtilisateurs" => htmlspecialchars($results[0]["nomUtilisateurs"]),
                "prenomUtilisateurs	" => htmlspecialchars($results[0]["prenomUtilisateurs"]),
                "mailUtilisateurs" => htmlspecialchars($results[0]["mailUtilisateurs"]),
            ];
            /*
            $id = $_GET['id'];
            $sqlId = "SELECT * FROM users WHERE id_user = '$id'";
            $stmtId = $pdo->prepare($sqlId);
            $stmtId->execute();
            $resultsId = $stmtId->fetchAll(PDO::FETCH_ASSOC);
            */
            var_dump($_SESSION);
        }
        else{
            echo "Mot de passe incorrect";
        }

    }        


    if(isset($_POST['deconnexion'])){
            session_destroy();
            header("Location: index.php");
    }

?>