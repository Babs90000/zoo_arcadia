    # Gestion des Services

## Description

Ce projet est une application web de gestion des services. Il permet aux administrateurs de créer, modifier et supprimer des services. Les utilisateurs peuvent également consulter la liste des services disponibles.

## Fonctionnalités

- **Création de services** : Les administrateurs peuvent ajouter de nouveaux services en fournissant un nom et une description.
- **Modification de services** : Les administrateurs peuvent modifier les détails des services existants.
- **Suppression de services** : Les administrateurs peuvent supprimer des services.
- **Consultation des services** : Les utilisateurs peuvent consulter la liste des services disponibles.

## Prérequis


### Technologies utilisées
- *Frontend* : HTML, CSS, JavaScript
- *Backend* : PHP
- *Base de données* : MySQL
- *Serveur web* : Apache

- PHP 7.0 ou supérieur
- Serveur web (Apache, Nginx, etc.)
- Base de données MySQL

## Installation

1. Clonez le dépôt sur votre machine locale :
    ```bash
    git clone https://github.com/votre-utilisateur/votre-repo.git
    ```

2. Accédez au répertoire du projet :
    ```bash
    cd votre-repo
    ```

3. Importez la base de données MySQL :
    - Créez une base de données nommée `arcadia`.
    - Importez le fichier `arcadia.sql` dans votre base de données MySQL.

4. Configurez la connexion à la base de données dans le fichier `config.php` :
    ```php
    <?php
    $bdd = new PDO('mysql:host=localhost;dbname=arcadia', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    ?>
    ```

5. Démarrez votre serveur web et accédez à l'application via votre navigateur.

## Utilisation

1. Connectez-vous en tant qu'administrateur pour accéder aux fonctionnalités de gestion des services.
2. Utilisez le formulaire de création pour ajouter de nouveaux services.
3. Modifiez ou supprimez des services existants à partir de la liste des services.

## Structure du Projet

- `gestion_service.php` : Fichier principal pour la gestion des services.
- `config.php` : Fichier de configuration pour la connexion à la base de données.
- `arcadia.sql` : Fichier SQL pour créer et peupler la base de données.
- `assets/` : Répertoire contenant les fichiers CSS, JS et autres ressources.

## Technologies Utilisées

- PHP
- MySQL
- Bootstrap (pour le style)
- FontAwesome (pour les icônes)

## Auteur

- Votre Nom
- [Votre Email](mailto:votre.email@example.com)
- [Votre GitHub](https://github.com/votre-utilisateur)

## Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails."# arcadia" 
