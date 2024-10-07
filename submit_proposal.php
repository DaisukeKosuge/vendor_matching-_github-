<?php
session_start();
if ($_SESSION['role'] !== 'hospital') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'funcs.php';
    $pdo = dbConnect();

    // 提案依頼を登録
    $sql = "INSERT INTO proposals (hospital_id, description, budget, deadline) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user']['id'], $_POST['description'], $_POST['budget'], $_POST['deadline']]);

    echo "提案依頼が送信されました。";
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>提案依頼</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>提案依頼を送信</h1>
    <form method="POST" action="">
        <label for="description">提案の説明:</label><br>
        <textarea name="description" required></textarea><br>

        <label for="budget">予算:</label><br>
        <input type="text" name="budget" required><br>

        <label for="deadline">締め切り:</label><br>
        <input type="date" name="deadline" required><br>

        <input type="submit" value="送信">
    </form>
    <a href="hospital.php">戻る</a>
</body>
</html>
