# DX Innovation Partners - 脆弱性デモアプリ

## 概要
SQLインジェクション + XSS脆弱性を含むPHPアプリです。セキュリティ教育目的での実演用です。

## クイックスタート（Replit）

### 1. Replit にインポート
以下のボタンをクリック、または URL を Replit にコピー：

```
https://github.com/[YOUR_GITHUB_USERNAME]/vulnerable-php-app
```

### 2. 自動デプロイ
Replit が自動で以下を実行：
- PHP 環境セットアップ
- SQLite DB 初期化
- サーバー起動

### 3. アクセス
`https://[replit-url].repl.co` でアクセス

## ログイン認証情報

### デモアカウント
- **ユーザー名:** `admin`
- **パスワード:** `password123`

または

- **ユーザー名:** `user1`
- **パスワード:** `user123`

## ファイル構成

```
├── index.php           # ホームページ
├── login.php           # ログイン画面（SQLインジェクション脆弱性）
├── dashboard.php       # ダッシュボード（XSS脆弱性）
├── logout.php          # ログアウト
├── style.css           # Benesse風デザイン
├── init-db.php         # DB初期化スクリプト
├── .replit             # Replit 設定
└── replit.nix          # 依存関係定義
```

## 脆弱性について

### SQLインジェクション（login.php）
ユーザー入力をそのまま SQL に埋め込んでいます。

```php
$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
```

攻撃例：
- ユーザー名: `' OR '1'='1`
- パスワード: 任意

### XSS（dashboard.php）
ユーザー入力をそのまま HTML に出力しています。

```php
<?php echo $user_message; ?>
```

攻撃例：
- メッセージ: `<script>alert('XSS')</script>`

## 注意事項

⚠️ **本番環境での使用は禁止です。**  
このアプリは教育目的のみです。セキュリティ研究・学習以外での使用は避けてください。

## ライセンス

教育目的でのみ使用可。

---

**作成日:** 2024年10月
