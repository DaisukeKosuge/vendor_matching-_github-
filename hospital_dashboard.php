<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hospital') {
    header('Location: index.php');
    exit;
}
require 'db.php';

// 初期状態では全てのベンダを表示
$genre_filter = isset($_POST['genre']) ? $_POST['genre'] : '';
$review_filter = isset($_POST['review_score']) ? $_POST['review_score'] : '';
$iso_filter = isset($_POST['iso_certification']) ? $_POST['iso_certification'] : '';

// クエリの構築
$query = "SELECT * FROM vendors WHERE 1=1";

// ジャンルフィルタ
if (!empty($genre_filter)) {
    $query .= " AND genre = :genre";
}
// レビューフィルタ
if (!empty($review_filter)) {
    $query .= " AND review_score >= :review_score";
}
// ISOフィルタ
if ($iso_filter !== '') {
    $query .= " AND iso_certification = :iso_certification";
}

$stmt = $pdo->prepare($query);

// フィルタに応じてパラメータをバインド
if (!empty($genre_filter)) {
    $stmt->bindValue(':genre', $genre_filter);
}
if (!empty($review_filter)) {
    $stmt->bindValue(':review_score', $review_filter);
}
if ($iso_filter !== '') {
    $stmt->bindValue(':iso_certification', $iso_filter);
}

$stmt->execute();
$vendors = $stmt->fetchAll();

// レビュー一覧を取得
$stmt_reviews = $pdo->prepare("SELECT v.name AS vendor_name, r.review_text, r.rating FROM reviews r JOIN vendors v ON r.vendor_id = v.id");
$stmt_reviews->execute();
$reviews = $stmt_reviews->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>病院ダッシュボード</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // タブの表示切替
            $('.tab-content').hide();
            $('#vendor-list').show();
            $('.tabs li:first').addClass('active');

            // タブクリックイベント
            $('.tabs li').click(function() {
                $('.tabs li').removeClass('active');
                $(this).addClass('active');
                $('.tab-content').hide();

                var selectedTab = $(this).find('a').attr('href');
                $(selectedTab).show();
                return false;
            });
        });
    </script>
</head>
<body>
    <div class="header">
        <h1>病院ダッシュボード</h1>
        <form action="logout.php" method="POST" style="float: right;">
            <button type="submit" class="logout-btn">ログアウト</button>
        </form>
    </div>

    <!-- タブメニュー -->
    <ul class="tabs">
        <li><a href="#vendor-list">ベンダ一覧</a></li>
        <li><a href="#reviews">レビュー</a></li>
        <li><a href="#knowledge-base">ナレッジベース</a></li>
    </ul>

    <!-- ベンダ一覧タブ -->
    <div id="vendor-list" class="tab-content">
        <h2>ベンダ一覧</h2>
        <!-- フィルタリングフォーム -->
        <form action="hospital_dashboard.php" method="POST">
            <label for="genre">提案ジャンルで絞り込む:</label>
            <select name="genre">
                <option value="">すべて</option>
                <option value="IT・デジタルソリューション">IT・デジタルソリューション</option>
                <option value="インフラストラクチャー">インフラストラクチャー</option>
                <option value="医療機器・ハードウェア">医療機器・ハードウェア</option>
                <option value="セキュリティ・コンプライアンス">セキュリティ・コンプライアンス</option>
                <option value="AI・データ分析ソリューション">AI・データ分析ソリューション</option>
                <option value="ロボティクス・自動化">ロボティクス・自動化</option>
                <option value="IoT・スマート病院ソリューション">IoT・スマート病院ソリューション</option>
                <option value="患者エクスペリエンス向上ソリューション">患者エクスペリエンス向上ソリューション</option>
                <option value="ファシリティ管理ソリューション">ファシリティ管理ソリューション</option>
            </select>
            
            <label for="review_score">レビュー点数以上で絞り込む:</label>
            <select name="review_score">
                <option value="">すべて</option>
                <option value="1">1以上</option>
                <option value="2">2以上</option>
                <option value="3">3以上</option>
                <option value="4">4以上</option>
                <option value="5">5</option>
            </select>
            
            <label for="iso_certification">ISO取得状況で絞り込む:</label>
            <select name="iso_certification">
                <option value="">すべて</option>
                <option value="1">取得済み</option>
                <option value="0">未取得</option>
            </select>
            
            <button type="submit">絞り込む</button>
        </form>

        <ul>
            <?php foreach ($vendors as $vendor): ?>
                <li>
                    <strong>名前:</strong> <?= $vendor['name'] ?><br>
                    <strong>レビュー:</strong> <?= $vendor['review_score'] ?><br>
                    <strong>ISO取得状況:</strong> <?= $vendor['iso_certification'] ? '取得済み' : '未取得' ?><br>
                    <strong>ホームページ:</strong> <a href="<?= $vendor['homepage'] ?>" target="_blank">リンク</a><br>
                    <strong>提案ジャンル:</strong> <?= $vendor['genre'] ?><br>
                    <button>見積依頼</button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- レビューページタブ -->
    <div id="reviews" class="tab-content">
        <h2>レビュー</h2>
        <ul>
            <?php foreach ($reviews as $review): ?>
                <li>
                    <strong>ベンダー名:</strong> <?= $review['vendor_name'] ?><br>
                    <strong>レビュー:</strong> <?= $review['review_text'] ?><br>
                    <strong>評価:</strong> <?= $review['rating'] ?>/5
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- ナレッジベースタブ -->
    <div id="knowledge-base" class="tab-content">
        <h2>ナレッジベース</h2>
        <p>過去の提案内容や事業者の評価を蓄積し、次回以降の選定に役立てることができます。</p>
    </div>
</body>
</html>
