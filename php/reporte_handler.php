<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Iniciar la sesión si no está ya iniciada
}
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Si el usuario no está logueado, redirigir a la página de login
    header('Location: ../views/login.php');
    exit();
}

include 'db_connection.php';
include 'user_data.php';

// Obtener los datos del usuario actual
$userId = 1; // Ajusta esto según tu lógica de autenticación
$user = getUserData($conn, $userId);
?>