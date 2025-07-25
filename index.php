<?php
    session_start();

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
        <title>Bibliothèque</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
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
                echo "<h2>Bonjour, " . $_SESSION['user']['nomUtilisateurs'] . " " . $_SESSION['user']['prenomUtilisateurs'] . ". Vous êtes connecté</h2>";
                $sql = "SELECT livres.idLivres AS 'ID', nomLivres AS 'Nom du livre', nomEcrivains AS 'Nom de l\'écrivain', prenomEcrivains AS 'Prénom de l\'écrivain', dispoLivres AS 'Disponibilité'  FROM `livres`
                        INNER JOIN ecrire ON livres.idLivres = ecrire.idLivres
                        INNER JOIN ecrivains ON ecrire.id_ecrivains = ecrivains.id_ecrivains";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo "<div class=gridLivre>";
                foreach ($results as $key => $value) {
                    echo "<div>";
                    foreach ($value as $key2 => $value2) {
                        if ($key2 == "Disponibilité"){
                            if ($value2 == 1){
                                echo "$key2: Disponible";
                            }
                            else {
                                echo "$key2: Indisponible";
                            }
                            break;
                        }
                        if ($key2 == "ID"){
                            $idASupprimer = $value2;
                        }
                        else {
                            echo "$key2: $value2";
                            echo "<br>";
                        }
                    }
                    echo "<form method='POST'>";
                    echo '<a href="index.php?id=' . $idASupprimer . '">Modifier</a>';
                    echo "</form>";
                    

                    $sql = "SELECT * FROM livres";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $resultsAll = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($resultsAll as $key => $value) {
                        $idASupprimer = $value['idLivres'];
                        break;
                    }
                    echo "</div>";
                }
                echo "</div>";
                echo '
                <br><form method="POST">
                    <input type="submit" name="deconnexion" value="Se déconnecter">
                </form>
                ';
                echo "<hr>";
                $idUser = $_SESSION['user']['id_utilisateurs'];
                $sqlUser = "SELECT nomLivres AS 'Nom du livre', dateEmprunts AS 'Date de l\'emprunts', renduEmprunts AS 'Rendu' FROM `emprunts` 
                            INNER JOIN livres ON emprunts.id_livres = livres.idLivres
                            WHERE id_utilisateurs = $idUser";
                $stmtUser = $pdo->prepare($sqlUser);
                $stmtUser->execute();
                $resultsUser = $stmtUser->fetchAll(PDO::FETCH_ASSOC);
                if ($resultsUser){
                    echo "<div class=flex>";
                    foreach ($resultsUser as $key=>$value){
                        echo "<div class=cell>";
                        foreach($value as $key2=>$value2){
                            if ($key2 == 'Rendu') {
                                if ($value2 == 1) {
                                    echo "Rendu";
                                }
                                else {
                                    echo "Pas encore rendu";
                                }
                            }
                            else {
                                echo $key2.': '.$value2;
                            }
                            echo '<br>';
                            
                        }
                        echo '</div>';
                    }
                    echo '</div>';

                }
                else {
                    echo "Vous n'avez encore prêté aucun livre !";
                }
            }
            
            if(isset($_POST['submitConnect'])){
                $nom = $_POST['nom'];
                $mail = $_POST['mail'];
                
                $sql = "SELECT * FROM `utilisateurs` WHERE mailUtilisateurs = '$mail' AND nomUtilisateurs = '$nom'";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($results){
                    $_SESSION['user'] = [
                        "id_utilisateurs" => htmlspecialchars($results[0]["id_utilisateurs"]),
                        "nomUtilisateurs" => htmlspecialchars($results[0]["nomUtilisateurs"]),
                        "prenomUtilisateurs" => htmlspecialchars($results[0]["prenomUtilisateurs"]),
                        "mailUtilisateurs" => htmlspecialchars($results[0]["mailUtilisateurs"])
                    ];
                    header("Location: index.php");
                }
                else{
                    echo "Mot de passe incorrect";
                }

            }        


            if(isset($_POST['deconnexion'])){
                    session_destroy();
                    header("Location: index.php");
            }
            
            if(isset($_GET['id'])){
                $idToUpdate = $_GET['id'];
                $user = $_SESSION['user']['id_utilisateurs'];
                $sqlSearch = "SELECT * FROM livres WHERE idLivres = $idToUpdate";
                $stmtSearch = $pdo->prepare($sqlSearch);
                $stmtSearch->execute();
                $resultsSearch = $stmtSearch->fetchAll(PDO::FETCH_ASSOC);
                $disponibilité = $resultsSearch[0]['dispoLivres'];
                $jour = date("d-m-Y");
                
                    

                if ($disponibilité == 1){
                    $sqlUpdate = "UPDATE `livres` SET `dispoLivres`='0' WHERE idLivres = $idToUpdate";
                    $stmtUpdate = $pdo->prepare($sqlUpdate);
                    $stmtUpdate->execute();
                    $sqlInsert = "INSERT INTO `emprunts`(`dateEmprunts`, `id_utilisateurs`, `id_livres`) VALUES ('$jour','$user','$idToUpdate')";
                    $stmtInsert = $pdo->prepare($sqlInsert);
                    $stmtInsert->execute();
                }
                else {
                    $sqlVerif = "SELECT * FROM `Emprunts` WHERE id_utilisateurs = '$user' AND renduEmprunts IS NULL AND id_livres = $idToUpdate";
                    $stmtVerif = $pdo->prepare($sqlVerif);
                    $stmtVerif->execute();
                    $resultsVerif = $stmtVerif->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($resultsVerif as $key=>$value){
                        $emprunts = $value;
                        foreach ($emprunts as $key2=>$value2){
                            if ($key2 == 'id_livres') {
                                $livre = $value2;
                            }
                        }
                        echo "<br>";
                    }
                    if ($livre == $idToUpdate){
                        $sqlUpdate = "UPDATE `livres` SET `dispoLivres`='1' WHERE idLivres = $idToUpdate";
                        $stmtUpdate = $pdo->prepare($sqlUpdate);
                        $stmtUpdate->execute();
                        $sqlInsert = "UPDATE `emprunts` SET `renduEmprunts`='1' WHERE id_livres = $idToUpdate AND id_utilisateurs = $user";
                        $stmtInsert = $pdo->prepare($sqlInsert);
                        $stmtInsert->execute();
                    }
                }
                header("Location: index.php");
            }
            if (isset($_GET['page']) && ($_GET['page'] == 'createAccount')){
                echo '
                <form method="POST">
                    <label for="">Nom</label>
                    <input type="text" name="nomCreate" required>
                    <br>
                    <label for="">Prenom</label>
                    <input type="text" name="prenomCreate" required>
                    <br>
                    <label for="">Mail</label>
                    <input type="text" name="mailCreate" required>
                    <br>
                    <input type="submit" name="submitCreate" value="Créer mon compte">
                </form>
                ';
            }
            if (isset($_POST['submitCreate'])){
                $nomCreate = $_POST['nomCreate'];
                $prenomCreate = $_POST['prenomCreate'];

                $mailCreate = $_POST['mailCreate'];

                $sqlCreate = "INSERT INTO `utilisateurs`(`nomUtilisateurs`, `prenomUtilisateurs`, `mailUtilisateurs`) VALUES (:nom,:prenom,:mail)";
                $stmtCreate = $pdo->prepare($sqlCreate);

                $stmtCreate->bindParam(':nom', $nomCreate);
                $stmtCreate->bindParam(':prenom', $prenomCreate);
                $stmtCreate->bindParam(':mail', $mailCreate);

                $stmtCreate->execute();
                header("Location: index.php");
            }
        ?>
    </body>
</html>
