<?php
// delete_purchase.php
include 'database.php';

$id = $_POST['id'];

$sql = "DELETE FROM ACHAT WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

echo "Achat supprimé avec succès.";
?>
