<?php
// Destruir todas las variables de la sesión
session_unset();

// Destruir la sesión para borrar todo
session_destroy();

// Redirigir al inicio
echo '<script>window.location.href="?menu=inicio"</script>';
exit();
?>
