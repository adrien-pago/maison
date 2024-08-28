<?php
// add_purchase.php
include 'database.php';

$date = $_POST['date'];
$description = $_POST['description'];
$prix = $_POST['prix'];
$magasin = $_POST['magasin'];
$acheteur = $_POST['acheteur'];

$sql = "INSERT INTO ACHAT (date, description, prix, magasin, acheteur) VALUES (?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$date, $description, $prix, $magasin, $acheteur]);

echo "Achat ajouté avec succès.";
?>
