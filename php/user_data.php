<?php
function getUserData($conn, $userId) {
// Preparar la consulta SQL para obtener los nombres y apellidos del usuario basado en su ID
    $query = "SELECT nombres, apellidos FROM registro WHERE id_doctor = ?";
    $stmt = $conn->prepare($query);

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }

    // Vincular el parámetro ID del usuario a la consulta
    $stmt->bind_param("i", $userId);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();

    // Obtener los datos del usuario como un array asociativo
    $user = $result->fetch_assoc();

    // Cerrar la consulta
    $stmt->close();

    // Devolver los datos del usuario
    return $user;
}
?>