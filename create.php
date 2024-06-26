<?php
include_once 'config.php';

$nombre = $_POST['nombre'];
$nombrePadre = $_POST['nombrePadre'];
$descripcion = $_POST['descripcion'];

$sql = "INSERT INTO Productos (nombre, nombrePadre, descripcion) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt->execute([$nombre, $nombrePadre, $descripcion])) {
    $id = $conn->lastInsertId();
    echo json_encode(['success' => true, 'id' => $id, 'nombre' => $nombre, 'nombrePadre' => $nombrePadre, 'descripcion' => $descripcion]);
} else {
    echo json_encode(['success' => false]);
}
?>
