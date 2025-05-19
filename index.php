<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Déconnexion automatique à chaque retour sur la page index
session_start();
session_unset();
session_destroy();
require_once 'includes/functions.php';

// Initialisation de $recentPages avec un tableau vide par défaut
$recentPages = [];

try {
    // Récupération des pages récentes
    $stmt = $pdo->query("SELECT * FROM pages ORDER BY created_at DESC LIMIT 10");
    $recentPages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // Journalisation de l'erreur (vous pourriez aussi l'afficher en mode debug)
    error_log("Erreur de base de données: " . $e->getMessage());
    
    // Vous pourriez aussi définir un message d'erreur à afficher à l'utilisateur
    $dbError = "Désolé, nous rencontrons des difficultés techniques. Veuillez réessayer plus tard.";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['page_id'])) {
    $pageId = intval($_POST['page_id']);
    // Incrémenter le nombre de likes pour la page correspondante
    $stmt = $pdo->prepare("UPDATE pages SET liker = liker + 1 WHERE id = ?");
    $stmt->execute([$pageId]);
    // Rediriger vers la page d'accueil après le like
    header('Location: index.php');
    exit;
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
        <?php if(isset($dbError)): ?>
            <div class="alert alert-danger"><?= $dbError ?></div>
        <?php endif; ?>
        
        <section class="hero text-center py-5 bg-white rounded shadow-sm">
            <h1 class="display-4 mb-4">Créez une page d'adieu mémorable</h1>
            <p class="lead mb-4">Personnalisez votre départ avec des messages, des thèmes et des animations uniques.</p>
            <a href="create.php" class="btn btn-primary btn-lg px-4">Commencer maintenant</a>
        </section>

        <section class="examples mt-5">
            <h2 class="text-center mb-4">Exemples récents</h2>
            <!-- Les modifications demandées sont appliquées ci-dessous -->
            <?php if(!empty($recentPages)): ?>
                <div class="row g-4">
                    <?php foreach($recentPages as $page): ?>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body" style="background-color: <?= htmlspecialchars($page['bg_color']) ?>;">
                                <h3 class="card-title h5"><?= htmlspecialchars($page['title']) ?></h3>
                                <p class="card-text"><?= substr(htmlspecialchars($page['message']), 0, 100) ?>...</p>
                            </div>
                            <div class="card-footer bg-white">
                                <a href="preview.php?id=<?= $page['id'] ?>" class="btn btn-sm btn-outline-primary">Voir la page</a>
                                <div class="mt-2">
                                    <span class="badge rounded-pill" style="background-color: <?= htmlspecialchars($page['bg_color']) ?>;">
                                        <?= htmlspecialchars($page['bg_color']) ?>
                                    </span>
                                </div>
                                <form action="index.php" method="post" class="d-inline ms-2">
                                    <input type="hidden" name="page_id" value="<?= $page['id'] ?>">
                                    <?php
                                    // Trouver le nombre maximum de likes parmi les pages récentes
                                    $maxLikes = 0;
                                    foreach ($recentPages as $p) {
                                        if (isset($p['liker']) && $p['liker'] > $maxLikes) {
                                            $maxLikes = $p['liker'];
                                        }
                                    }
                                    ?>
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        <?php if (isset($page['liker']) && $page['liker'] == $maxLikes && $maxLikes > 0): ?>
                                            👑
                                        <?php endif; ?>
                                        👍 <span><?= isset($page['liker']) ? $page['liker'] : 0 ?></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    Aucune page récente à afficher pour le moment. Soyez le premier à créer une page!
                </div>
            <?php endif; ?>
        </section>
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