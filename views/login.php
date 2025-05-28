<?php
include '../php/login_handler.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <!-- Enlace a CSS-->
   <link rel="stylesheet" type="text/css" href="../css/style.css">
   <!-- Fuente de Google -->
   <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
   <!-- CDN de Bootstrap para incluir los estilos de Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
       integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <!-- Iconos de Bootstrap -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
   <!-- Otra fuente de Google -->
   <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap"
       rel="stylesheet">
   <!-- Icono de la página -->
   <link href="https://tresplazas.com/web/img/big_punto_de_venta.png" rel="shortcut icon">
   <!-- Enlace a Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   
   <!-- Título de la página -->
   <title>Inicio de sesión</title>
</head>
<body class="logo">
   <!-- Contenedor para la imagen del logo de la secretaría -->
   <div>
       <img src="../img/logo.jpg" alt="Logo" class="logo">
   </div>
   
   <!-- Imagen de fondo en forma de ola -->
   <img class="wave" src="../img/wave.png">

   <!-- Contenedor principal -->
   <div class="container">
      <div class="img">
         <!-- Imagen de fondo del formulario -->
         <img src="../img/bg.svg">
      </div>
      
      <!-- Contenido del login -->
      <div class="login-content">
         <!-- Formulario de login -->
         <form method="post" action="login.php">
            <!-- Imagen del avatar -->
            <img src="../img/avatar.png">
            
            <!-- Título de bienvenida -->
            <h2 class="title">BIENVENIDO</h2>
            <!-- Mostrar el mensaje de error aquí -->
            <?php
               if (!empty($error)) {
                  echo "<p style='color: white; background-color:rgba(255, 0, 0, 0.5); padding: 12px; border-radius: 7px; font-size: 1.2rem;'><i class='bi bi-exclamation-triangle'></i> $error <i class='bi bi-exclamation-triangle'></i></p>";
               }
            ?>
            <!-- Campo de entrada para el usuario -->
            <div class="input-div one">
               <div class="i">
                  <!-- Icono de usuario -->
                  <i class="bi bi-person-fill" style="color: #04a1fc;"></i>
               </div>
               <div class="div">
                  <input id="usuario" name="usuario" type="text" class="input" placeholder="Usuario">
               </div>
            </div>
            
            <!-- Campo de entrada para la contraseña -->
            <div class="input-div pass">
               <div class="i">
                  <!-- Icono de candado -->
                  <i class="bi bi-lock-fill" style="color: #04a1fc;"></i>
               </div>
               <div class="div">
                  <input type="password" id="clave" name="clave" class="input" placeholder="Password">
               </div>
            </div>
            
            <!-- Icono de ojo para mostrar/ocultar la contraseña -->
            <div class="view">
               <i class="fas fa-eye verPassword" onclick="vista()" id="verPassword"></i>
            </div>

            <!-- Enlace para la opción de "Olvidé mi contraseña" -->
            <div class="text-center">
               <a class="font-italic isai5" href="contrasena_olvidada.php">Olvidé mi contraseña</a>
            </div>

            <!-- Botón para iniciar sesión -->
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
               <button class="btn btn-primary border-1 btn-lg px-4 btn-ingresar" type="submit">INICIAR SESIÓN</button>
            </div>
         </form>
      </div>
   </div>
   <!-- El ojo -->
   <script>
   function vista() {
       var passwordInput = document.getElementById('clave');
       var eyeIcon = document.getElementById('verPassword');
       if (passwordInput.type === 'password') {
           passwordInput.type = 'text';
           eyeIcon.classList.remove('fa-eye');
           eyeIcon.classList.add('fa-eye-slash');
       } else {
           passwordInput.type = 'password';
           eyeIcon.classList.remove('fa-eye-slash');
           eyeIcon.classList.add('fa-eye');
       }
   }
   </script>
</body>
</html>