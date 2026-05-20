<?php
require_once '../config.php';
redirectIfNotLoggedIn();

// Handle movie deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM movies WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header('Location: dashboard.php?deleted=1');
    exit;
}

// Get all movies
$stmt = $pdo->query("SELECT * FROM movies ORDER BY id DESC");
$movies = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BadiniMovies</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, system-ui, sans-serif;
        }
        body {
            background: #0c0b14;
            color: #f0eef7;
        }
        .admin-header {
            background: #1a1728;
            border-bottom: 2px solid #e4b363;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .admin-header h1 {
            font-size: 1.5rem;
        }
        .admin-header h1 i {
            color: #e4b363;
        }
        .admin-header .user-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .btn-logout {
            background: #2f2b45;
            color: #dbd4f5;
            padding: 0.5rem 1.2rem;
            border-radius: 40px;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-logout:hover {
            background: #e4b363;
            color: #12101c;
        }
        .btn-add {
            background: #e4b363;
            color: #12101c;
            padding: 0.5rem 1.5rem;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        .stats-bar {
            background: #1a1728;
            border-radius: 20px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .stats-bar span {
            color: #e4b363;
            font-weight: 600;
        }
        .movies-table {
            width: 100%;
            background: #1a1728;
            border-radius: 20px;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #332e48;
        }
        th {
            color: #e4b363;
            font-weight: 600;
        }
        .movie-poster {
            width: 50px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
        }
        .actions {
            display: flex;
            gap: 0.5rem;
        }
        .btn-edit, .btn-delete {
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-edit {
            background: #2f2b45;
            color: #e4b363;
        }
        .btn-delete {
            background: rgba(255, 82, 82, 0.2);
            color: #ff8a8a;
            border: none;
            cursor: pointer;
        }
        .btn-delete:hover {
            background: #ff5252;
            color: white;
        }
        .alert {
            background: rgba(76, 175, 80, 0.2);
            border: 1px solid #4caf50;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            color: #81c784;
        }
        @media (max-width: 768px) {
            .container { padding: 1rem; }
            th, td { padding: 0.5rem; font-size: 0.8rem; }
            .actions { flex-direction: column; }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-header">
        <h1><i class="fas fa-film"></i> BadiniMovies - Admin Panel</h1>
        <div class="user-info">
            <span><i class="fas fa-user-shield"></i> <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
            <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    
    <div class="container">
        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert"><i class="fas fa-check-circle"></i> Movie deleted successfully!</div>
        <?php endif; ?>
        <?php if (isset($_GET['added'])): ?>
            <div class="alert"><i class="fas fa-check-circle"></i> Movie added successfully!</div>
        <?php endif; ?>
        <?php if (isset($_GET['updated'])): ?>
            <div class="alert"><i class="fas fa-check-circle"></i> Movie updated successfully!</div>
        <?php endif; ?>
        
        <div class="stats-bar">
            <span><i class="fas fa-video"></i> Total Movies: <?php echo count($movies); ?></span>
            <a href="add_movie.php" class="btn-add"><i class="fas fa-plus"></i> Add New Movie</a>
        </div>
        
        <div class="movies-table">
            <table>
                <thead>
                    <tr><th>ID</th><th>Poster</th><th>Title (EN)</th><th>Title (AR)</th><th>Year</th><th>Lang</th><th>Views</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($movies as $movie): ?>
                    <tr>
                        <td><?php echo $movie['id']; ?></td>
                        <td><img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" class="movie-poster" onerror="this.src='https://via.placeholder.com/50x70?text=No+Poster'"></td>
                        <td><?php echo htmlspecialchars($movie['title_en']); ?></td>
                        <td><?php echo htmlspecialchars($movie['title_ar']); ?></td>
                        <td><?php echo $movie['year']; ?></td>
                        <td><?php echo strtoupper($movie['lang']); ?></td>
                        <td><?php echo number_format($movie['views']); ?></td>
                        <td class="actions">
                            <a href="edit_movie.php?id=<?php echo $movie['id']; ?>" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                            <a href="?delete=<?php echo $movie['id']; ?>" class="btn-delete" onclick="return confirm('Delete this movie?')"><i class="fas fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($movies)): ?>
                    <tr><td colspan="8" style="text-align: center; padding: 2rem;">No movies yet. Click "Add New Movie" to get started!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>