<?php
// database.php
$host = 'localhost:3306';
$dbname = 'BO_portfolio';
$username = 'BO_portfolio_root_ap';
$password = 'Q90mgoxv1^vVGpm&';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
