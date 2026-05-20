<?php
require_once '../config.php';

if (isAdminLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();
        
        if ($admin && password_verify($password, $admin['password_hash'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid username or password';
        }
    } else {
        $error = 'Please fill in all fields';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - BadiniMovies</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, system-ui, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #0c0b14 0%, #1a1728 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: rgba(26, 23, 40, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 32px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(228, 179, 99, 0.3);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .logo i {
            font-size: 3rem;
            color: #e4b363;
        }
        .logo h1 {
            color: #f0eef7;
            font-size: 1.8rem;
            margin-top: 0.5rem;
        }
        .logo span {
            color: #e4b363;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            color: #dbd4f5;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        input {
            width: 100%;
            padding: 0.9rem 1.2rem;
            background: #1a1728;
            border: 2px solid #332e48;
            border-radius: 16px;
            color: #f0eef7;
            font-size: 1rem;
            transition: all 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #e4b363;
            box-shadow: 0 0 0 3px rgba(228, 179, 99, 0.2);
        }
        button {
            width: 100%;
            padding: 0.9rem;
            background: #e4b363;
            border: none;
            border-radius: 16px;
            font-size: 1rem;
            font-weight: 600;
            color: #12101c;
            cursor: pointer;
            transition: all 0.3s;
        }
        button:hover {
            background: #d4a353;
            transform: translateY(-2px);
        }
        .error {
            background: rgba(255, 82, 82, 0.15);
            border: 1px solid #ff5252;
            border-radius: 12px;
            padding: 0.8rem;
            color: #ff8a8a;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }
        .back-link a {
            color: #a29cc0;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .back-link a:hover {
            color: #e4b363;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <i class="fas fa-film"></i>
            <h1>Badini<span>Movies</span></h1>
            <p style="color: #a29cc0; font-size: 0.85rem; margin-top: 0.5rem;">Admin Login</p>
        </div>
        
        <?php if ($error): ?>
            <div class="error">
                <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label><i class="fas fa-user"></i> Username</label>
                <input type="text" name="username" required placeholder="Enter username">
            </div>
            <div class="form-group">
                <label><i class="fas fa-lock"></i> Password</label>
                <input type="password" name="password" required placeholder="Enter password">
            </div>
            <button type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
        </form>
        <div class="back-link">
            <a href="../index.php"><i class="fas fa-arrow-left"></i> Back to Website</a>
        </div>
    </div>
</body>
</html>