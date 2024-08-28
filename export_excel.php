<?php
// export_excel.php
include 'database.php';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Achats.xlsx"');

$sql = "SELECT * FROM ACHAT ORDER BY date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Date\tDescription\tPrix (€)\tMagasin\tAcheteur\tRemarque\n";

foreach ($purchases as $purchase) {
    echo date("d/m/Y", strtotime($purchase['date'])) . "\t" . 
         $purchase['description'] . "\t" . 
         $purchase['prix'] . " €\t" . 
         $purchase['magasin'] . "\t" . 
         $purchase['acheteur'] . "\t" . 
         $purchase['remarque'] . "\n";
}
?>
