<main class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="h2">Mes pages de départ</h1>
        <a href="create.php" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Créer une nouvelle page
        </a>
    </div>

    <?php if(empty($pages)): ?>
        <div class="alert alert-info">
            Vous n'avez pas encore créé de pages.
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach($pages as $page): ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body" style="background-color: <?= htmlspecialchars($page['bg_color']) ?>;">
                        <h3 class="card-title h5"><?= htmlspecialchars($page['title']) ?></h3>
                        <p class="card-text"><?= substr(htmlspecialchars($page['message']), 0, 100) ?>...</p>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between">
                            <a href="preview.php?id=<?= $page['id'] ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Voir
                            </a>
                            <a href="edit.php?id=<?= $page['id'] ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i> Modifier
                            </a>
                            <a href="delete.php?id=<?= $page['id'] ?>" class="btn btn-sm btn-outline-danger" 
                               onclick="return confirm('Supprimer cette page?')">
                                <i class="bi bi-trash"></i> Supprimer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>