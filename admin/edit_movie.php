<?php
require_once '../config.php';
redirectIfNotLoggedIn();

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->execute([$id]);
$movie = $stmt->fetch();

if (!$movie) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title_en = trim($_POST['title_en']);
    $title_ar = trim($_POST['title_ar']);
    $year = trim($_POST['year']);
    $lang = $_POST['lang'];
    $poster_url = trim($_POST['poster_url']);
    $description_en = trim($_POST['description_en']);
    $description_ar = trim($_POST['description_ar']);
    
    $servers = [];
    if (isset($_POST['server_label']) && is_array($_POST['server_label'])) {
        foreach ($_POST['server_label'] as $idx => $label) {
            if (!empty($label) && !empty($_POST['server_url'][$idx])) {
                $servers[] = [
                    'label' => $label,
                    'url' => $_POST['server_url'][$idx],
                    'icon' => $_POST['server_icon'][$idx] ?? 'fa-server'
                ];
            }
        }
    }
    
    $servers_json = json_encode($servers);
    
    $stmt = $pdo->prepare("UPDATE movies SET title_en=?, title_ar=?, year=?, lang=?, poster_url=?, description_en=?, description_ar=?, servers_json=? WHERE id=?");
    $stmt->execute([$title_en, $title_ar, $year, $lang, $poster_url, $description_en, $description_ar, $servers_json, $id]);
    
    header('Location: dashboard.php?updated=1');
    exit;
}

$currentServers = json_decode($movie['servers_json'], true) ?: [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie - BadiniMovies Admin</title>
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
        .admin-header h1 { font-size: 1.5rem; }
        .btn-back {
            background: #2f2b45;
            color: #dbd4f5;
            padding: 0.5rem 1.2rem;
            border-radius: 40px;
            text-decoration: none;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
        }
        .form-card {
            background: #1a1728;
            border-radius: 24px;
            padding: 2rem;
            border: 1px solid #332e48;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            color: #e4b363;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        input, select, textarea {
            width: 100%;
            padding: 0.8rem 1rem;
            background: #0c0b14;
            border: 2px solid #332e48;
            border-radius: 12px;
            color: #f0eef7;
            font-size: 0.95rem;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        .servers-section {
            background: rgba(0,0,0,0.3);
            border-radius: 16px;
            padding: 1rem;
            margin-top: 0.5rem;
        }
        .server-row {
            display: flex;
            gap: 0.8rem;
            margin-bottom: 0.8rem;
            flex-wrap: wrap;
        }
        .server-row input {
            flex: 1;
        }
        .btn-add-server {
            background: #2f2b45;
            color: #e4b363;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 30px;
            cursor: pointer;
        }
        .btn-submit {
            background: #e4b363;
            color: #12101c;
            padding: 1rem;
            border: none;
            border-radius: 40px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
        }
        .row-2cols {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .btn-remove-server {
            background: #ff5252;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0 12px;
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-header">
        <h1><i class="fas fa-edit"></i> Edit Movie</h1>
        <a href="dashboard.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>
    
    <div class="container">
        <div class="form-card">
            <form method="POST">
                <div class="row-2cols">
                    <div class="form-group">
                        <label>Title (English)</label>
                        <input type="text" name="title_en" required value="<?php echo htmlspecialchars($movie['title_en']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Title (Arabic)</label>
                        <input type="text" name="title_ar" required value="<?php echo htmlspecialchars($movie['title_ar']); ?>">
                    </div>
                </div>
                
                <div class="row-2cols">
                    <div class="form-group">
                        <label>Year</label>
                        <input type="text" name="year" required value="<?php echo htmlspecialchars($movie['year']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Language</label>
                        <select name="lang">
                            <option value="both" <?php echo $movie['lang'] == 'both' ? 'selected' : ''; ?>>Both (EN/AR)</option>
                            <option value="en" <?php echo $movie['lang'] == 'en' ? 'selected' : ''; ?>>English Only</option>
                            <option value="ar" <?php echo $movie['lang'] == 'ar' ? 'selected' : ''; ?>>Arabic Only</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Poster URL</label>
                    <input type="url" name="poster_url" required value="<?php echo htmlspecialchars($movie['poster_url']); ?>">
                </div>
                
                <div class="form-group">
                    <label>Description (English)</label>
                    <textarea name="description_en"><?php echo htmlspecialchars($movie['description_en']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Description (Arabic)</label>
                    <textarea name="description_ar"><?php echo htmlspecialchars($movie['description_ar']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Video Servers</label>
                    <div class="servers-section" id="serversContainer">
                        <?php foreach ($currentServers as $idx => $server): ?>
                        <div class="server-row">
                            <input type="text" name="server_label[]" value="<?php echo htmlspecialchars($server['label']); ?>" placeholder="Server Name" style="flex:2">
                            <input type="url" name="server_url[]" value="<?php echo htmlspecialchars($server['url']); ?>" placeholder="Embed URL" style="flex:3">
                            <input type="text" name="server_icon[]" value="<?php echo htmlspecialchars($server['icon'] ?? 'fa-server'); ?>" placeholder="Icon" class="server-icon" style="width:100px">
                            <button type="button" class="btn-remove-server" onclick="this.parentElement.remove()">✕</button>
                        </div>
                        <?php endforeach; ?>
                        <?php if (empty($currentServers)): ?>
                        <div class="server-row">
                            <input type="text" name="server_label[]" placeholder="Server Name" style="flex:2">
                            <input type="url" name="server_url[]" placeholder="Embed URL" style="flex:3">
                            <input type="text" name="server_icon[]" placeholder="Icon (fa-server)" style="width:100px" value="fa-server">
                        </div>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn-add-server" onclick="addServerRow()">
                        <i class="fas fa-plus"></i> Add Another Server
                    </button>
                </div>
                
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Update Movie</button>
            </form>
        </div>
    </div>
    
    <script>
        function addServerRow() {
            const container = document.getElementById('serversContainer');
            const newRow = document.createElement('div');
            newRow.className = 'server-row';
            newRow.innerHTML = `
                <input type="text" name="server_label[]" placeholder="Server Name" style="flex:2">
                <input type="url" name="server_url[]" placeholder="Embed URL" style="flex:3">
                <input type="text" name="server_icon[]" placeholder="Icon (fa-server)" style="width:100px" value="fa-server">
                <button type="button" class="btn-remove-server" onclick="this.parentElement.remove()">✕</button>
            `;
            container.appendChild(newRow);
        }
    </script>
</body>
</html>