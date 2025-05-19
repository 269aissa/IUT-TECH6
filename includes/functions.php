<?php
require_once 'db.php';

function createDeparturePage($userId, $title, $message, $theme, $bgColor, $music) {
    global $pdo;
    
    $stmt = $pdo->prepare("INSERT INTO pages (user_id, title, message, theme, bg_color, music, created_at) 
                          VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$userId, $title, $message, $theme, $bgColor, $music]);
    
    return $pdo->lastInsertId();
}

function getPageById($pageId) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM pages WHERE id = ?");
    $stmt->execute([$pageId]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUserPages($userId) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM pages WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$userId]);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Autres fonctions utilitaires...
?>
