<?php
session_start();
require_once '../configuration/env.php';
require_once '../vendor/autoload.php';

<<<<<<< HEAD
use Mailgun\Mailgun;
=======
require_once '../classes/admin.php';
require_once '../template/header.php';
>>>>>>> 9f9c0c573ce0135f9bdefdb57e5159c2e1483a67

if ($_SESSION['role'] !=1) {
    $_SESSION['message'] = 'Accès refusé. Vous devez être administrateur pour accéder à cette page.';
    $_SESSION['message_type'] = 'danger';
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'creer') {
        $username = htmlspecialchars($_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $role_id = (int)$_POST['role_id'];

        try {
            $stmt = $bdd->prepare('INSERT INTO utilisateurs (username, password, nom, prenom, role_id) VALUES (:username, :password, :nom, :prenom, :role_id)');
            $stmt->execute([
                ':username' => $username,
                ':password' => $password,
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':role_id' => $role_id
            ]);

              // Envoi de l'email de notification
              $apiKey = getenv('MAILGUN_API_KEY');
              $domain = getenv('MAILGUN_DOMAIN');
              $mgClient = Mailgun::create($apiKey);
  
              $mgClient->messages()->send($domain, [
                  'from'    => 'employearcadia@gmail.com',
                  'to'      => $username,
                  'subject' => 'Votre compte a été créé',
                  'text'    => "Bonjour $prenom $nom,\n\nVotre compte a été créé avec succès. Veuillez contacter l'administrateur pour obtenir votre mot de passe.\n\nCordialement,\nL'équipe Arcadia"
              ]);

            $_SESSION['message'] = 'Utilisateur créé avec succès.';
            $_SESSION['message_type'] = 'success';
        } catch (Exception $e) {
            $_SESSION['message'] = 'Erreur lors de la création de l\'utilisateur : ' . $e->getMessage();
            $_SESSION['message_type'] = 'danger';
        }
    } elseif ($action === 'modifier') {
        $username = htmlspecialchars($_POST['username']);
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $role_id = (int)$_POST['role_id'];
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;

        try {
            if ($password) {
                $stmt = $bdd->prepare('UPDATE utilisateurs SET nom = :nom, prenom = :prenom, role_id = :role_id, password = :password WHERE username = :username');
                $stmt->execute([
                    ':nom' => $nom,
                    ':prenom' => $prenom,
                    ':role_id' => $role_id,
                    ':password' => $password,
                    ':username' => $username
                ]);
            } else {
                $stmt = $bdd->prepare('UPDATE utilisateurs SET nom = :nom, prenom = :prenom, role_id = :role_id WHERE username = :username');
                $stmt->execute([
                    ':nom' => $nom,
                    ':prenom' => $prenom,
                    ':role_id' => $role_id,
                    ':username' => $username
                ]);
            }

            $_SESSION['message'] = 'Utilisateur modifié avec succès.';
            $_SESSION['message_type'] = 'success';
        } catch (Exception $e) {
            $_SESSION['message'] = 'Erreur lors de la modification de l\'utilisateur : ' . $e->getMessage();
            $_SESSION['message_type'] = 'danger';
        }
    } elseif ($action === 'supprimer') {
        $username = htmlspecialchars($_POST['username']);

        try {
            $stmt = $bdd->prepare('DELETE FROM utilisateurs WHERE username = :username');
            $stmt->execute([':username' => $username]);

            $_SESSION['message'] = 'Utilisateur supprimé avec succès.';
            $_SESSION['message_type'] = 'success';
        } catch (Exception $e) {
            $_SESSION['message'] = 'Erreur lors de la suppression de l\'utilisateur : ' . $e->getMessage();
            $_SESSION['message_type'] = 'danger';
        }
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Récupération des utilisateurs existants
$query = 'SELECT * FROM utilisateurs';
$utilisateurs = $bdd->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <header>
        <nav>
            <img src="../assets/Logo/logo arcadia sans fond.png" alt="Logo du zoo Arcadia" class="logo_arcadia">
            <ul>
                <li><a href="../index.php">Accueil</a></li>
                <li><a href="page_services.php">Services</a></li>
                <li><a href="page_habitats.php">Habitats</a></li>
                <li><a href="avis.php">Vos avis</a></li>
            </ul>
            <?php if (isset($_SESSION['role'])): ?>
                <form method="POST" action="deconnexion.php">
                    <button type="submit" class="btn_deconnexion">Déconnexion</button>
                </form>
            <?php else: ?>
                <a href="connexion_utilisateur.php" class="btn_connexion">
                    <i class="fa-solid fa-right-to-bracket"></i> Espace employé
                </a>
            <?php endif; ?>
        </nav>
    </header>
    <style>
        .mt-150 {
            margin-top: 150px;
        }
    </style>
    <div class="container mt-150">
        <h2 class="text-center mb-4">Gestion des Utilisateurs</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
        <?php endif; ?>
        <h3>Créer un nouvel utilisateur</h3>
        <form action="" method="post">
            <input type="hidden" name="action" value="creer">
            <div class="form-group">
                <label for="username">Nom d'utilisateur (e-mail) :</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="role_id">Rôle :</label>
                <select class="form-control" id="role_id" name="role_id" required>
                    <option value="2">Employé</option>
                    <option value="3">Vétérinaire</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Créer Utilisateur</button>
        </form>

        <hr>

<<<<<<< HEAD
        <h3>Liste des utilisateurs existants</h3>
        <?php if (!empty($utilisateurs)): ?>
            <?php foreach ($utilisateurs as $utilisateur): ?>
                <div class="user-card mb-3">
                    <h4><?php echo htmlspecialchars($utilisateur['prenom']) . ' ' . htmlspecialchars($utilisateur['nom']); ?></h4>
                    <p><strong>Nom d'utilisateur :</strong> <?php echo htmlspecialchars($utilisateur['username']); ?></p>
                    <p><strong>Rôle :</strong> <?php echo htmlspecialchars($utilisateur['role_id']); ?></p>
=======

>>>>>>> 9f9c0c573ce0135f9bdefdb57e5159c2e1483a67

                    <form action="" method="post" class="mb-3">
                        <input type="hidden" name="action" value="modifier">
                        <input type="hidden" name="username" value="<?php echo htmlspecialchars($utilisateur['username']); ?>">
                        <div class="form-group">
                            <label for="username_<?php echo htmlspecialchars($utilisateur['username']); ?>">Nom d'utilisateur (e-mail) :</label>
                            <input type="text" class="form-control" id="username_<?php echo htmlspecialchars($utilisateur['username']); ?>" name="username" value="<?php echo htmlspecialchars($utilisateur['username']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password_<?php echo htmlspecialchars($utilisateur['username']); ?>">Nouveau mot de passe (laisser vide pour ne pas changer) :</label>
                            <input type="password" class="form-control" id="password_<?php echo htmlspecialchars($utilisateur['username']); ?>" name="password">
                        </div>
                        <div class="form-group">
                            <label for="nom_<?php echo htmlspecialchars($utilisateur['username']); ?>">Nom :</label>
                            <input type="text" class="form-control" id="nom_<?php echo htmlspecialchars($utilisateur['username']); ?>" name="nom" value="<?php echo htmlspecialchars($utilisateur['nom']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom_<?php echo htmlspecialchars($utilisateur['username']); ?>">Prénom :</label>
                            <input type="text" class="form-control" id="prenom_<?php echo htmlspecialchars($utilisateur['username']); ?>" name="prenom" value="<?php echo htmlspecialchars($utilisateur['prenom']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="role_id_<?php echo htmlspecialchars($utilisateur['username']); ?>">Rôle :</label>
                            <select class="form-control" id="role_id_<?php echo htmlspecialchars($utilisateur['username']); ?>" name="role_id" required>
                                <option value="2" <?php echo $utilisateur['role_id'] == 2 ? 'selected' : ''; ?>>Employé</option>
                                <option value="3" <?php echo $utilisateur['role_id'] == 3 ? 'selected' : ''; ?>>Vétérinaire</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </form>

                    <form action="" method="post">
                        <input type="hidden" name="action" value="supprimer">
                        <input type="hidden" name="username" value="<?php echo htmlspecialchars($utilisateur['username']); ?>">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun utilisateur trouvé.</p>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>