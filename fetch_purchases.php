<?php
// fetch_purchases.php
include 'database.php';

$sql = "SELECT * FROM ACHAT ORDER BY date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($purchases as $purchase) {
    echo "<tr>
            <td>" . htmlspecialchars($purchase['date']) . "</td>
            <td>" . htmlspecialchars($purchase['description']) . "</td>
            <td>" . htmlspecialchars($purchase['prix']) . " €</td>
            <td>" . htmlspecialchars($purchase['magasin']) . "</td>
            <td>" . htmlspecialchars($purchase['acheteur']) . "</td>
          </tr>";
}
?>
