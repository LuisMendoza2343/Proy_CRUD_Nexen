<?php
include_once 'config.php';

// Consultar datos para los desplegables
$catalogosSql = "SELECT DISTINCT nombre FROM Productos";
$catalogosStmt = $conn->query($catalogosSql);
if ($catalogosStmt === false) {
    die(print_r($conn->errorInfo(), true));
}

$marcasSql = "SELECT DISTINCT nombrePadre FROM Productos";
$marcasStmt = $conn->query($marcasSql);
if ($marcasStmt === false) {
    die(print_r($conn->errorInfo(), true));
}

$catalogos = $catalogosStmt->fetchAll(PDO::FETCH_COLUMN);
$marcas = $marcasStmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode(['catalogos' => $catalogos, 'marcas' => $marcas]);
?>
