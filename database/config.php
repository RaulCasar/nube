<?php
$host       = "10.0.1.4";
$username   = "raul";
$password   = "38RaCasar99*";
$db_name     = "products";

// Crear la conexión
$conn = new mysqli($host, $username, $password, $db_name);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
