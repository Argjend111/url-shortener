<?php
include "../config/db.php";

$code = $_GET['c'] ?? '';
$stmt = $conn->prepare("SELECT * FROM links WHERE short_code = ? LIMIT 1");
$stmt->bind_param("s", $code);
$stmt->execute();
$result = $stmt->get_result();
$link = $result->fetch_assoc();

if ($link) {
    if ($link['expires_at'] && strtotime($link['expires_at']) < time()) {
        echo "Link expired!";
        exit;
    }
    $conn->query("UPDATE links SET clicks = clicks + 1 WHERE id=" . $link['id']);
    header("Location: " . $link['original_url']);
    exit;
} else {
    echo "Invalid link!";
}
