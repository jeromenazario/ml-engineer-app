<?php
require_once 'config/database.php';

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: index.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

// Verify record exists before deleting
$check = $db->prepare("SELECT id FROM applicants WHERE id = :id LIMIT 1");
$check->bindParam(':id', $id, PDO::PARAM_INT);
$check->execute();

if ($check->rowCount() === 0) {
    header("Location: index.php");
    exit();
}

$query = "DELETE FROM applicants WHERE id = :id";
$stmt  = $db->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    header("Location: index.php?success=deleted");
} else {
    header("Location: index.php?error=delete_failed");
}
exit();
?>
