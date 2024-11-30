<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Boleta de Venta</title>
    <script>
        function calcularTotal(index) {
            const cantidad = parseFloat(document.getElementById('cantidad_' + index).value) || 0;
            const precio = parseFloat(document.getElementById('precio_' + index).value) || 0;
            const total = cantidad * precio;
            document.getElementById('total_' + index).value = total.toFixed(2);
            calcularSubtotal();
        }

        function calcularSubtotal() {
            let subtotal = 0;
            for (let i = 1; i <= 4; i++) {
                const total = parseFloat(document.getElementById('total_' + i).value) || 0;
                subtotal += total;
            }
            const igv = subtotal * 0.18;
            const totalFinal = subtotal + igv;
            document.getElementById('subtotal').value = subtotal.toFixed(2);
            document.getElementById('igv').value = igv.toFixed(2);
            document.getElementById('totalPagar').value = totalFinal.toFixed(2);
        }
    </script>
    <style>
        body {
            background-color: #1e3d58;
            font-family: Arial, sans-serif;
            padding: 50px 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 700px;
        }
        h2, h3 {
            text-align: center;
            color: #1e3d58;
        }
        label {
            font-size: 16px;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }
        .form-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 15px;
        }
        .form-row div {
            width: 45%;
        }
        .form-row input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            padding: 12px 15px;
            background-color: #1e3d58;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #365c74;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Generar Boleta de Venta</h2>
        <form action="guardar_boleta.php" method="POST">
            <div class="form-row">
                <div>
                    <label for="ruc">RUC:</label>
                    <input type="text" name="ruc" id="ruc" value="70829346517" readonly>
                </div>
                <div>
                    <label for="telefono">Teléfono:</label>
                    <input type="text" name="telefono" id="telefono" value="918382465" readonly>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="direccion">Dirección:</label>
                    <input type="text" name="direccion" id="direccion" value="AV Peru 115" readonly>
                </div>
                <div>
                    <label for="correo">Correo:</label>
                    <input type="email" name="correo" id="correo" value="saludvet@gmail.com" readonly>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="numero_boleta">N° Boleta:</label>
                    <input type="text" name="numero_boleta" id="numero_boleta" value="000000001" readonly>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="cliente">Cliente:</label>
                    <input type="text" name="cliente" required>
                </div>
                <div>
                    <label for="dni">DNI:</label>
                    <input type="text" name="dni">
                </div>
            </div>
            <h3>Productos/Servicios</h3>
            <!-- Producto 1 -->
            <div class="form-row">
                <div>
                    <label for="descripcion_1">Descripción Producto 1:</label>
                    <input type="text" name="descripcion_1" id="descripcion_1" required>
                </div>
                <div>
                    <label for="cantidad_1">Cantidad:</label>
                    <input type="number" name="cantidad_1" id="cantidad_1" oninput="calcularTotal(1)" required>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="precio_1">Precio Unitario (S/):</label>
                    <input type="number" name="precio_1" id="precio_1" oninput="calcularTotal(1)" required>
                </div>
                <div>
                    <label for="total_1">Total (S/):</label>
                    <input type="text" id="total_1" readonly>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="descripcion_1">Descripción Producto 2:</label>
                    <input type="text" name="descripcion_1" id="descripcion_1" required>
                </div>
                <div>
                    <label for="cantidad_1">Cantidad:</label>
                    <input type="number" name="cantidad_1" id="cantidad_1" oninput="calcularTotal(1)" required>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="precio_1">Precio Unitario (S/):</label>
                    <input type="number" name="precio_1" id="precio_1" oninput="calcularTotal(1)" required>
                </div>
                <div>
                    <label for="total_1">Total (S/):</label>
                    <input type="text" id="total_1" readonly>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="descripcion_1">Descripción Producto 3:</label>
                    <input type="text" name="descripcion_1" id="descripcion_1" required>
                </div>
                <div>
                    <label for="cantidad_1">Cantidad:</label>
                    <input type="number" name="cantidad_1" id="cantidad_1" oninput="calcularTotal(1)" required>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="precio_1">Precio Unitario (S/):</label>
                    <input type="number" name="precio_1" id="precio_1" oninput="calcularTotal(1)" required>
                </div>
                <div>
                    <label for="total_1">Total (S/):</label>
                    <input type="text" id="total_1" readonly>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="descripcion_1">Descripción Producto 4:</label>
                    <input type="text" name="descripcion_1" id="descripcion_1" required>
                </div>
                <div>
                    <label for="cantidad_1">Cantidad:</label>
                    <input type="number" name="cantidad_1" id="cantidad_1" oninput="calcularTotal(1)" required>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="precio_1">Precio Unitario (S/):</label>
                    <input type="number" name="precio_1" id="precio_1" oninput="calcularTotal(1)" required>
                </div>
                <div>
                    <label for="total_1">Total (S/):</label>
                    <input type="text" id="total_1" readonly>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="descripcion_1">Descripción Producto 5:</label>
                    <input type="text" name="descripcion_1" id="descripcion_1" required>
                </div>
                <div>
                    <label for="cantidad_1">Cantidad:</label>
                    <input type="number" name="cantidad_1" id="cantidad_1" oninput="calcularTotal(1)" required>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="precio_1">Precio Unitario (S/):</label>
                    <input type="number" name="precio_1" id="precio_1" oninput="calcularTotal(1)" required>
                </div>
                <div>
                    <label for="total_1">Total (S/):</label>
                    <input type="text" id="total_1" readonly>
                </div>
            </div>
            <!-- Más productos similares -->
            <h3>Resumen</h3>
            <div class="form-row">
                <div>
                    <label for="subtotal">Subtotal (S/):</label>
                    <input type="text" id="subtotal" name="subtotal" readonly>
                </div>
                <div>
                    <label for="igv">IGV (18%):</label>
                    <input type="text" id="igv" name="igv" readonly>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="totalPagar">Total a Pagar (S/):</label>
                    <input type="text" id="totalPagar" name="totalPagar" readonly>
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label for="metodo_pago">Método de Pago:</label>
                    <select name="metodo_pago" required>
                        <option value="efectivo">Efectivo</option>
                        <option value="yape">Yape</option>
                    </select>
                </div>
                <div>
                    <label for="atendido_por">Atendido por:</label>
                    <input type="text" name="atendido_por" required>
                </div>
            </div>
            <button type="submit">Generar Boleta</button>
        </form>
    </div>
</body>
</html>
