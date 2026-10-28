<?php
session_start();

$error_message = '';
$logged_in = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ユーザー入力を取得（検証なし）
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // SQLite DB接続
    $db = new SQLite3(__DIR__ . '/database.db');

    // ⚠️ 脆弱性：ユーザー入力をそのまま SQL文に埋め込む（SQLインジェクション）
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

    $result = $db->querySingle($query, true);

    if ($result) {
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['username'] = $result['username'];
        $_SESSION['email'] = $result['email'];

        // ダッシュボードへリダイレクト
        header('Location: dashboard.php');
        exit;
    } else {
        $error_message = 'ユーザー名またはパスワードが正しくありません';
    }

    $db->close();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン - DX Innovation Partners</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">DX INNOVATION</div>
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php" class="active">Login</a></li>
            </ul>
        </div>
    </nav>

    <div class="login-container">
        <div class="login-box">
            <h1>ログイン</h1>
            <p>DX Innovation Partnersにアクセス</p>

            <?php if ($error_message): ?>
                <div class="error-message">
                    ⚠️ <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="username">ユーザー名</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="admin"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        required
                    >
                </div>

                <button type="submit" class="login-btn">ログイン</button>
            </form>

            <p class="login-footer">
                デモアカウント:<br>
                ユーザー名: <code>admin</code><br>
                パスワード: <code>password123</code>
            </p>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 DX Innovation Partners. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
