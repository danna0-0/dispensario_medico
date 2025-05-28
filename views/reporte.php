<?php 
session_start(); // Iniciar la sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Si el usuario no está logueado, redirigir a la página de login
    header('Location: login.php');
    exit();
}

include '../php/reporte_handler.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Conexión de Css -->
    <link rel="stylesheet" href="../css/estilo_reporte.css">
    <!-- Fuente de Google -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap">
    <!-- CDN de Bootstrap para incluir los estilos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Iconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Documentación</title>
</head>
<body>
    <!-- Menu superior -->
    <header class="d-flex flex-wrap justify-content-center py-1 mb-4 border-bottom">
        <a href="" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <i id="icono" class="bi bi-clipboard2-pulse"></i>
            <span class="fs-4" id="nombreUsuario">
              <?php echo htmlspecialchars($user['nombres'] . ' ' . $user['apellidos']); ?> 
            </span>
        </a>
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="inicio.php" class="nav-link active" aria-current="page">Dispensario Medico</a></li>
            <li class="nav-item"><a href=" " class="nav-link">Reporte</a></li>
            <li id="salir" class="btn btn-outline-danger"><a href="../php/logout.php" class="nav-link">Salir</a></li>
        </ul>
    </header>

    <h1>Buscar Pacientes Atendidos</h1>
    <form class="contenedor" method="POST" action="../scripts/cpdf.php">
        <label class="fil" for="fecha_inicio">Fecha de Inicio:</label>
        <input class="fi" type="date" id="fecha_inicio" name="fecha_inicio" required><br><br>
        <label class="fnl" for="fecha_fin">Fecha de Fin:</label>
        <input class="fn" type="date" id="fecha_fin" name="fecha_fin" required><br><br>
        <input class="btngenerarpdf" type="submit" value="Generar PDF"> 
    </form>
</body>
</html>
