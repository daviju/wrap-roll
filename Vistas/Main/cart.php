<?php
// Verifica si el usuario está en la sesión
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$userId = $user ? $user->idUsuario : null;
$monedero = is_object($user) ? $user->monedero : 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/cartStyle.css">
    <title>Carrito</title>
</head>
<body>
    <div id="cart-container" data-user-id="<?php echo htmlspecialchars($userId, ENT_QUOTES, 'UTF-8'); ?>">
        <div class="container">
            <h1>Tickets</h1>
            <table>
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Kebab</th>
                        <th>Precio €</th>
                    </tr>
                </thead>
                <tbody id="cart-items">
                    <!-- Los datos se agregarán aquí dinámicamente -->
                </tbody>
            </table>

            <div class="delivery">
                <label for="address">Elige tu dirección de entrega:</label>
                <select id="address">
                    <!-- La dirección se llenará dinámicamente -->
                </select>
            </div>

            <div class="payment-info">
                <div>
                    <span>Total a Pagar:</span>
                    <span id="total-price">0.00€</span>
                </div>
                <div>
                    <span>Crédito Actual:</span>
                    <span id="current-credit"><?php echo number_format($monedero, 2); ?>€</span>
                </div>
                <button class="order-btn" id="order-btn">Tramitar Pedido</button>
                <div>
                    <span>Crédito Después de Tramitar:</span>
                    <span id="remaining-credit">0.00€</span>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Pasar el monedero desde PHP a JavaScript
        const userMonedero = <?php echo json_encode($monedero); ?>;

        document.addEventListener('DOMContentLoaded', () => {
            // Mostrar el monedero en la página si aún no se ha cargado dinámicamente
            const currentCreditElement = document.getElementById('current-credit');
            if (currentCreditElement) {
                currentCreditElement.textContent = `${userMonedero.toFixed(2)}€`;
            }
        });
    </script>
    <script src="./js/cart.js"></script>
</body>
</html>
