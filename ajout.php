<?php
    $host = 'localhost';
    $dbname = 'exercicebibliotheque';
    $user = 'root';
    $password = '';

    try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    // Active les erreurs PDO en exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<script>console.log('Connexion réussi !');</script>";
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ajout bibliothèque</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <p><a href="index.php">Retour connexion utilisateur</a></p>
        <hr>
        <p>Ajout d'écrivains</p>
        <form method='POST'>
            <label for="">Nom</label>
            <input type="text" name="NomEcrivain">
            <label for="">Prénom</label>
            <input type="text" name="PrenomEcrivain">
            <label for="">Nationalité</label>
            <input type="text" name="NationalitéEcrivain">
            <input type="submit" name="ecrivainSubmit">
            
        </form>
        <?php
        if (isset($_POST['ecrivainSubmit'])){
            $NomEcrivain = $_POST['NomEcrivain'];
            $PrenomEcrivain = $_POST['PrenomEcrivain'];
            $NationalitéEcrivain = $_POST['NationalitéEcrivain'];
            $sql = "INSERT INTO `ecrivains`(`nomEcrivains`, `prenomEcrivains`, `nationalitéEcrivains`) VALUES ('$NomEcrivain','$PrenomEcrivain','$NationalitéEcrivain')";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }
        ?>
        <hr>
        <p>Ajout Genre du livre</p>
        <form method="POST">
            <label for="">Genre</label>
            <input type="text" name="livreGenre">
            <input type="submit" name="GenreSubmit">
        </form>
        <?php
            if (isset($_POST['GenreSubmit'])){
                $livreGenre = $_POST['livreGenre'];
                $sqlGenre = "INSERT INTO `genres`(`nomGenres`) VALUES ('$livreGenre')";
                $stmtGenre = $pdo->prepare($sqlGenre);
                $stmtGenre->execute();
                $resultsGenre = $stmtGenre->fetchAll(PDO::FETCH_ASSOC);
            }
        ?>
        <hr>
        <form method="POST">
            <p>Ajout livres</p>
            <label for="">Nom du livre</label>
            <input type="text" name="NomLivre">
            <label for="">Année de publication</label>
            <input type="text" name="anneeLivre">
            <input type="submit" name="livreSubmit">
        </form>
        <?php
            if (isset($_POST['livreSubmit'])){
                $NomLivre = htmlspecialchars($_POST['NomLivre']);
                $anneeLivre = $_POST['anneeLivre'];
                
                $sqlGenre = "INSERT INTO `livres`(`nomLivres`, `annee`, `dispoLivres`) VALUES ('$NomLivre','$anneeLivre', '1')";
                $stmtGenre = $pdo->prepare($sqlGenre);
                $stmtGenre->execute();
                $resultsGenre = $stmtGenre->fetchAll(PDO::FETCH_ASSOC);
            }
        ?>
        <hr>
        <p>Liaison Écrivain/Livres</p>
        <form method="POST">
            <select name="Livres">
                <?php
                $sqlLivres = "SELECT * FROM livres";
                $stmtLivres = $pdo->prepare($sqlLivres);
                $stmtLivres->execute([]);
                foreach ($stmtLivres as $key => $value) {
                    echo "<option value=\"$value[idLivres]\">$value[nomLivres]</option>";
                }
                ?>
            </select>
            <select name="Ecrivains">
                <?php
                $sqlLivres = "SELECT * FROM ecrivains";
                $stmtLivres = $pdo->prepare($sqlLivres);
                $stmtLivres->execute([]);
                foreach ($stmtLivres as $key => $value) {
                    echo "<option value=\"$value[id_ecrivains]\">$value[nomEcrivains]</option>";
                }
                ?>
            </select>
            <select name="Genre">
                <?php
                $sqlLivres = "SELECT * FROM genres";
                $stmtLivres = $pdo->prepare($sqlLivres);
                $stmtLivres->execute([]);
                foreach ($stmtLivres as $key => $value) {
                    echo "<option value=\"$value[id_genres]\">$value[nomGenres]</option>";
                }
                ?>
            </select>
            <input type="submit" name="submitLink">
        </form>
            <?php
                if (isset($_POST['submitLink'])){
                    $Livres = $_POST['Livres'];
                    $Ecrivains = $_POST['Ecrivains'];
                    $Genre = $_POST['Genre'];
                    $sqlLiaison = "INSERT INTO `ecrire`(`idLivres`, `id_ecrivains`) VALUES ('$Livres','$Ecrivains')";
                    $stmtLiaison = $pdo->prepare($sqlLiaison);
                    $stmtLiaison->execute();
                    $sqlLiaison = "INSERT INTO `appartient`(`id_livres`, `id_genres`) VALUES ('$Livres','$Genre')";
                    $stmtLiaison = $pdo->prepare($sqlLiaison);
                    $stmtLiaison->execute();
                }
            ?>
        <hr>
        <?php
            $sqlAll = "SELECT livres.idLivres, nomLivres as 'Nom du livre', nomEcrivains as 'Nom de l\'écrivain', prenomEcrivains as 'Prénom de l\'écrivain', nomGenres as 'Genre' FROM `livres`
                INNER JOIN appartient ON livres.idLivres = appartient.id_livres
                INNER JOIN genres ON appartient.id_genres = genres.id_genres
                INNER JOIN ecrire ON livres.idLivres = ecrire.idLivres
                INNER JOIN ecrivains ON ecrire.id_ecrivains = ecrivains.id_ecrivains";
            $stmtAll = $pdo->prepare($sqlAll);
            $stmtAll->execute();
            $resultsAll = $stmtAll->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultsAll as $key=>$value){
                $idASupprimer = $value['idLivres'];
                echo "<form method='POST'>";
                echo "<input type=\"hidden\" name=\"idDelete\" value='$idASupprimer'><br>";
                foreach($value as $key2=>$value2){
                    if ($key2 !== "idLivres"){
                        echo $key2.": ".$value2;
                        echo '<br>';
                    }
                }
                echo '<a href="ajout.php?id=' . $idASupprimer . '">Modifier</a><br>';
                echo "<input type=\"submit\" name=\"submitDelete\" value=\"supprimer\"><br>";
                echo "</form>";
                echo '<br>';
            }
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                $sqlId = "SELECT * FROM livres WHERE idLivres = '$id'";

                $stmtId = $pdo->prepare($sqlId);
                $stmtId->execute();
                
                $resultsId = $stmtId->fetchAll(PDO::FETCH_ASSOC);
                echo '<form method="POST">
                <label for="">Nom du livre</label>
                <input type="text" name="nomLivresUpdate" value="' . htmlspecialchars_decode($resultsId[0]['nomLivres']) . '">
                <br>
                <label for="">Année</label>
                <input type="text" name="anneeUpdate" value="' . htmlspecialchars_decode($resultsId[0]['annee']) . '">
                <br>
                <label for="">Auteur</label>
                <select name=ecrivainChoiceUpdate>
                ';
                
                $sqlLivres = "SELECT * FROM ecrivains";
                $stmtLivres = $pdo->prepare($sqlLivres);
                $stmtLivres->execute([]);
                foreach ($stmtLivres as $key => $value) {
                    echo "<option value=\"$value[id_ecrivains]\">$value[nomEcrivains]</option>";
                }
                echo '
                </select>
                <br>
                <label for="">Genre</label>
                <select name="genreChoiceUpdate">
                ';
                $sqlLivres = "SELECT * FROM genres";
                $stmtLivres = $pdo->prepare($sqlLivres);
                $stmtLivres->execute([]);
                foreach ($stmtLivres as $key => $value) {
                    echo "<option value=\"$value[id_genres]\">$value[nomGenres]</option>";
                }
                echo '
                </select>
                <br>
                <input type="submit" name="submitUpdate" Value="Mettre à jour la BDD">
                <input type="submit" name="submitAnnule" Value="Annuler">
                </form>
                '
                ;
                
            }
            if (isset($_POST['submitUpdate'])){
                $idUpdate = $_GET['id'];
                $nomLivresUpdate = htmlspecialchars($_POST['nomLivresUpdate']);
                $anneeUpdate = $_POST['anneeUpdate'];
                $ecrivainUpdate = $_POST['ecrivainChoiceUpdate'];
                $genreUpdate = $_POST['genreChoiceUpdate'];
                echo $idUpdate." ".$nomLivresUpdate." ".$ecrivainUpdate." ".$genreUpdate;
                
                $sqlUpdate = "UPDATE `livres` SET `nomLivres`='$nomLivresUpdate',`annee`='$anneeUpdate' WHERE idLivres = '$idUpdate'";
                $stmtUpdate = $pdo->prepare($sqlUpdate);
                $stmtUpdate->execute();
                $sqlUpdate = "UPDATE `ecrire` SET `id_ecrivains`='$ecrivainUpdate' WHERE idLivres = '$idUpdate'";
                $stmtUpdate = $pdo->prepare($sqlUpdate);
                $stmtUpdate->execute();
                $sqlUpdate = "UPDATE `appartient` SET `id_genres`='$genreUpdate' WHERE id_livres = '$idUpdate'";
                $stmtUpdate = $pdo->prepare($sqlUpdate);
                $stmtUpdate->execute();
                header("Location: ajout.php");
                
                
            }
            if(isset($_POST['submitDelete'])){
                $idToDelete = $_POST['idDelete'];
                $sqlDelete = "DELETE FROM `emprunts` WHERE id_livres = '$idToDelete'";
                $stmt = $pdo->prepare($sqlDelete);
                $stmt->execute();
                $sqlDelete = "DELETE FROM `ecrire` WHERE idLivres = '$idToDelete'";
                $stmt = $pdo->prepare($sqlDelete);
                $stmt->execute();
                $sqlDelete = "DELETE FROM `appartient` WHERE id_livres = '$idToDelete'";
                $stmt = $pdo->prepare($sqlDelete);
                $stmt->execute();
                $sqlDelete = "DELETE FROM `livres` WHERE idLivres = '$idToDelete'";
                $stmt = $pdo->prepare($sqlDelete);
                $stmt->execute();
                header("Location: ajout.php");
            }
            if(isset($_POST['submitAnnule'])){
                header("Location: ajout.php");
            }
        ?>
    </body>
</html>