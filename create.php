<?php
include_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $nombrePadre = $_POST['nombrePadre'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO Productos (nombre, nombrePadre, descripcion) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$nombre, $nombrePadre, $descripcion])) {
        $productoId = $conn->lastInsertId(); // Obtén el ID del nuevo producto
        $response = [
            'success' => true,
            'producto' => [
                'id' => $productoId,
                'nombre' => $nombre,
                'nombrePadre' => $nombrePadre,
                'descripcion' => $descripcion,
            ]
        ];
        echo json_encode($response);
        
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no permitido.']);
}

?>