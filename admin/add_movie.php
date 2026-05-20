<?php
require_once '../config.php';
redirectIfNotLoggedIn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title_en = trim($_POST['title_en']);
    $title_ar = trim($_POST['title_ar']);
    $year = trim($_POST['year']);
    $lang = $_POST['lang'];
    $poster_url = trim($_POST['poster_url']);
    $description_en = trim($_POST['description_en']);
    $description_ar = trim($_POST['description_ar']);
    
    // Build servers array from dynamic inputs
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
    
    // Add default server if none
    if (empty($servers)) {
        $servers[] = [
            'label' => 'Main Server',
            'url' => '#',
            'icon' => 'fa-server'
        ];
    }
    
    $servers_json = json_encode($servers);
    
    // Generate unique slug
    $base_slug = generateSlug($title_en);
    $slug = $base_slug;
    $counter = 1;
    while (true) {
        $stmt = $pdo->prepare("SELECT id FROM movies WHERE slug = ?");
        $stmt->execute([$slug]);
        if (!$stmt->fetch()) break;
        $slug = $base_slug . '-' . $counter++;
    }
    
    $stmt = $pdo->prepare("INSERT INTO movies (slug, title_en, title_ar, year, lang, poster_url, description_en, description_ar, servers_json) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$slug, $title_en, $title_ar, $year, $lang, $poster_url, $description_en, $description_ar, $servers_json]);
    
    header('Location: dashboard.php?added=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie - BadiniMovies Admin</title>
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
        .admin-header h1 i { color: #e4b363; }
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
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #e4b363;
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
        .server-row .server-icon {
            width: 100px;
        }
        .btn-add-server {
            background: #2f2b45;
            color: #e4b363;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 30px;
            cursor: pointer;
            margin-top: 0.5rem;
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
            margin-top: 1rem;
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
        @media (max-width: 768px) {
            .container { padding: 1rem; }
            .row-2cols { grid-template-columns: 1fr; }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-header">
        <h1><i class="fas fa-plus-circle"></i> Add New Movie</h1>
        <a href="dashboard.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>
    
    <div class="container">
        <div class="form-card">
            <form method="POST" id="movieForm">
                <div class="row-2cols">
                    <div class="form-group">
                        <label><i class="fas fa-film"></i> Title (English)</label>
                        <input type="text" name="title_en" required placeholder="e.g., The Dark Knight">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-film"></i> Title (Arabic)</label>
                        <input type="text" name="title_ar" required placeholder="e.g., الفارس المظلم">
                    </div>
                </div>
                
                <div class="row-2cols">
                    <div class="form-group">
                        <label><i class="fas fa-calendar"></i> Year</label>
                        <input type="text" name="year" required placeholder="2024">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-language"></i> Language</label>
                        <select name="lang">
                            <option value="both">Both (EN/AR)</option>
                            <option value="en">English Only</option>
                            <option value="ar">Arabic Only</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-image"></i> Poster URL</label>
                    <input type="url" name="poster_url" required placeholder="https://example.com/poster.jpg">
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-align-left"></i> Description (English)</label>
                    <textarea name="description_en" placeholder="Movie plot in English..."></textarea>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-align-right"></i> Description (Arabic)</label>
                    <textarea name="description_ar" placeholder="قصة الفيلم بالعربية..."></textarea>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-server"></i> Video Servers</label>
                    <div class="servers-section" id="serversContainer">
                        <div class="server-row">
                            <input type="text" name="server_label[]" placeholder="Server Name (e.g., Vidspeeds)" style="flex:2">
                            <input type="url" name="server_url[]" placeholder="Embed URL" style="flex:3">
                            <input type="text" name="server_icon[]" placeholder="Icon (fa-server)" class="server-icon" value="fa-server">
                        </div>
                    </div>
                    <button type="button" class="btn-add-server" onclick="addServerRow()">
                        <i class="fas fa-plus"></i> Add Another Server
                    </button>
                    <small style="display: block; margin-top: 0.5rem; color: #a29cc0;">
                        <i class="fas fa-info-circle"></i> Example embed URL: https://www.vidspeeds.com/embed-xxxxx.html
                    </small>
                </div>
                
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Save Movie</button>
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
                <input type="text" name="server_icon[]" placeholder="Icon (fa-server)" class="server-icon" value="fa-server">
                <button type="button" class="btn-remove-server" onclick="this.parentElement.remove()">✕</button>
            `;
            container.appendChild(newRow);
        }
    </script>
</body>
</html>
