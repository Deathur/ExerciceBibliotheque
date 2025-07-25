# ExerciceBibliotheque

Contexte
Une bibliothèque souhaite une application de gestion de ses livres et des emprunts. Elle doit pouvoir gérer :
les livres (titre, auteur, année, genre…)
les écrivains
les genres littéraires
les utilisateurs
les emprunts (qui emprunte quoi et quand)

Vous êtes chargés de concevoir et de développer cette application.

Travail à réaliser
Modélisation (BDD)
Réalisez le MCD du système en vous appuyant sur les entités (tables) suivantes : livres, ecrivains, genres, utilisateurs, emprunts.
Rédigez le script SQL de création de la base de données avec les clés primaires, étrangères, contraintes et types adaptés.

Développement web (PHP/PDO)
Créez une interface simple permettant d’effectuer les opérations suivantes :

Livres
Lister tous les livres avec leur auteur et leur genre
Ajouter un nouveau livre
Modifier un livre
Supprimer un livre
Afficher si le livre est disponible ou non

Écrivains
Gérer (CRUD) les écrivains (nom, prénom, nationalité)
Associer un livre à un écrivain

Genres
Gérer les genres (CRUD)

Utilisateurs
Gérer les utilisateurs (CRUD) -- Id nom prenom email

Emprunts
Enregistrer un emprunt (sélection du livre et de l’utilisateur, date du jour)
Marquer un emprunt comme rendu
Afficher l’historique des emprunts d’un utilisateur
Empêcher l’emprunt d’un livre déjà emprunté

Contraintes techniques
Utilisation exclusivement de PDO pour les interactions avec la base de données
Sécurité : utilisez des requêtes préparées
Ne vous attardez pas sur le CSS. C’est la dernière chose à faire sur le projet


Livrables
Le script SQL de création de la base (exporter le sql quand la bdd est finie)
Le code source PHP
Le MCD

Le tout à envoyer sur Github