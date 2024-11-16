// indexCuenta.js
console.log("Archivo indexCuenta.js cargado correctamente");

// Capturar el botón por id y agregar el event listener
document.addEventListener("DOMContentLoaded", function() {
    document.body.addEventListener('click', function(event) {
        if (event.target.id === 'btn-monedero') {
            mostrarModal();
        }
        if (event.target.id === 'btn-guardar-cantidad') {
            guardarCantidad();
        }
        if (event.target.id === 'btn-cerrar-modal') {
            cerrarModal();
        }
    });
});


function mostrarModal() {
    document.getElementById('modal-monedero').style.display = 'flex';
}


function guardarCantidad() {
    const cantidad = document.getElementById('cantidad').value;
    if (cantidad) {
        console.log("Cantidad ingresada:", cantidad);
    }
    cerrarModal();
}

function cerrarModal() {
    document.getElementById('modal-monedero').style.display = 'none';
}
