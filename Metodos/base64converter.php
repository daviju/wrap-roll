<?php
function imageToBase64($imagePath) {
    // Verifica si el archivo existe
    if (!file_exists($imagePath)) {
        return null;
    }

    // Obtiene el contenido del archivo
    $imageData = file_get_contents($imagePath);

    // Convierte el contenido de la imagen en base64
    $base64 = base64_encode($imageData);

    // Obtiene el tipo MIME de la imagen
    $mimeType = mime_content_type($imagePath);

    // Formato final en base64 con el prefijo adecuado
    return 'data:' . $mimeType . ';base64,' . $base64;
}

// Uso
$imagePath = 'ruta/a/tu/imagen.jpg';
echo imageToBase64($imagePath);

?>
