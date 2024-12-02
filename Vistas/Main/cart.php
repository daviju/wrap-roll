<link rel="stylesheet" href="./css/cartStyle.css">

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
            <span id="current-credit">0.00€</span>
        </div>
        <div class="add-credit">
            <label for="credit">Añadir Crédito:</label>
            <input type="text" id="credit" name="credit">
            <button class="add-btn" id="add-credit-btn">Añadir</button>
        </div>
        <button class="order-btn" id="order-btn">Tramitar Pedido</button>
        <div>
            <span>Crédito Después de Tramitar:</span>
            <span id="remaining-credit">0.00€</span>
        </div>
    </div>
</div>