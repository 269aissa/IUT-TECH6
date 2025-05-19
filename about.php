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
                    <h1 class="h4 mb-0">À propos de TheEnd.page</h1>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="assets/images/logo2.PNG" alt="Logo" class="img-fluid" style="max-height: 150px;">
                    </div>
                    
                    <h2 class="h5 mb-3">Notre mission</h2>
                    <p class="mb-4">TheEnd.page permet de créer des pages d'adieu personnalisées pour marquer les départs importants : retraite, démission, changement de vie, etc.</p>
                    
                    <h2 class="h5 mb-3">Fonctionnalités</h2>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h3 class="h6"><i class="bi bi-palette text-primary me-2"></i> Personnalisation</h3>
                                    <p class="small mb-0">Choix de thèmes, couleurs et musiques pour chaque occasion.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h3 class="h6"><i class="bi bi-emoji-smile text-primary me-2"></i> Animations</h3>
                                    <p class="small mb-0">Émojis dynamiques qui s'adaptent au thème choisi.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h2 class="h5 mb-3">L'équipe</h2>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="text-center">
                                <div  >
                                    <img src="assets/images/team1.JPG" alt="Membre de l'équipe" class="rounded-circle p-3 mb-2 mx-auto" style="width: 200px; height: 200px;">
                                    <i class="bi bi-person-fill text-primary" style="font-size: 3rem;"></i>
                                </div>
                                <h3 class="h6 mb-1">Fazati Bacari</h3>
                                <p class="small text-muted">Fondatrice</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <div  >
                                    <img src="assets/images/team2.JPG" alt="Membre de l'équipe" class="rounded-circle p-3 mb-2 mx-auto" style="width: 200px; height: 200px;">
                                    <i class="bi bi-person-fill text-primary" style="font-size: 3rem;"></i>
                                </div>
                                <h3 class="h6 mb-1">Toumlat Abdoulatuf</h3>
                                <p class="small text-muted">Designer</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <div  >
                                    <img src="assets/images/team3.JPG" alt="Membre de l'équipe" class="rounded-circle p-3 mb-2 mx-auto" style="width: 200px; height: 200px;">
                                    <i class="bi bi-person-fill text-primary" style="font-size: 3rem;"></i>
                                </div>
                                <h3 class="h6 mb-1">ISSA MOEVA Aïssa</h3>
                                <p class="small text-muted">Développeur</p>
                            </div>
                        </div>
                        <!-- Ajoutez d'autres membres de l'équipe -->
                    </div>
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