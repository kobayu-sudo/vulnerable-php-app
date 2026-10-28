<?php
// SQLiteデータベースの初期化

$db_path = __DIR__ . '/database.db';

// 既存DBがあれば削除
if (file_exists($db_path)) {
    unlink($db_path);
}

// 新しいDBを作成
$db = new SQLite3($db_path);

// ユーザーテーブルを作成
$db->exec('
    CREATE TABLE users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        email TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )
');

// サンプルユーザーを追加
$db->exec("
    INSERT INTO users (username, password, email) VALUES
    ('admin', 'password123', 'admin@example.com'),
    ('user1', 'user123', 'user1@example.com'),
    ('user2', 'user456', 'user2@example.com'),
    ('user3', 'user789', 'user3@example.com'),
    ('user4', 'pass001', 'user4@example.com'),
    ('user5', 'pass002', 'user5@example.com'),
    ('user6', 'pass003', 'user6@example.com'),
    ('user7', 'pass004', 'user7@example.com'),
    ('user8', 'pass005', 'user8@example.com'),
    ('user9', 'pass006', 'user9@example.com')
");

$db->close();

echo "✅ データベースが初期化されました！\n";
echo "📁 パス: " . $db_path . "\n";
echo "\n以下のデモアカウントでログインできます:\n";
echo "ユーザー名: admin\n";
echo "パスワード: password123\n";
echo "\nまたは:\n";
echo "ユーザー名: user1\n";
echo "パスワード: user123\n";
?>
