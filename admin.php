<?php
session_start();
require_once 'config.php';

// Simple login logic
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // In real scenario, use password_verify. For simplicity, we use hardcoded check.
    // Better: store hashed password in DB
    if ($username === 'admin' && $password === 'your_secure_password') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Invalid credentials';
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

// If not logged in, show login form
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo '<!DOCTYPE html>
    <html>
    <head><title>Admin Login</title><style>body{background:#0c0b14;color:#fff;font-family:Arial;display:flex;justify-content:center;align-items:center;height:100vh;}form{background:#1a1728;padding:2rem;border-radius:24px;}input{margin:10px 0;padding:10px;width:100%;}button{background:#e4b363;border:none;padding:10px;cursor:pointer;}</style></head>
    <body>
        <form method="post">
            <h2>Admin Login</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
            <p style="color:red"><?php echo $error; ?></p>
        </form>
    </body>
    </html>';
    exit;
}

// ----- Admin panel UI (display movies, add form) -----
$stmt = $pdo->query("SELECT * FROM movies ORDER BY title_en ASC");
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - BadiniMovies</title>
    <style>
        body { background: #0c0b14; color: #f0eef7; font-family: Arial; padding: 20px; }
        .container { max-width: 1000px; margin: auto; background: #1a1728; padding: 20px; border-radius: 24px; }
        input, textarea, select { width: 100%; margin: 8px 0; padding: 10px; border-radius: 8px; border: none; background: #2f2b45; color: white; }
        button { background: #e4b363; padding: 10px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #4b446b; }
        .delete-btn { background: #b91c1c; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none; }
        .logout { float: right; background: #4b446b; padding: 10px 15px; border-radius: 20px; color: white; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <a href="?logout=1" class="logout">Logout</a>
    <h1>🎬 Manage Movies</h1>
    
    <h2>➕ Add New Movie</h2>
    <form id="addMovieForm">
        <input type="text" id="title_en" placeholder="Title (English)" required>
        <input type="text" id="title_ar" placeholder="Title (Arabic)" required>
        <input type="text" id="year" placeholder="Year" required>
        <select id="lang" required>
            <option value="both">Both</option><option value="en">English</option><option value="ar">Arabic</option>
        </select>
        <input type="url" id="poster_url" placeholder="Poster URL" required>
        <textarea id="description_en" rows="2" placeholder="Description (English)"></textarea>
        <textarea id="description_ar" rows="2" placeholder="Description (Arabic)"></textarea>
        <h3>Servers (at least one)</h3>
        <input type="url" id="server1_url" placeholder="Server 1 URL" required>
        <input type="text" id="server1_label" placeholder="Server 1 Label (e.g. Vidspeeds)" value="Server 1">
        <input type="url" id="server2_url" placeholder="Server 2 URL">
        <input type="text" id="server2_label" placeholder="Server 2 Label">
        <input type="url" id="server3_url" placeholder="Server 3 URL">
        <input type="text" id="server3_label" placeholder="Server 3 Label">
        <button type="submit">➕ Add Movie</button>
    </form>
    
    <h2>📋 Existing Movies</h2>
    <table id="moviesTable">
        <thead><tr><th>Title</th><th>Year</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach($movies as $movie): ?>
            <tr data-movie-id="<?php echo $movie['movie_id']; ?>">
                <td><?php echo htmlspecialchars($movie['title_en']); ?></td>
                <td><?php echo $movie['year']; ?></td>
                <td><button class="delete-btn" onclick="deleteMovie('<?php echo $movie['movie_id']; ?>')">Delete</button></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    document.getElementById('addMovieForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const servers = [];
        const s1url = document.getElementById('server1_url').value;
        if (s1url) {
            servers.push({
                label: document.getElementById('server1_label').value || 'Server 1',
                url: s1url,
                icon: 'fa-server'
            });
        }
        const s2url = document.getElementById('server2_url').value;
        if (s2url) {
            servers.push({
                label: document.getElementById('server2_label').value || 'Server 2',
                url: s2url,
                icon: 'fa-server'
            });
        }
        const s3url = document.getElementById('server3_url').value;
        if (s3url) {
            servers.push({
                label: document.getElementById('server3_label').value || 'Server 3',
                url: s3url,
                icon: 'fa-server'
            });
        }
        const movieData = {
            action: 'add',
            title_en: document.getElementById('title_en').value,
            title_ar: document.getElementById('title_ar').value,
            year: document.getElementById('year').value,
            lang: document.getElementById('lang').value,
            poster_url: document.getElementById('poster_url').value,
            description_en: document.getElementById('description_en').value,
            description_ar: document.getElementById('description_ar').value,
            servers: servers
        };
        const response = await fetch('api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(movieData)
        });
        const result = await response.json();
        if (result.success) {
            location.reload();
        } else {
            alert('Error: ' + (result.error || 'Unknown'));
        }
    });
    
    async function deleteMovie(movieId) {
        if (!confirm('Delete this movie?')) return;
        const response = await fetch('api.php?movie_id=' + movieId, {
            method: 'DELETE'
        });
        const result = await response.json();
        if (result.success) {
            location.reload();
        } else {
            alert('Delete failed');
        }
    }
</script>
</body>
</html>