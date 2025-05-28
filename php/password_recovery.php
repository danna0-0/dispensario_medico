<?php
include '../php/db_connection.php';
// Incluye las clases necesarias de PHPMailer
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Verificar si el campo está vacío
    if (empty($email)) {
        $error = "POR FAVOR INGRESE SU CORREO ELECTRÓNICO";
    } else {
        // Verificar si el correo electrónico existe en la base de datos
        $sql = "SELECT clave FROM registro WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $password = $row['clave'];

            // Enviar la contraseña por correo electrónico
            $mail = new PHPMailer(true);

            try {
                // Configuración del servidor
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // El servidor SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'dispensariorecuperacion@gmail.com'; // El correo que envia los correos
                $mail->Password = 'zrjeivsevwfopisz';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Configuración de codificación
                $mail->CharSet = 'UTF-8';

                // Destinatarios
                $mail->setFrom('tu_correo@gmail.com', 'Nombre');
                $mail->addAddress($email);

                // Contenido del correo
                $mail->isHTML(true);
                $mail->Subject = 'Recuperación de contraseña';
                $mail->Body    = 'Su contraseña es: ' . $password;

                $mail->send();
                $success = 'La contraseña ha sido enviada a su correo electrónico.';
            } catch (Exception $e) {
                $error = "El mensaje no pudo ser enviado. Error de Mailer: {$mail->ErrorInfo}";
            }
        } else {
            $error = "CORREO ELECTRÓNICO NO ENCONTRADO";
        }

        $stmt->close();
    }

    $conn->close();
}
?>