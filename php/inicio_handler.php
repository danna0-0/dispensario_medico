<?php
session_start(); // Iniciar la sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Si el usuario no está logueado, redirigir a la página de login
    header('Location: ../views/login.php');
    exit();
}

include 'db_connection.php';
include 'user_data.php';

// Obtener los datos del usuario actual
$userId = 1; 
$user = getUserData($conn, $userId);

// Función para validar los datos recibidos
function validarDatos($data) {
    return trim(htmlspecialchars($data));
}

$resultado = ''; // Variable para almacenar el resultado del registro
$resultado_busqueda = ''; // Variable para almacenar el resultado de la búsqueda

// Manejar el registro de pacientes, diagnóstico y emergencia
if (isset($_POST['registro'])) {
    // Verificar si los campos requeridos no están vacíos
    if (!empty($_POST['nombre']) && !empty($_POST['apellidos']) && !empty($_POST['fecha_nacimiento']) && !empty($_POST['peso']) && !empty($_POST['tipoRH']) && !empty($_POST['alergias']) && !empty($_POST['P_A']) && !empty($_POST['diagnostico']) && !empty($_POST['tratamiento']) && !empty($_POST['valoracion_medica']) && !empty($_POST['fecha'])) {
        // Validar y sanitizar los datos recibidos
        $nombre = validarDatos($_POST['nombre']);
        $apellidos = validarDatos($_POST['apellidos']);
        $fecha_nacimiento = validarDatos($_POST['fecha_nacimiento']);
        $peso = validarDatos($_POST['peso']);
        $tipoRH = validarDatos($_POST['tipoRH']);
        $alergias = validarDatos($_POST['alergias']);
        $P_A = validarDatos($_POST['P_A']);
        $diagnostico = validarDatos($_POST['diagnostico']);
        $tratamiento = validarDatos($_POST['tratamiento']);
        $valoracion_medica = validarDatos($_POST['valoracion_medica']);
        $fecha = validarDatos($_POST['fecha']);
        $tipo_emergencia = !empty($_POST['tipo_emergencia']) ? validarDatos($_POST['tipo_emergencia']) : null;
        $traslado = !empty($_POST['traslado']) ? validarDatos($_POST['traslado']) : null;

        // Iniciar una transacción
        $conn->begin_transaction();

        try {
            // Insertar el paciente
            $consulta_paciente = $conn->prepare("INSERT INTO pacientes (nombre, apellidos, fecha_nacimiento, peso, tipoRH, alergias, P_A) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if (!$consulta_paciente) {
                throw new Exception("Error en la preparación de la consulta de paciente: " . $conn->error);
            }
            $consulta_paciente->bind_param("sssissi", $nombre, $apellidos, $fecha_nacimiento, $peso, $tipoRH, $alergias, $P_A);
            $consulta_paciente->execute();

            // Obtener el ID del nuevo paciente
            $id_paciente = $consulta_paciente->insert_id;

            // Insertar el diagnóstico para el nuevo paciente
            $consulta_diagnostico = $conn->prepare("INSERT INTO diagnostico (diagnostico, tratamiento, valoracion_medica, fecha, id_pacientes) VALUES (?, ?, ?, ?, ?)");
            if (!$consulta_diagnostico) {
                throw new Exception("Error en la preparación de la consulta de diagnóstico: " . $conn->error);
            }
            $consulta_diagnostico->bind_param("ssssi", $diagnostico, $tratamiento, $valoracion_medica, $fecha, $id_paciente);
            $consulta_diagnostico->execute();

            // Insertar la emergencia para el nuevo paciente
            $consulta_emergencia = $conn->prepare("INSERT INTO emergencia (tipo_emergencia, traslado, id_pacientes) VALUES (?, ?, ?)");
            if (!$consulta_emergencia) {
                throw new Exception("Error en la preparación de la consulta de emergencia: " . $conn->error);
            }
            $consulta_emergencia->bind_param("ssi", $tipo_emergencia, $traslado, $id_paciente);
            $consulta_emergencia->execute();

            // Confirmar la transacción
            $conn->commit();

            // Mostrar el mensaje según el resultado de la consulta
            $resultado = '<h4 class="guardado">Guardado</h4>';

        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $conn->rollback();
            $resultado = '<h4 class="error">Error: ' . $e->getMessage() . '</h4>';
        }

        // Cerrar las consultas
        if ($consulta_paciente) $consulta_paciente->close();
        if ($consulta_diagnostico) $consulta_diagnostico->close();
        if ($consulta_emergencia) $consulta_emergencia->close();
    } else {
        // Mensaje de error si los campos están vacíos
        $resultado = '<h4 class="sn">Por favor complete los campos</h4>';
    }
}

// Manejar la búsqueda de pacientes
if (isset($_POST['searchQuery'])) {
    $searchQuery = validarDatos($_POST['searchQuery']);

    // Consultar en la base de datos con JOIN y concatenar nombre y apellidos
    $consulta = $conn->prepare(
        "SELECT pacientes.id_pacientes, pacientes.nombre, pacientes.apellidos, diagnostico.fecha, emergencia.tipo_emergencia
         FROM pacientes 
         JOIN diagnostico ON pacientes.id_pacientes = diagnostico.id_pacientes 
         JOIN emergencia ON pacientes.id_pacientes = emergencia.id_pacientes
         WHERE CONCAT(pacientes.nombre, ' ', pacientes.apellidos) LIKE ?"
    );

    if ($consulta === false) {
        die('Error en la preparación de la sentencia: ' . $conn->error);
    }

    $param = "%" . $searchQuery . "%";
    $consulta->bind_param("s", $param);

    $consulta->execute();
    $resultado_busqueda = $consulta->get_result();

    if ($resultado_busqueda->num_rows > 0) {
        $tabla_resultado = '
            <div class="table-container" style="width:36%; border: 3px solid #e1e1e1; border-radius: 9px; margin-top: -10px;">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Fecha de Consulta</th>
                        <th scope="col">Tipo de Emergencia</th>
                        <th scope="col">Detalles</th>
                    </tr>
                </thead>
            <tbody>
        ';
        while ($fila = $resultado_busqueda->fetch_assoc()) {
            $tabla_resultado .= '
            <tr>
                <td>' . htmlspecialchars($fila['nombre']) . '</td>
                <td>' . htmlspecialchars($fila['apellidos']) . '</td>
                <td>' . htmlspecialchars($fila['fecha']) . '</td>
                <td>' . htmlspecialchars($fila['tipo_emergencia']) . '</td>
                <td>
                    <button type="button" class="btn btn-sm custom-btn" onclick="loadPatientDetails(' . htmlspecialchars($fila['id_pacientes']) . ')">
                    <i class="bi bi-info-circle" style="background-color:none; color:rgb(197, 197, 197); border-radius: 5px; padding: 2px;"></i>
                    </button>
                </td>
            </tr>
            ';
        }

        $tabla_resultado .= '
                </tbody>
            </table>
        </div>
        ';
    } else {
        $tabla_resultado = '<p class="table-container">No se encontraron registros.</p>';
    }
}
?>