<?php
require_once __DIR__ . '/../cargadores/Autocargador.php';
require_once __DIR__ . '/../Repositorios/Database.php';

use PHPMailer\PHPMailer\PHPMailer;
use Dompdf\Dompdf;

Autocargador::autocargar();

$con = Database::getConection();
$ru = new RepositorioUsuario($con);
$rk = new RepositorioKebab($con);

$kebabs = $rk->getAllKebab();

session_start();

if (isset($_POST)) {
   
    $html = '
    <body>
        <div class="contenedor-kebabs" style="width: 100%; max-width: 800px; margin: 0 auto; background-color: #ffffff; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="kebabs-list">
                <h1 style="text-align: center; font-size: 36px; color: #333; margin-bottom: 20px; text-transform: uppercase;">Carta de Menú: Kebabs</h1>
            </div>
            <div class="kebabs-list">';

    // Verificar si hay kebabs disponibles
    if (!empty($kebabs)) {
        // Recorrer los kebabs y generar el HTML para cada uno
        foreach ($kebabs as $kebab) {
            
            $nombre = $kebab->getNombre();
            $precio = $kebab->getPrecio();
            $imagen = $_SERVER["DOCUMENT_ROOT"] . "/" . "SERVIDOR/kebab/" . $kebab->getFoto();
            $foto = "data:image/jpg;base64," . base64_encode(file_get_contents($imagen));

            $html .= '
                <div class="kebab" style="border-bottom: 1px solid #ddd; padding: 15px 0; display: flex; align-items: center; margin-bottom: 20px;">
                    <img src="' . $foto . '" style="max-width: 100px; margin-right: 20px; border-radius: 8px;"/>
                    <div>
                        <h3 style="font-size: 24px; color: #333; margin: 0;">' . $nombre . '</h3>
                        <p style="font-size: 18px; color: #666; margin: 5px 0 0 0;">Precio: <span style="font-weight: bold; font-size: 20px; color: #e74c3c;">' . $precio . '€</span></p>
                    </div>
                </div>';
        }
    } else {
        // Si no hay kebabs disponibles
        $html .= '<p style="text-align: center; font-size: 18px; color: #555; padding: 20px;">No hay kebabs disponibles en este momento.</p>';
    }

    // Cerrar el contenedor
    $html .= '
            </div>
        </div>
    </body>';

    
    // Instanciar Dompdf
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    
    // Configurar el tamaño del papel y la orientación
    $dompdf->setPaper('A4', 'landscape');
    
    // Renderizar el HTML como PDF
    $dompdf->render();
    
    # Creamos un fichero
    $pdf = $dompdf->output();
    $filename = "carta.pdf";
    file_put_contents($filename, $pdf);


    // Enviar el PDF generado al navegador
    // $file_name = 'carta_kebab_Junai.pdf'; // Nombre del archivo para la descarga
    // $dompdf->stream($file_name, array('Attachment' => false));  // 'Attachment' => 1 forza la descarga del archivo

    //exit;  // Termina el script después de enviar el PDF
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';   // Especifica el servidor SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kebabjunai@gmail.com'; // Tu dirección de correo SMTP
        $mail->Password   = 'nslr ucpy ngak kvhj';         // Tu contraseña SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;                    // El puerto para conexiones TLS (puede variar según el servidor)

        // Remitente y destinatario
        $mail->setFrom("kebabjunai@gmail.com", "junai");
        $mail->addAddress($_SESSION['Usuario']);  // Dirección de destino

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = "Carta kebab_junai";
        $mail->Body    = 'Hola, te enviamos la carta en formato PDF. ¡Gracias por tu preferencia!';

        // Ruta al archivo PDF generado
        //$file_path = 'ruta/a/tu/archivo/carta_kebab.pdf'; // Cambia esta ruta al archivo PDF que generaste
        $mail->addAttachment($filename);  // Adjuntar el archivo PDF generado

        // Enviar el correo
        $mail->send();
        
        // Redirigir a la página de contacto o cualquier otra
        header("location:?menu=kebab_casa");
        //exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => "Error al enviar el correo: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Faltan datos en el formulario.']);
}
?>