<?php
// fetch_purchases.php
include 'database.php';

// Récupérer tous les achats
$sql = "SELECT ACHAT.*, MAGASIN.name AS magasin_name FROM ACHAT LEFT JOIN MAGASIN ON ACHAT.id_magasin = MAGASIN.id ORDER BY date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Générer le tableau d'historique des achats
foreach ($purchases as $purchase) {
    echo "<tr>
            <td>" . date("d/m/Y", strtotime($purchase['date'])) . "</td>
            <td>" . htmlspecialchars($purchase['description']) . "</td>
            <td>" . htmlspecialchars($purchase['prix']) . " €</td>
            <td>" . htmlspecialchars($purchase['magasin_name']) . "</td>
            <td>" . htmlspecialchars($purchase['acheteur']) . "</td>
            <td>" . htmlspecialchars($purchase['remarque']) . "</td>
            <td><button class='btn btn-danger btn-sm' onclick='deletePurchase(" . $purchase['id'] . ")'>Supprimer</button></td>
          </tr>";
}

// Séparateur pour indiquer la fin de l'historique des achats
echo "||";

// Calculer la dépense totale par acheteur
$sql_total = "SELECT acheteur, SUM(prix) as total FROM ACHAT GROUP BY acheteur";
$stmt_total = $pdo->prepare($sql_total);
$stmt_total->execute();
$totals = $stmt_total->fetchAll(PDO::FETCH_ASSOC);

// Générer le tableau de dépenses totales
foreach ($totals as $total) {
    echo "<tr>
            <td>" . htmlspecialchars(number_format($total['total'], 2)) . " €</td>
            <td>" . htmlspecialchars($total['acheteur']) . "</td>
          </tr>";
}
?>
