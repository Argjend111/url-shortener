<?php
include "../config/db.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $url = $_POST['url'];
    $expiry = $_POST['expiry'];
    $shortCode = substr(md5(uniqid()), 0, 6);
    $expiresAt = null;

    if ($expiry) {
        $expiresAt = date("Y-m-d H:i:s", strtotime("+$expiry minutes"));
    }

    $stmt = $conn->prepare("INSERT INTO links (original_url, short_code, expires_at) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $url, $shortCode, $expiresAt);
    $stmt->execute();
}

$result = $conn->query("SELECT * FROM links ORDER BY id DESC");
$links = $result->fetch_all(MYSQLI_ASSOC);

$expResult = $conn->query("SELECT * FROM expirations ORDER BY minutes ASC");
$expirations = $expResult->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <aside>
            <img src="assets/logo.png" alt="Logo" class="logo">
            <div class="links-container">
                <h2>My shortened URLs</h2>
                <ul>
                    <?php foreach ($links as $link): ?>
                        <li>
                            <div class="link-item">
                                <a href="redirect.php?c=<?= $link['short_code'] ?>" target="_blank" class="short-link"
                                    data-id="<?= $link['id'] ?>" data-clicks="<?= $link['clicks'] ?>">
                                    https://shorturl.co/<?= $link['short_code'] ?>
                                </a>

                                <a href="delete.php?id=<?= $link['id'] ?>" class="icon-btn delete">
                                <i class="fa-regular fa-trash-can"></i>

                                    <span class="tooltip">Delete link</span>
                                </a>

                                <a href="qrcode.php?c=<?= $link['short_code'] ?>" target="_blank" class="icon-btn qr">
                                    <i class="fa-solid fa-qrcode"></i>
                                    <span class="tooltip">Show QR code</span>
                                </a>
                               
                                <span class="click-count" data-expires="<?= $link['expires_at'] ?>">
                                    This link has been clicked <?= $link['clicks'] ?> times.
                                </span>
                            </div>
                        </li>

                    <?php endforeach; ?>
                </ul>
            </div>
        </aside>

      <main>
    <h1>URL Shortener</h1>
  <form method="POST" class="shorten-form">
    <input type="url" name="url" placeholder="Paste the URL to be shortened" required>

    <select name="expiry">
        <option value="" >Add expiration date</option>
        <?php foreach ($expirations as $exp): ?>
            <option value="<?= htmlspecialchars($exp['minutes']) ?>">
                <?= htmlspecialchars($exp['label']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Shorten URL</button>
</form>

</main>
    </div>
<script src="script.js"></script>
</body>

</html>