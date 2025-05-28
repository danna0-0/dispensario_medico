<?php include '../php/inicio_handler.php'; ?>

<!DOCTYPE html>
<html lang="en"> 
    <head> 
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <!-- CDN de Bootstrap para incluir los estilos de Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- JS de Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybSku7F7Sqv7i6E/fE1ARjx2s7/j6fMOc8+J6fFs2+Nw6HgJ3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJQu5FT26eyJPz3eGkRrZA5gs7rtp3fQ4I1piGKWs/Z3yM" crossorigin="anonymous"></script>

        <!-- CDN de Bootstrap para incluir los estilos de Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
        <!-- Iconos de Bootstrap --> 
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
        <!-- Fuente de Google --> 
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap"> 
        <!-- Link de CSS --> 
        <link rel="stylesheet" type="text/css" href="../css/estilo.css"> 
        <title>Inicio</title> 
        <!-- Script para calcular la edad -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const fechaNacimiento = document.getElementById('fecha_nacimiento');
                const edad = document.getElementById('edad');
                fechaNacimiento.addEventListener('change', function() {
                    const hoy = new Date();
                    const nacimiento = new Date(fechaNacimiento.value);
                    let años = hoy.getFullYear() - nacimiento.getFullYear();
                    const mes = hoy.getMonth() - nacimiento.getMonth();
                    if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
                        años--;
                    }
                    edad.value = años;
                });
            });
        </script>
        <!-- Script para buscar pacientes -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.querySelector('.searchContainer');
                searchInput.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        const searchQuery = searchInput.value.trim();
                        if (searchQuery) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.style.display = 'none';
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'searchQuery';
                            input.value = searchQuery;
                            form.appendChild(input);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    }
                });
            });
        </script>
            <!-- Script para mostrar los datos -->
      <script>
            function loadPatientDetails(id_pacientes) {
                console.log('loadPatientDetails llamado con id_pacientes:', id_pacientes);
                fetch('get_patient_details.php?id_pacientes=' + id_pacientes)
                    .then(response => response.text())
                    .then(text => {
                        console.log('Respuesta de fetch:', text);
                        try {
                            const data = JSON.parse(text);
                            if (data.error) {
                                console.error(data.error);
                            } else {
                                document.getElementById('diagnostico').innerText = data.diagnostico || 'N/A';
                                document.getElementById('tratamiento').innerText = data.tratamiento || 'N/A';
                                document.getElementById('valoracion_medica').innerText = data.valoracion_medica || 'N/A';
                                document.getElementById('pacienteDetalles').classList.remove('d-none');
                            }
                        } catch (error) {
                            console.error('Error al analizar JSON:', error);
                        }
                    })
                    .catch(error => console.error('Error en la solicitud fetch:', error));

                    document.getElementById('cerrarDetalle').addEventListener('click', function() {
                    document.getElementById('pacienteDetalles').classList.add('d-none');
                     });
            }
        </script>
    </head>
