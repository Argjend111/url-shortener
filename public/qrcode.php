<?php
include "../config/db.php";

$code = $_GET['c'] ?? '';

if (!$code) {
    die("Invalid short code");
}

$stmt = $conn->prepare("SELECT original_url FROM links WHERE short_code = ?");
$stmt->bind_param("s", $code);
$stmt->execute();
$result = $stmt->get_result();
$link = $result->fetch_assoc();

if (!$link) {
    die("Link not found.");
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
    <img src="<?= $qrApi ?>" alt="QR Code">
    <p><a href="<?= $qrApi ?>" download="qrcode.png">Download QR Code</a></p>
</body>

</html>