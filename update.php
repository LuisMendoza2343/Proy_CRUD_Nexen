<?php
include_once 'config.php';

// Verificar si se ha enviado el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $nombrePadre = $_POST['nombrePadre'];
    $descripcion = $_POST['descripcion'];

    // Actualizar los datos del producto
    $sql = "UPDATE Productos SET nombre = ?, nombrePadre = ?, descripcion = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nombre, $nombrePadre, $descripcion, $id]);

    // Redireccionar de vuelta a index.php después de la actualización
    header("Location: index.php");
    exit();
} else {
    // Si no es un POST, redireccionar a index.php
    header("Location: index.php");
    exit();
}
?>
