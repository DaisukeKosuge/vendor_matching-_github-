<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'vendor') {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>事業者ダッシュボード</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <h1>事業者ダッシュボード</h1>
        <form action="logout.php" method="POST" style="float: right;">
            <button type="submit" class="logout-btn">ログアウト</button>
        </form>
    </div>

    <p>ここに病院の選定プロセスに関するデータが表示されます。</p>

    <!-- タブやコンテンツを追加する場合はここに記述 -->
</body>
</html>
