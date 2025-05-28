<?php
$servername = "localhost";
$username = "root";
$password = "hOLA";
$dbname = "dispensario_medico";
$port="3306";
// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error . " (" . $conn->connect_errno . ")");
} else {
    echo "Conexión exitosa";
}
 ?>