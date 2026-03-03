<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Fetch all products
$products = $pdo->query("SELECT id, name, description, price, created_at FROM products ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

// Set headers for CSV download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=products_report.csv');

// Create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// Output the column headings
fputcsv($output, array('ID', 'Name', 'Description', 'Price (Rp)', 'Created At'));

// Loop over the rows, outputting them
foreach ($products as $product) {
    fputcsv($output, $product);
}

fclose($output);
exit;
?>
