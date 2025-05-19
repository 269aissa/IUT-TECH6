<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

// Initialisation de $recentPages avec un tableau vide par défaut
$recentPages = [];

try {
    // Récupération des pages récentes
    $stmt = $pdo->query("SELECT * FROM pages ORDER BY created_at DESC LIMIT 3");
    $recentPages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // Journalisation de l'erreur (vous pourriez aussi l'afficher en mode debug)
    error_log("Erreur de base de données: " . $e->getMessage());
    
    // Vous pourriez aussi définir un message d'erreur à afficher à l'utilisateur
    $dbError = "Désolé, nous rencontrons des difficultés techniques. Veuillez réessayer plus tard.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créez votre page de départ personnalisée</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Votre CSS personnalisé -->
    <link href="<?= ASSETS_PATH ?>/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">TheEnd.page</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="create.php">Créer une page</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">À propos</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Connexion</a></li>
                </ul>
            </div>
        </div>
    </nav>
<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Contactez-nous</h1>
                </div>
                <div class="card-body p-4">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Votre nom</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Votre email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Votre message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Envoyer le message</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card shadow mt-4">
                <div class="card-body">
                    <h2 class="h5 mb-3">Informations de contact</h2>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i> fardibacarifazati@gmail.com</li>
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i> +269 498 30 63</li>
                        <li><i class="bi bi-geo-alt me-2"></i> Hamramba, Moroni, Comores</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 IUT-TECH6 Tous droits réservés.</p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle avec Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>