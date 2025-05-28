<?php
include '../php/password_recovery.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olvidé mi contraseña</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-content">
            <form method="post" action="contraseña_olvidada.php">
                <h2 class="title">RECUPERAR CONTRASEÑA</h2>
                <?php
                if (!empty($error)) {
                    echo "<p class='error'>$error</p>";
                }
                if (!empty($success)) {
                    echo "<p class='success'>$success</p>";
                }
                ?>
                <div class="input-div one">
                    <div class="i">
                        <i class="bi bi-envelope-fill" style="color: #04a1fc;"></i>
                    </div>
                    <div class="div">
                        <input id="email" name="email" type="email" class="input" placeholder="Correo Electrónico">
                    </div>
                </div>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <button class="btn btn-primary border-1 btn-lg px-4 btn-ingresar" type="submit">ENVIAR</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>