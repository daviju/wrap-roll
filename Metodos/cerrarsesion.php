<?php
// Destruir todas las variables de la sesión
session_unset();

// Destruir la sesión para borrar todo
session_destroy();

// Añadir script para limpiar el localStorage y redirigir al inicio
echo '<script>
    // Limpiar localStorage
    localStorage.clear();
    
    // Redirigir al inicio
    window.location.href = "?menu=inicio";
</script>';
exit();
?>
