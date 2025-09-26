<?php
include "../config/db.php";

$code = $_GET['c'] ?? '';

if (!$code) {
    echo "<script>alert('Invalid short code'); window.close();</script>";
    exit;
}

$stmt = $conn->prepare("SELECT original_url, expires_at FROM links WHERE short_code = ?");
$stmt->bind_param("s", $code);
$stmt->execute();
$result = $stmt->get_result();
$link = $result->fetch_assoc();

if (!$link) {
    echo "<script>alert('Link not found.'); window.close();</script>";
    exit;
}

if ($link['expires_at']) {
    $expiry = strtotime($link['expires_at']);
    $now = time();
    if ($now > $expiry) {
        $expiredDate = date("Y-m-d H:i:s", $expiry);
        echo "<script>alert('This QR code has expired!\\nExpired on: {$expiredDate}'); window.close();</script>";
        exit;
    }
}

$originalUrl = $link['original_url'];
$qrApi = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($originalUrl);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Code</title>
</head>
<body style="text-align:center; font-family:Arial;">
    <h2>QR Code for your link</h2>
    <img src="<?= $qrApi ?>" alt="QR Code">
    <p><a href="<?= $qrApi ?>" download="qrcode.png">Download QR Code</a></p>
</body>
</html>
