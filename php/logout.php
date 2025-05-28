<?php
session_start();
include 'db_connection.php';

// Cerrar la sesión
session_unset();
session_destroy();

// Cerrar la conexión a la base de datos
if (isset($conn)) {
    $conn->close();
}

// Redirigir a la página de login
header('Location: ../views/login.php');
exit();
?>