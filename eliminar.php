<?php
include_once 'config.php';

// Obtener el id del producto a eliminar
$id = $_GET['id'];

if ($id) {
    // Eliminar el producto por su id
    $sql = "DELETE FROM Productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    header("Location: index.php");
    exit();
} else {
    echo "ID de producto no proporcionado.";
}
?>
