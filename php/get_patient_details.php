<?php
// Establecer el tipo de contenido de la respuesta como JSON
header('Content-Type: application/json');

// Incluir el archivo de conexión a la base de datos
include 'db_connection.php';

// Verificar si se ha proporcionado el ID del paciente en la solicitud GET
if (isset($_GET['id_pacientes'])) {
    // Convertir el ID del paciente a un entero para evitar inyecciones SQL
    $id_paciente = intval($_GET['id_pacientes']);

    // Preparar la consulta SQL para obtener los detalles del paciente
    $consulta = $conn->prepare("
        SELECT diagnostico, tratamiento, valoracion_medica 
        FROM diagnostico
        WHERE id_pacientes = ?
    ");
    
    // Verificar si la preparación de la consulta fue exitosa
    if ($consulta === false) {
        // Enviar una respuesta JSON con un mensaje de error
        echo json_encode(["error" => "Error en la preparación de la consulta: " . $conn->error]);
        exit;
    }

    // Vincular el parámetro ID del paciente a la consulta
    $consulta->bind_param("i", $id_paciente);
    
    // Ejecutar la consulta
    $consulta->execute();
    
    // Obtener el resultado de la consulta
    $resultado = $consulta->get_result();

    // Verificar si se encontraron resultados
    if ($resultado->num_rows > 0) {
        // Obtener los detalles del paciente como un array asociativo
        $paciente = $resultado->fetch_assoc();
        // Enviar una respuesta JSON con los detalles del paciente
        echo json_encode($paciente);
    } else {
        // Enviar una respuesta JSON indicando que no se encontraron detalles para el paciente
        echo json_encode(["error" => "No se encontraron detalles para el paciente."]);
    }

    // Cerrar la consulta
    $consulta->close();
} else {
    // Enviar una respuesta JSON indicando que no se proporcionó el ID del paciente
    echo json_encode(["error" => "No se proporcionó el ID del paciente."]);
}

// Cerrar la conexión a la base de datos
$conn->close();
exit;
?>


