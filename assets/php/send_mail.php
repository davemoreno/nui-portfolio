<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los valores del formulario
    $name = strip_tags(trim($_POST["Name"]));
    $email = filter_var(trim($_POST["Email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["Subject"]));
    $message = trim($_POST["Message"]);

    // Comprueba si los campos están vacíos
    if (empty($name) || empty($email) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Por favor complete todos los campos.";
        exit;
    }

    // Configuración del destinatario y asunto
    $recipient = "info@davidmoreno.dev";  // Cambia a tu correo
    $subject = "Nuevo mensaje de $name desde tu sitio web";

    // Contenido del correo
    $email_content = "Nombre: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Asunto: $subject\n\n";
    $email_content .= "Mensaje:\n$message\n";

    // Encabezados de correo
    $email_headers = "From: $name <$email>";

    // Envía el correo
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Gracias, tu mensaje ha sido enviado con éxito.";
    } else {
        http_response_code(500);
        echo "Hubo un problema al enviar tu mensaje. Inténtalo más tarde.";
    }

} else {
    http_response_code(403);
    echo "Hubo un error con tu solicitud, por favor intenta de nuevo.";
}
?>