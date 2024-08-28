<?php
// add_purchase.php
include 'database.php';

if ($_POST['action'] == 'addMagasin') {
    $name = $_POST['name'];
    $stmt = $pdo->prepare("INSERT INTO MAGASIN (name) VALUES (?)");
    $stmt->execute([$name]);
    echo "Magasin ajouté avec succès.";
    exit;
}

$date = $_POST['date'];
$description = $_POST['description'];
$prix = $_POST['prix'];
$acheteur = $_POST['acheteur'];
$remarque = $_POST['remarque'];
$id_magasin = $_POST['id_magasin'];

// Insérer les données de l'achat dans la base de données
$sql = "INSERT INTO ACHAT (date, description, prix, id_magasin, acheteur, remarque) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$date, $description, $prix, $id_magasin, $acheteur, $remarque]);

echo "Achat ajouté avec succès.";
?>
