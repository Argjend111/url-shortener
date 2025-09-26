<?php
include "../config/db.php";

$id = $_GET['id'] ?? 0;
$conn->query("DELETE FROM links WHERE id = " . intval($id));

header("Location: index.php");
exit;