<body> 
   <!-- Menu superior -->
    <header class="d-flex flex-wrap justify-content-center py-1 mb-4 border-bottom">
        <a href="" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <i class="bi bi-clipboard2-pulse"></i>
            <span class="fs-4" id="nombreUsuario">
                <?php 
                // Obtener los datos del usuario actual
                $userId = 1; // Ajusta esto según tu lógica de autenticación
                $query = "SELECT nombres, apellidos FROM registro WHERE id_doctor = ?";
                $stmt = $conn->prepare($query);
                if ($stmt === false) {
                    die('Error en la preparación de la consulta: ' . $conn->error);
                }
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                echo htmlspecialchars($user['nombres'] . ' ' . $user['apellidos']); 
                ?>
            </span>
        </a>
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Dispensario Medico</a></li>
            <li class="nav-item"><a href="reporte.php" class="nav-link">Reporte</a></li>
        </ul>
    </header>

    <!--Aquí van datos de los pacientes que ya estan ingresados-->
    <div id="pacienteDetalles" class="details-container d-none">
    <i id="cerrarDetalle" class="bi bi-x-circle" style="align-self: flex-end; margin-right: 5px; cursor: pointer;"></i>
            <!-- Aquí irán los detalles del paciente -->
       <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <i class="bi bi-journal-medical"></i>
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <h6 class="mb-0">Diagnóstico</h6>
                            <p class="mb-0 opacity-75" id="diagnostico">N/A</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <i class="bi bi-journal-medical"></i>
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <h6 class="mb-0">Tratamiento</h6>
                            <p class="mb-0 opacity-75" id="tratamiento">N/A</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                    <i class="bi bi-journal-medical"></i>
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <h6 class="mb-0">Valoración Médica</h6>
                            <p class="mb-0 opacity-75" id="valoracion_medica">N/A</p>
                        </div>
                    </div>
                </a>
       </div>
    </div>

    <style>
        #pacienteDetalles {
        flex-grow: 1;
        height: auto;
        border-radius: 30px;
        flex-basis: 39%;
        display: flex;
        flex-direction: column;
        margin-left: 60%;
        align-items: absolute;
        padding: 10px;
        background-color: #f8f9fa;
        border: 1px solid #e1e1e1;
        overflow: hidden;
        transition: all 0.3s ease;
        max-width: 400px;
        margin-top: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        position: absolute; 
        z-index: 10; 
        }

        /* Estilo para los elementos de la lista */
        .list-group-item {
        padding: 10px;
        font-size: 14px;
        max-width: 100%;
        overflow-wrap: break-word;
        }
    </style>

    <!-- Buscador --> 
    <div class="search" style="position: relative;"> 
        <div class="barra"> 
            <i id="Lupa" class="bi bi-search"></i> 
            <input class="searchContainer" type="text" placeholder="Buscar"> 
        </div> 
    </div> 

          <!-- Modal de Bootstrap -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detalles del Paciente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Diagnostico:</strong> <span id="diagnostico"></span></p>
                        <p><strong>Tratamiento:</strong> <span id="tratamiento"></span></p>
                        <p><strong>Valoracion Medica:</strong> <span id="valoracion_medica"></span></p>
                        <p><strong>Emergencia:</strong> <span id="tipo_emergencia"></span></p>
                        <p><strong>Traslado:</strong> <span id="traslado"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    <!-- Formulario de pacientes --> 
    <form class="row g-3 needs-validation" method="post" novalidate> 
        <!-- Fecha --> 
        <div class="col-md-3"> 
            <label for="fecha" class="form-label">Fecha</label> 
            <input type="date" class="form-control" id="fecha" name="fecha" required> 
        </div> 
                <!-- P_A --> 
        <div class="col-md-3"> 
            <label for="P_A" class="form-label">Presión Arterial</label> 
            <input type="text" class="form-control" id="P_A" name="P_A" required> 
        </div> 
                <!-- Pedir datos al paciente --> 
        <div class="row g-3"> 
            <div class="col-md-6"> 
                <label for="nombre" class="form-label">Nombre</label> 
                <input type="text" class="form-control" id="nombre" name="nombre" required> 
            </div> 
            <div class="col-md-6"> 
                <label for="apellidos" class="form-label">Apellidos</label> 
                <input type="text" class="form-control" id="apellidos" name="apellidos" required> 
            </div> 
        </div> 
                <!-- Apartado de fecha de nacimiento --> 
        <div class="col-md-3"> 
            <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label> 
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required> 
        </div> 
                <!-- Edad --> 
        <div class="col-md-3"> 
            <label for="edad" class="form-label">Edad</label> 
            <input type="text" class="form-control" id="edad" name="edad" readonly> 
        </div> 
                <!-- Peso --> 
        <div class="col-md-3"> 
            <label for="peso" class="form-label">Peso</label> 
            <input type="text" class="form-control" id="peso" name="peso" required> 
        </div> 
                <!-- Tipo de sangre --> 
        <div class="col-md-3"> 
            <label for="tipoRH" class="form-label">Tipo RH</label> 
            <select class="form-select" id="tipoRH" name="tipoRH" required> 
                <option selected disabled value=""> </option> 
                <option>A+</option> 
                <option>B+</option> 
                <option>AB+</option> 
                <option>O+</option> 
                <option>A-</option> 
                <option>B-</option> 
                <option>AB-</option> 
                <option>O-</option> 
            </select> 
        </div> 
                <!-- Apartado de Alergias --> 
        <div class="col-md-6"> 
            <label for="alergias" class="form-label">Alergias</label> 
            <input type="text" class="form-control" id="alergias" name="alergias" required> 
        </div> 
                <!-- Parte del Diagnóstico --> 
        <div class="col-md-6"> 
            <label for="diagnostico" class="form-label">Diagnóstico</label> 
            <input type="text" class="form-control" id="diagnostico" name="diagnostico"> 
        </div> 
                <!-- Tratamiento --> 
        <div class="col-md-12"> 
            <label for="tratamiento" class="form-label">Tratamiento</label> 
            <input type="text" class="form-control" id="tratamiento" name="tratamiento"> 
        </div> 
                <!-- Poner observaciones de la valoración médica --> 
        <div class="col-md-12"> 
            <label for="valoracion_medica" class="form-label">Valoración médica</label> 
            <input type="text" class="form-control" id="valoracion_medica" name="valoracion_medica"> 
        </div> 
                <!--Emergencia-->
        <div class="col-md-12">
            <label for="emergencia" class="form-label">Emergencia</label>
            <input type="text" class="form-control" id="emergencia" name="tipo_emergencia"> 
        </div>
        <div class="left">
            <!--Traslado-->
            <div class="col-md-3">
                <label for="traslado" class="form-label">Traslado</label> 
                <select class="form-select" id="traslado" name="traslado" required> 
                    <option selected disabled value=""> </option>
                    <option>Sin traslado</option>
                    <option>Hospital General Dr. Jesús Gilberto Gómez Maza</option>
                    <option>ISSTECH</option>
                    <option>Seguro Social</option>
                </select>
            </div>
        </div>
        <!-- Botón para guardar datos --> 
        <div class="col-12"> 
            <button id="btng" class="btn btn-primary" type="submit" name="registro">Guardar</button> 
            <?php if ($resultado) echo "<div style='margin-top: 10px; background-color:#6df052;  border-radius: 30px;   width: 21%; align-items: center; text-align: center; color:rgb(255, 255, 255);'>$resultado</div>"; ?> 
        </div> 
    </form> 
    <!-- Fin formulario -->
    <!--Tabla-->
    <?php if (isset($tabla_resultado)) echo $tabla_resultado; ?>
    <!-- Fin tabla de pacientes -->
</body> 
</html>