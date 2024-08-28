<?php
// add_purchase.php
include 'database.php';

$date = $_POST['date'];
$description = $_POST['description'];
$prix = $_POST['prix'];
$acheteur = $_POST['acheteur'];
$remarque = $_POST['remarque'];
$id_magasin = $_POST['id_magasin'];

// Si un nouveau magasin est ajouté
if ($id_magasin == 'new' && !empty($_POST['newMagasin'])) {
    $newMagasin = $_POST['newMagasin'];
    // Ajouter le nouveau magasin dans la base de données
    $stmt = $pdo->prepare("INSERT INTO MAGASIN (name) VALUES (?)");
    $stmt->execute([$newMagasin]);
    $id_magasin = $pdo->lastInsertId(); // Récupérer l'ID du nouveau magasin
}

// Insérer les données de l'achat dans la base de données
$sql = "INSERT INTO ACHAT (date, description, prix, id_magasin, acheteur, remarque) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$date, $description, $prix, $id_magasin, $acheteur, $remarque]);

echo "Achat ajouté avec succès.";
?>
