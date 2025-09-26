<?php
include "../config/db.php";

$id = $_POST['id'] ?? 0;

if ($id) {
    $stmt = $conn->prepare("UPDATE links SET clicks = clicks + 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $conn->query("SELECT clicks FROM links WHERE id = $id");
    $row = $result->fetch_assoc();

    echo json_encode(["success" => true, "clicks" => $row['clicks']]);
} else {
    echo json_encode(["success" => false]);
}
