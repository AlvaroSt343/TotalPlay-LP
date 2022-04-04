<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    #reemplazar datos de remitente
    $remitente ="TotalPlay Cancún";
    $remitentemail ="totalplaycancun@totalplay.com";

    #Reemplazar este correo por el correo electrónico del destinatario
    $mail_to = "red.fear@hotmail.com, eduardoest@gmail.com";

    # Envío de datos

    $nombre = str_replace(array("\r", "\n"), array(" ", " "), strip_tags(trim($_POST["nombre"])));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $telefono = $_POST["telefono"];
    $mensaje = filter_var(trim($_POST["mensaje"], FILTER_SANITIZE_STRING));
    $subject = "¡Nuevo Cliente!";
    $context = "Un nuevo cliente quiere ponerse en contacto con usted";
    if (empty($nombre) or !filter_var($email, FILTER_VALIDATE_EMAIL) or empty($telefono) or empty($mensaje)) {
        # Establecer un código de respuesta y salida.
        // http_response_code(400);
        // echo "P";
        $var = "Por favor completa el formulario y vuelve a intentarlo.";
        echo "<script> alert('" . $var . "'); 
                window.location='../index.html#contact';
            </script>";
        exit;
    }

    # Contenido del correo
    $content =
        $context . "<br><br>"
        . "<strong>" . $nombre . "</strong><br>"
        . $email . "<br>"
        . $telefono . "<br><br><br>"
        . $mensaje;

    # Encabezados de correo electrónico.
    $headers  = 'MIME-Version: 1.0' . "\r\n"
        . 'Content-type: text/html; charset=utf-8' . "\r\n"
        . 'From:' . $remitente . '<' . $remitentemail . '>';

    # Envía el correo.
    $success = mail($mail_to, $subject, $content, $headers);
    if ($success) {
        # Establece un código de respuesta 200 (correcto).
        // http_response_code(300);
        // echo "";
        $var = "¡Gracias! Tu mensaje ha sido enviado, te responderemos a la brevedad posible.";
        echo "<script> alert('" . $var . "'); 
                window.location='../index.html';
            </script>";
    } else {
        # Establezce un código de respuesta 500 (error interno del servidor).
        http_response_code(500);
        // echo "";
        $var = "Oops! Algo salió mal, no pudimos enviar tu mensaje.";
        echo "<script> alert('" . $var . "'); 
                window.location='../index.html#contact';
            </script>";
    }
} else {
    # No es una solicitud POST, establezce un código de respuesta 403 (prohibido).
    $var = "Hubo un problema con tu envío, intenta de nuevo.";
    echo "<script> alert('" . $var . "'); 
            window.location='../index.html#contact';
        </script>";
}
