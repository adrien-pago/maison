<?php
// fetch_magasins.php
include 'database.php';

$sql = "SELECT * FROM MAGASIN ORDER BY name ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$magasins = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Générer les options pour la combo box
foreach ($magasins as $magasin) {
    echo "<option value='" . htmlspecialchars($magasin['id']) . "'>" . htmlspecialchars($magasin['name']) . "</option>";
}
?>
