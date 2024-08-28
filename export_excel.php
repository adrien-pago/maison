<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// export_excel.php

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include 'database.php';

// Créer un nouvel objet Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Définir les en-têtes pour le fichier Excel
$sheet->setCellValue('A1', 'Date');
$sheet->setCellValue('B1', 'Description');
$sheet->setCellValue('C1', 'Prix (€)');
$sheet->setCellValue('D1', 'Magasin');
$sheet->setCellValue('E1', 'Acheteur');
$sheet->setCellValue('F1', 'Remarque');

// Récupérer les achats de la base de données
$sql = "SELECT ACHAT.*, MAGASIN.name AS magasin_name FROM ACHAT LEFT JOIN MAGASIN ON ACHAT.id_magasin = MAGASIN.id ORDER BY date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Remplir les données dans le fichier Excel
$row = 2; // Commencer à partir de la deuxième ligne pour ne pas écraser les en-têtes
foreach ($purchases as $purchase) {
    $sheet->setCellValue('A' . $row, date("d/m/Y", strtotime($purchase['date'])));
    $sheet->setCellValue('B' . $row, $purchase['description']);
    $sheet->setCellValue('C' . $row, number_format($purchase['prix'], 2) . ' €');
    $sheet->setCellValue('D' . $row, $purchase['magasin_name']);
    $sheet->setCellValue('E' . $row, $purchase['acheteur']);
    $sheet->setCellValue('F' . $row, $purchase['remarque']);
    $row++;
}

// Générer un nom de fichier unique
$fileName = 'Achats_' . date('Y-m-d_H-i-s') . '.xlsx';

// Définir les en-têtes HTTP pour le téléchargement du fichier
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Cache-Control: max-age=0');

// Créer un writer pour le fichier Excel
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
