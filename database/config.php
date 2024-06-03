<?php
$host       = "bd-abb.privatelink.mysql.database.azure.com";
$username   = "raul";
$password   = "38RaCasar99*";
$db_name     = "products";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
