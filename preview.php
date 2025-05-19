<?php
// Vérification et définition des variables pour éviter les erreurs
if (!isset($page) || !is_array($page)) {
    // Connexion à la base de données
    require_once 'includes/db.php'; // Assurez-vous que ce fichier contient la connexion PDO
    require_once 'includes/config.php'; // Assurez-vous que ce fichier définit $pdo (instance PDO)
    $pageId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $stmt = $pdo->prepare("SELECT title, bg_color, message, music, theme,img FROM pages WHERE id = ? ");
    $stmt->execute([$pageId]);
    $pageData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pageData) {
        // Récupérer aussi le nom d'utilisateur associé à la page (par exemple via user_id)
        $stmtUser = $pdo->prepare("SELECT username FROM users WHERE id = (SELECT user_id FROM pages WHERE id = ?)");
        $stmtUser->execute([$pageId]);
        $userData = $stmtUser->fetch(PDO::FETCH_ASSOC);
        $page = $pageData;
        $page['username'] = $userData ? $userData['username'] : '';
    } else {
        $page = [
            'title' => 'Aucune page',
            'bg_color' => '#ffffff',
            'message' => '',
            'img' => '',
            'music' => ''
        ];
    }
}
if (!isset($emojis) || !is_array($emojis)) {
    // Définir les emojis en fonction du titre de la page
    $title = isset($page['theme']) ? mb_strtolower($page['theme']) : '';
    // Regrouper les mots exprimant le même sentiment
    if (preg_match('/anniversaire|birthday|naissance/i', $title)) {
        $emojis = ['🎂','🎉','🥳','🎈','🍰'];
    } elseif (preg_match('/félicitations|bravo|congratulations|succès|réussite/i', $title)) {
        $emojis = ['👏','🎉','🏆','🥇','✨'];
    } elseif (preg_match('/amour|love|valentin|romance|coeur|heart/i', $title)) {
        $emojis = ['❤️','😍','😘','💖','💕'];
    } elseif (preg_match('/merci|thanks|gratitude|remerciement/i', $title)) {
        $emojis = ['🙏','😊','💐','🌸','✨'];
    } elseif (preg_match('/dramatique/i', $title)) {
        $emojis = ['🎭','😱','😭','🔥','💔'];
    } elseif (preg_match('/ironique/i', $title)) {
        $emojis = ['😏','🙃','😂','🤨','😜'];
    } elseif (preg_match('/ultra[_ ]?cringe/i', $title)) {
        $emojis = ['😬','🫣','😳','🤦‍♂️','🤦‍♀️'];
    } elseif (preg_match('/classe/i', $title)) {
        $emojis = ['🕶️','💼','👔','✨','😎'];
    } elseif (preg_match('/touchant/i', $title)) {
        $emojis = ['🥹','🥰','💖','😭','🤗'];
    } elseif (preg_match('/absurde/i', $title)) {
        $emojis = ['🦄','🤪','🌀','🙃','🐙'];
    } elseif (preg_match('/passif[_ -]?agressif/i', $title)) {
        $emojis = ['😒','😑','🙄','😏','🤨'];
    } elseif (preg_match('/honnete|honnête/i', $title)) {
        $emojis = ['🤝','🙂','🫡','👍','💬'];
    } elseif (preg_match('/tristesse|condoléances|deuil|triste|sad/i', $title)) {
        $emojis = ['😢','🕊️','💐','🙏','🖤'];
    } else {
        $emojis = ['🎉','✨','😊','🥳'];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page['title']) ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .emoji-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }
        .emoji {
            position: absolute;
            font-size: 2rem;
            opacity: 0;
            animation: float 10s infinite linear;
        }
        @keyframes float {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-10vh) rotate(360deg); opacity: 0; }
        }
    </style>
</head>
<body style="background-color: <?= htmlspecialchars($page['bg_color']) ?>; min-height: 100vh;">
    <div class="emoji-container" id="emojiContainer"></div>
    
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-body text-center p-5">
                        <h1 class="display-4 mb-4"><?= htmlspecialchars($page['title']) ?></h1>
                        <?php if (!empty($page['username'])): ?>
                            <h5 class="mb-3 text-secondary">Par <?= htmlspecialchars($page['username']) ?></h5>
                        <?php endif; ?>
                        <?php if (!empty($page['img'])): ?>
                            <?php if (!empty($page['img'])): ?>
                            <div class="mb-4">
                                <img src="assets/images/<?= htmlspecialchars($page['img']) ?>" alt="Image associée" class="img-fluid rounded shadow">
                            </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div class="message lead mb-5"><?= nl2br(htmlspecialchars($page['message'])) ?></div>
                        
                        <div class="mt-5">
                            <?php if (!empty($page['username'])): ?>
                                <div class="mb-3 fw-bold">
                                    <i class="bi bi-person-circle"></i>
                                    <?= htmlspecialchars($page['username']) ?>
                                </div>
                            <?php endif; ?>
                            <audio id="backgroundMusic" loop>
                                <source src="<?= htmlspecialchars($page['music']) ?>" type="audio/mpeg">
                            </audio>
                            <a href="index.php" class="btn btn-lg btn-secondary my-4 w-100">
                                <i class="bi bi-arrow-left-circle"></i> Retour
                            </a>
                            <button id="musicToggle" class="btn btn-outline-primary">
                                <i class="bi bi-volume-up"></i> Activer la musique
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle avec Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Générer des émojis flottants
        const emojis = <?= json_encode($emojis) ?>;
        const container = document.getElementById('emojiContainer');
        
        function createEmoji() {
            const emoji = document.createElement('div');
            emoji.className = 'emoji';
            emoji.textContent = emojis[Math.floor(Math.random() * emojis.length)];
            emoji.style.left = Math.random() * 100 + 'vw';
            emoji.style.animationDuration = (5 + Math.random() * 10) + 's';
            emoji.style.animationDelay = Math.random() * 5 + 's';
            container.appendChild(emoji);
            setTimeout(() => emoji.remove(), 15000);
        }
        
        setInterval(createEmoji, 500);
        
        // Gestion de la musique
        const music = document.getElementById('backgroundMusic');
        const toggleBtn = document.getElementById('musicToggle');
        
        toggleBtn.addEventListener('click', function() {
            if (music.paused) {
                music.play();
                toggleBtn.innerHTML = '<i class="bi bi-volume-mute"></i> Désactiver la musique';
            } else {
                music.pause();
                toggleBtn.innerHTML = '<i class="bi bi-volume-up"></i> Activer la musique';
            }
        });
    </script>
</body>
</html>