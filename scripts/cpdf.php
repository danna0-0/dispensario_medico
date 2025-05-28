<?php
include '../php/db_connection.php';
require '../php/pdf.php';

// Función para validar los datos recibidos
function validarDatos($data) {
    return trim(htmlspecialchars($data));
}

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener fechas del formulario
    $fecha_inicio = validarDatos($_POST['fecha_inicio']);
    $fecha_fin = validarDatos($_POST['fecha_fin']);

    // Consulta a la base de datos
    $sql = "SELECT p.id_pacientes, p.nombre, p.apellidos, d.fecha
            FROM pacientes p
            JOIN diagnostico d ON p.id_pacientes = d.id_pacientes
            WHERE d.fecha BETWEEN ? AND ?
            ORDER BY d.fecha ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $fecha_inicio, $fecha_fin);
    $stmt->execute();
    $result = $stmt->get_result();

    $pacientes = [];
    if ($result->num_rows > 0) {
        $i = 1;
        while ($row = $result->fetch_assoc()) {
            $pacientes[] = [
                'numero' => $i,
                'nombre' => $row['nombre'],
                'apellidos' => $row['apellidos'],
                'fecha' => $row['fecha']
            ];
            $i++;
        }
    } else {
        echo "No se encontraron pacientes en ese rango de fechas.";
        exit;
    }

    $stmt->close();
    $conn->close();
}

// Generación del PDF
$pdf = new PDF();
$header = array('#', 'Nombre', 'Apellidos', 'Fecha de Consulta');
$pdf->AddPage();
$pdf->SetFont('Arial','',14);
$pdf->GeneratePatientTable($header, $pacientes);
$pdf->Output();
?>
