<?php
include_once 'conexion.php';

// Obtener la conexión usando la clase Cconexion
$conn = Cconexion::ConexionBD();

// Verificar la conexión
if (!$conn) {
    die("Error en la conexión: No se pudo conectar a la base de datos.");
}
?>
