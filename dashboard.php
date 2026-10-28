<?php
session_start();

// ログイン確認（簡易版）
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
$email = $_SESSION['email'] ?? 'unknown@example.com';
$user_message = '';

// メッセージ処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['message'])) {
        // ⚠️ 脆弱性：ユーザー入力をそのままHTMLに埋め込む（XSS）
        $user_message = $_POST['message'];
    }
}

// DB からユーザーリストを取得
$db = new SQLite3(__DIR__ . '/database.db');
$users_result = $db->query('SELECT id, username, email FROM users LIMIT 10');
$users = [];

while ($row = $users_result->fetchArray(SQLITE3_ASSOC)) {
    $users[] = $row;
}

$db->close();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ダッシュボード - DX Innovation Partners</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-page">
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">DX INNOVATION</div>
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li class="user-info">👤 <?php echo htmlspecialchars($username); ?></li>
                <li><a href="logout.php" class="logout-btn">ログアウト</a></li>
            </ul>
        </div>
    </nav>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>ダッシュボード</h1>
            <p>ようこそ、<?php echo htmlspecialchars($username); ?>さん</p>
        </div>

        <div class="dashboard-content">
            <!-- ユーザー情報 -->
            <section class="dashboard-section">
                <h2>ユーザー情報</h2>
                <div class="info-card">
                    <p><strong>ユーザー名:</strong> <?php echo htmlspecialchars($username); ?></p>
                    <p><strong>メール:</strong> <?php echo htmlspecialchars($email); ?></p>
                </div>
            </section>

            <!-- メッセージ入力フォーム -->
            <section class="dashboard-section">
                <h2>メッセージを投稿</h2>
                <form method="POST" class="message-form">
                    <textarea
                        name="message"
                        placeholder="メッセージを入力してください（XSS脆弱性デモ）"
                        rows="4"
                        required
                    ></textarea>
                    <button type="submit">投稿</button>
                </form>

                <?php if ($user_message): ?>
                    <div class="message-box">
                        <h3>あなたのメッセージ:</h3>
                        <!-- ⚠️ 脆弱性：htmlspecialchars() なしでそのまま出力 -->
                        <p><?php echo $user_message; ?></p>
                    </div>
                <?php endif; ?>
            </section>

            <!-- ユーザーリスト -->
            <section class="dashboard-section">
                <h2>全ユーザーリスト</h2>
                <div class="user-list">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ユーザー名</th>
                                <th>メール</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- 管理者パネル（秘密） -->
            <section class="dashboard-section admin-section">
                <h2>🔒 管理者パネル</h2>
                <div class="admin-box">
                    <p><strong>データベース接続情報</strong></p>
                    <code>sqlite:database.db</code>
                    <p><strong>最後のバックアップ:</strong> 2024-10-01 15:30</p>
                    <p><strong>ユーザー総数:</strong> <?php echo count($users); ?></p>
                </div>
            </section>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 DX Innovation Partners. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
