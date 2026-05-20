<?php
require_once '../config.php';
header('Content-Type: application/json');

$slug = $_GET['slug'] ?? '';
if (empty($slug)) {
    echo json_encode(['success' => false, 'error' => 'Missing slug parameter']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM movies WHERE slug = ?");
$stmt->execute([$slug]);
$movie = $stmt->fetch();

if (!$movie) {
    echo json_encode(['success' => false, 'error' => 'Movie not found']);
    exit;
}

// Increment views
$updateStmt = $pdo->prepare("UPDATE movies SET views = views + 1 WHERE id = ?");
$updateStmt->execute([$movie['id']]);

$movie['servers'] = json_decode($movie['servers_json'], true);
unset($movie['servers_json']);
$movie['views'] = (int)$movie['views'] + 1;

echo json_encode([
    'success' => true,
    'movie' => $movie
]);
?>
