<?php
require_once '../config.php';
header('Content-Type: application/json');

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = isset($_GET['limit']) ? min(50, intval($_GET['limit'])) : 20;
$offset = ($page - 1) * $limit;
$filter = $_GET['filter'] ?? 'all';
$search = trim($_GET['search'] ?? '');

$where = [];
$params = [];

if ($filter === 'en') {
    $where[] = "lang IN ('en', 'both')";
} elseif ($filter === 'ar') {
    $where[] = "lang IN ('ar', 'both')";
}

if (!empty($search)) {
    $where[] = "(title_en LIKE ? OR title_ar LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$whereClause = empty($where) ? '' : 'WHERE ' . implode(' AND ', $where);

// Get total count
$countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM movies $whereClause");
$countStmt->execute($params);
$total = $countStmt->fetch()['total'];

// Get paginated movies
$sql = "SELECT id, slug, title_en, title_ar, year, lang, poster_url, description_en, description_ar, servers_json, views 
        FROM movies $whereClause ORDER BY id DESC LIMIT ? OFFSET ?";
$stmt = $pdo->prepare($sql);
$allParams = array_merge($params, [$limit, $offset]);
$stmt->execute($allParams);
$movies = $stmt->fetchAll();

foreach ($movies as &$movie) {
    $movie['servers'] = json_decode($movie['servers_json'], true);
    unset($movie['servers_json']);
    $movie['views'] = (int)$movie['views'];
}

echo json_encode([
    'success' => true,
    'movies' => $movies,
    'total' => (int)$total,
    'page' => $page,
    'limit' => $limit,
    'totalPages' => ceil($total / $limit)
]);
?>