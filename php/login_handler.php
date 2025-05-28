<?php
require_once 'db_connection.php';
session_start(); // Iniciar la sesión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    // Verificar si los campos están vacíos
    if (empty($usuario) || empty($clave)) {
        $error = "CAMPOS VACÍOS";
    } else {
        // Preparar la consulta
        $sql = "SELECT * FROM registro WHERE usuario = ? AND clave = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $usuario, $clave);

        // Ejecutar y verificar resultados
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Login exitoso: redirigir a inicio.php
            $_SESSION['loggedin'] = true; // Añadir esta línea
            $_SESSION['usuario'] = $usuario; // Guardar el usuario en la sesión
            header("Location: ../views/inicio.php");
            exit();
        } else {
            // Login fallido: mostrar mensaje de error
            $error = "USUARIO O CONTRASEÑA INCORRECTOS";
        }

        $stmt->close();
    }

    $conn->close();
}
?>