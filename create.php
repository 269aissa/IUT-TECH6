<!-- [...] (en-tête similaire à index.php) -->
<?php
// Démarrage de la session si nécessaire
// if (session_status() === PHP_SESSION_NONE) {
    session_start();
// if (!isset($_SESSION['user_id'])) {
//     // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
//     header('Location: login.php');
//     exit;
// }
// }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connexion à la base de données
    require_once 'includes/db.php'; // Assurez-vous que ce fichier contient la connexion PDO
    require_once 'includes/config.php'; // Assurez-vous que ce fichier définit $pdo (PDO)

    // Récupération et sécurisation des données du formulaire
    $title = trim($_POST['title'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $theme = $_POST['ton'] ?? 'Dramatique';
    $music = $_POST['son'] ?? 'none';
    $bg_color = $_POST['bg_color'] ?? '#ffffff';
    $user_id = $_SESSION['user_id'];

    // Validation simple (vous pouvez ajouter plus de contrôles)
    if ($title && $message && $theme && $music && $bg_color) {
        // Générer un identifiant unique pour la page (ex: UUID ou hash)
        $page_id = bin2hex(random_bytes(8));

        // Gestion de l'upload d'image
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $file_type = mime_content_type($_FILES['image']['tmp_name']);
            if (in_array($file_type, $allowed_types)) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image_name = $_FILES['image']['name'];
            $target_dir = __DIR__ . "/assets/images/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
            
            // Gestion de l'upload du son personnalisé
            $music_path = null;
            if (isset($_FILES['son']) && $_FILES['son']['error'] === UPLOAD_ERR_OK) {
                $allowed_audio_types = ['audio/mpeg', 'audio/mp3', 'audio/wav'];
                $audio_type = mime_content_type($_FILES['son']['tmp_name']);
                if (in_array($audio_type, $allowed_audio_types)) {
                    $audio_ext = pathinfo($_FILES['son']['name'], PATHINFO_EXTENSION);
                    $audio_name = uniqid('audio_') . '.' . $audio_ext;
                    $audio_dir = __DIR__ . "/assets/sounds/";
                    if (!is_dir($audio_dir)) {
                        mkdir($audio_dir, 0755, true);
                    }
                    $audio_path = $audio_dir . $audio_name;
                    if (move_uploaded_file($_FILES['son']['tmp_name'], $audio_path)) {
                        $music_path = 'assets/sounds/' . $audio_name;
                        $music = $music_path; // Remplace la valeur du champ music pour la BDD
                    }
                }
            }
            $target_path = $target_dir . $image_name;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                $image_path = 'assets/images/' . $image_name;
            }
            }
        }

        // Préparer et exécuter la requête d'insertion
        $stmt = $pdo->prepare('INSERT INTO pages ( user_id, title, message, theme, music, bg_color, created_at, img) VALUES ( ?, ?, ?, ?, ?, ?, NOW(), ?)');
        $stmt->execute([
            $user_id,
            $title,
            $message,
            $theme,
            $music,
            $bg_color,
            $image_name
            
        ]);
        echo "<script>window.location.href = 'preview.php?id=" . $pdo->lastInsertId() . "';</script>";
        exit;
        // Rediriger vers la page nouvellement créée
        header('Location: preview.php?id=' . $pdo->lastInsertId());
        exit;
    } else {
        // Vous pouvez gérer les erreurs ici (ex: afficher un message)
    }
}

// Définition des thèmes et musiques disponibles



$tones = [
    'dramatique' => 'Dramatique',
    'ironique' => 'Ironique',
    'ultra_cringe' => 'Ultra cringe',
    'classe' => 'Classe',
    'touchant' => 'Touchant',
    'absurde' => 'Absurde',
    'passif_agressif' => 'Passif-agressif',
    'honnete' => 'Honnête'
];

$musicOptions = [
    'none' => 'Aucune',
    'piano' => 'Piano doux',
    'guitar' => 'Guitare acoustique',
    'electro' => 'Électronique légère'
];

// Inclusion de l'en-tête HTML
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une page de départ - IUTTech</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">TheEnd.page</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link active" href="create.php">Créer</a></li>
            </ul>
        </div>
    </div>
</nav>
<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Créer votre page de départ</h1>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" id="departureForm" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre de la page</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                            <div class="invalid-feedback">Veuillez saisir un titre.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Message d'adieu</label>
                            <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                            <div class="invalid-feedback">Veuillez saisir un message.</div>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="theme" class="form-label">Ton</label>
                                <select class="form-select" id="theme" name="ton" required>
                                    <?php foreach($tones as $value => $label): ?>
                                        <option value="<?= $value ?>"><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-12">
                                <label for="image" class="form-label">Image (optionnelle)</label>
                                <input type="file" class="form-control" id="image" name="image" >
                            </div>
                           
                            <div class="col-md-12">
                                <label for="son" class="form-label">Son personnalisé (optionnel, mp3/wav)</label>
                                <input type="file" class="form-control" id="son" name="son" accept="audio/mp3,audio/wav">
                            </div>
                                </select>
                            </div>
                            
                            
                            
                            <div class="col-12">
                                <label for="name" class="form-label">Votre nom</label>
                                <input type="text" class="form-control mb-3" id="name" name="name" placeholder="Entrez votre nom" required>
                                <label for="bg_color" class="form-label">Couleur de fond</label>
                                <input type="color" class="form-control form-control-color" id="bg_color" name="bg_color" value="#ffffff" title="Choisissez une couleur">
                            </div>
                        </div>
                        
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Créer la page</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card shadow mt-4">
                <div class="card-header bg-secondary text-white">
                    <h2 class="h5 mb-0">Aperçu</h2>
                </div>
                <div class="card-body">
                    <div id="livePreview" class="p-4 rounded" style="background-color: #ffffff; min-height: 200px;">
                        <h3 id="previewTitle" class="h4">Votre titre apparaîtra ici</h3>
                        <p id="previewMessage" class="mb-0">Votre message apparaîtra ici</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<footer class="bg-light text-center py-4 mt-5 border-top">
    <div class="container">
        <span class="text-muted">&copy; <?php echo date('Y'); ?> IUT-TECH6. Tous droits réservés.</span>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/preview.js"></script>
</body>
</html>

<!-- [...] (pied de page similaire à index.php) -->