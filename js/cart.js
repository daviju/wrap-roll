// Función para cargar las direcciones del usuario desde la API
async function loadAddresses(userId) {
    try {
        const response = await fetch(`http://www.daviju.es/Api/ApiDireccion.php?idUsuario=${userId}`);
        if (!response.ok) throw new Error('No se pudo obtener las direcciones');
        const data = await response.json();

        const addressSelect = document.getElementById('address');
        addressSelect.innerHTML = ''; // Limpiar el select antes de agregar nuevas opciones

        if (data.error) {
            console.error(data.error);
            return;
        }

        // Si no hay direcciones, agrega una opción por defecto
        if (data.length === 0) {
            const option = document.createElement('option');
            option.textContent = 'No hay direcciones disponibles';
            addressSelect.appendChild(option);
        } else {
            // Agregar las direcciones al select
            data.forEach(address => {
                const option = document.createElement('option');
                option.textContent = `${address.tipovia} ${address.nombrevia}, ${address.numero}` +
                                     `${address.puerta ? ', Puerta: ' + address.puerta : ''}` +
                                     `${address.escalera ? ', Escalera: ' + address.escalera : ''}` +
                                     `${address.planta ? ', Planta: ' + address.planta : ''}` +
                                     `${address.localidad ? ', ' + address.localidad : ''}`;
                addressSelect.appendChild(option);
            });
        }
    } catch (error) {
        console.error("Error al cargar las direcciones:", error);
    }
}

// Función para inicializar el crédito actual del monedero desde PHP
function initializeUserCredit(monedero) {
    const currentCreditElement = document.getElementById('current-credit');
    if (currentCreditElement) {
        currentCreditElement.textContent = `${monedero.toFixed(2)}€`;
    }
}

// Función para calcular el crédito después de tramitar
function updateRemainingCredit(totalPrice, currentCredit) {
    const remainingCredit = currentCredit - totalPrice;
    document.getElementById('remaining-credit').textContent = `${remainingCredit.toFixed(2)}€`;
}

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

// Obtener el ID del usuario desde el atributo data
document.addEventListener('DOMContentLoaded', async () => {
    const cartContainer = document.getElementById('cart-container');
    const userId = cartContainer.getAttribute('data-user-id');

    if (userId) {
        // Inicializar el crédito desde la variable PHP
        initializeUserCredit(userMonedero);

        // Cargar las direcciones desde la API
        await loadAddresses(userId);
    } else {
        console.error('No se pudo obtener el ID del usuario.');
    }
});
