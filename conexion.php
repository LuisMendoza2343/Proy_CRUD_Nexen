<?php
class Cconexion {
    public static function ConexionBD() {
        $serverName = "localhost"; // Nombre del servidor SQL Server
        $connectionOptions = array(
            "Database" => "NexenBD", // Nombre de la base de datos
            "Uid" => "L_Serv",       // Usuario de SQL Server
            "PWD" => "1234"          // Contraseña de SQL Server
        );
        try {
            $conn = new PDO("sqlsrv:server=$serverName;Database={$connectionOptions['Database']}", $connectionOptions['Uid'], $connectionOptions['PWD']);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }
}
?>
