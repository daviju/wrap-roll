// Función para cargar las direcciones del usuario desde la API
async function loadAddresses(userId) {
    try {
        const response = await fetch(`/api/direcciones/${userId}`);
        if (!response.ok) throw new Error('No se pudo obtener las direcciones');
        const data = await response.json();

        const addressSelect = document.getElementById('address');
        data.forEach(address => {
            const option = document.createElement('option');
            option.textContent = address;
            addressSelect.appendChild(option);
        });
    } catch (error) {
        console.error("Error al cargar las direcciones:", error);
    }
}

// Función para obtener el crédito actual del monedero del usuario desde $_SESSION
async function loadUserCredit() {
    try {
        const response = await fetch('/api/credito');  // Cambia la ruta según tu configuración
        if (!response.ok) throw new Error('No se pudo obtener el crédito');
        const data = await response.json();
        document.getElementById('current-credit').textContent = `${data.credito.toFixed(2)}€`;
        return data.credito;
    } catch (error) {
        console.error("Error al cargar el crédito del usuario:", error);
        return 0; // Valor por defecto si ocurre un error
    }
}

// Función para calcular el crédito después de tramitar
function updateRemainingCredit(totalPrice, currentCredit) {
    const remainingCredit = currentCredit - totalPrice;
    document.getElementById('remaining-credit').textContent = `${remainingCredit.toFixed(2)}€`;
}

// Función para añadir crédito al monedero
document.getElementById('add-credit-btn').addEventListener('click', () => {
    const creditInput = document.getElementById('credit');
    const additionalCredit = parseFloat(creditInput.value);
    if (!isNaN(additionalCredit) && additionalCredit > 0) {
        // Aquí puedes agregar el crédito al monedero en el servidor si es necesario
        const newCredit = parseFloat(document.getElementById('current-credit').textContent.replace('€', '')) + additionalCredit;
        document.getElementById('current-credit').textContent = `${newCredit.toFixed(2)}€`;
        creditInput.value = ''; // Limpiar el campo de crédito
    }
});

// Función para tramitar el pedido
document.getElementById('order-btn').addEventListener('click', async () => {
    const totalPrice = parseFloat(document.getElementById('total-price').textContent.replace('€', ''));
    const currentCredit = parseFloat(document.getElementById('current-credit').textContent.replace('€', ''));

    if (currentCredit >= totalPrice) {
        updateRemainingCredit(totalPrice, currentCredit);
        alert("Pedido procesado correctamente");
    } else {
        alert("No tienes suficiente crédito para tramitar el pedido.");
    }
});

// Obtener el ID del usuario desde $_SESSION (por ejemplo, lo puedes enviar como variable PHP al cargar la página)
const userId = <?php echo json_encode($_SESSION['user_id']); ?>; // Esto se puede ajustar dependiendo de tu backend

// Cargar los datos cuando la página se carga
window.onload = async () => {
    const currentCredit = await loadUserCredit();
    loadAddresses(userId); // Cargar las direcciones para el usuario
};
