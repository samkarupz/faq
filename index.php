<?php

// Database connection
$host = 'localhost';
$db   = 'faq_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
// Create a new PDO instance and handle connection errors
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    http_response_code(500);
    echo "Database connection failed: " . $e->getMessage();
    exit;
}

// Handle like action and return JSON response
$action = $_GET['action'] ?? '';
if ($action === 'like') {
    header('Content-Type: application/json');
    $id = $_GET['id'] ?? 0;
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        echo json_encode(['success' => false, 'error' => 'Invalid ID']);
        exit;
    }
    try {
        $stmt = $pdo->prepare("UPDATE faq SET likes_count = likes_count + 1 WHERE id = ?");
        $stmt->execute([$id]);
        $stmt = $pdo->prepare("SELECT likes_count FROM faq WHERE id = ?");
        $stmt->execute([$id]);
        $likes = $stmt->fetchColumn();

        echo json_encode(['success' => true, 'likes_count' => $likes]);
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'DB error']);
        exit;
    }
}

// Fetch FAQs from the database
$stmt = $pdo->query("SELECT id, title, content, likes_count FROM faq");
$faqs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>faq</title>
    <style>
        body { font-family: Arial; margin: 5% 25%; }
        .faq { border-bottom: 1px solid #ccc; padding: 1rem 0; }
        .like-btn { background: #00a2ffff; color: white; padding: 5px 10px; cursor: pointer; border: none; border-radius: 5px; }
        .like-btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h2>Frequently Asked Questions</h2>
    <div id="faq-list">
        <?php foreach ($faqs as $faq): ?>
            <div class="faq" data-id="<?= $faq['id'] ?>">
                <h3><?= htmlspecialchars($faq['title']) ?></h3>
                <p><?= nl2br(htmlspecialchars(substr($faq['content'], 0, 150))) ?>...</p>
                <p>Likes: <span class="like-count" id=faq-<?= $faq['id'] ?>><?= $faq['likes_count'] ?></span></p>
                <button class="like-btn" onclick="likeFAQ(<?= $faq['id'] ?>)">Like</button>
            </div>
        <?php endforeach; ?>
    </div>

<script>
    function likeFAQ(id) {
        fetch(`index.php?action=like&id=${id}`)
            .then(response => response.text())
            .then(data => {
                console.log("Raw response:", data);
                const json = JSON.parse(data);
                console.log(json);
                if (json.success) {
                    document.getElementById(`faq-${id}`).textContent= json.likes_count;        
                } else {
                    alert("Error: " + data.error);
                }
            });
    }
</script>
</body>
</html>
