<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config.php';
session_start();

// Helper function to check if user is logged in (for write operations)
function isAdmin() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Fetch all movies
    $stmt = $pdo->query("SELECT * FROM movies ORDER BY title_en ASC");
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Decode servers_json for each movie
    foreach ($movies as &$movie) {
        $movie['servers'] = json_decode($movie['servers_json'], true);
        unset($movie['servers_json']);
    }
    echo json_encode($movies);
    exit;
}

elseif ($method === 'POST') {
    // Only admin can add/update/delete
    if (!isAdmin()) {
        http_response_code(403);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? '';
    
    if ($action === 'add') {
        $movie_id = uniqid(); // simple unique id
        $title_en = $data['title_en'];
        $title_ar = $data['title_ar'];
        $year = $data['year'];
        $lang = $data['lang'];
        $poster_url = $data['poster_url'];
        $description_en = $data['description_en'] ?? '';
        $description_ar = $data['description_ar'] ?? '';
        $servers_json = json_encode($data['servers']);
        
        $stmt = $pdo->prepare("INSERT INTO movies (movie_id, title_en, title_ar, year, lang, poster_url, description_en, description_ar, servers_json) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$movie_id, $title_en, $title_ar, $year, $lang, $poster_url, $description_en, $description_ar, $servers_json]);
        
        echo json_encode(['success' => true, 'message' => 'Movie added']);
    }
    elseif ($action === 'delete') {
        $movie_id = $data['movie_id'];
        $stmt = $pdo->prepare("DELETE FROM movies WHERE movie_id = ?");
        $stmt->execute([$movie_id]);
        echo json_encode(['success' => true]);
    }
    else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
    }
    exit;
}

elseif ($method === 'DELETE') {
    if (!isAdmin()) {
        http_response_code(403);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }
    parse_str(file_get_contents('php://input'), $delete_vars);
    $movie_id = $delete_vars['movie_id'] ?? '';
    if ($movie_id) {
        $stmt = $pdo->prepare("DELETE FROM movies WHERE movie_id = ?");
        $stmt->execute([$movie_id]);
        echo json_encode(['success' => true]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Missing movie_id']);
    }
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);
?>