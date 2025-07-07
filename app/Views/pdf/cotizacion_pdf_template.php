<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .logo {
        width: 150px;
    }

    .details,
    .products,
    .totals {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .details td,
    .products th,
    .products td,
    .totals td {
        border: 1px solid #ccc;
        padding: 8px;
    }

    .products th {
        background-color: #eee;
    }

    .right {
        text-align: right;
    }

    .bold {
        font-weight: bold;
    }
    </style>
</head>

<body>

    <div class="header">
        <h2>KIMA</h2>
        <p>San José, Costa Rica<br>Correo: info@kima.com | Tel: +506 8888-8888</p>
    </div>

    <table class="details">
        <tr>
            <td><strong>Cliente:</strong> <?= htmlspecialchars($cotizacion['cliente_nombre']) ?></td>
            <td><strong>Empresa:</strong> <?= htmlspecialchars($cotizacion['cliente_empresa']) ?></td>
        </tr>
        <tr>
            <td><strong>Correo:</strong> <?= htmlspecialchars($cotizacion['cliente_email']) ?></td>
            <td><strong>Fecha:</strong> <?= htmlspecialchars($cotizacion['fecha_creacion']) ?></td>
        </tr>
    </table>

    <table class="products">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['nombre_producto']) ?></td>
                <td class="right"><?= $item['cantidad'] ?></td>
                <td class="right">$<?= number_format($item['precio'], 2) ?></td>
                <td class="right">$<?= number_format($item['subtotal'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td class="bold right">Subtotal:</td>
            <td class="right">$<?= number_format($cotizacion['subtotal'], 2) ?></td>
        </tr>
        <tr>
            <td class="bold right">IVA (13%):</td>
            <td class="right">$<?= number_format($cotizacion['iva'], 2) ?></td>
        </tr>
        <tr>
            <td class="bold right">Total:</td>
            <td class="right">$<?= number_format($cotizacion['total'], 2) ?></td>
        </tr>
    </table>

    <p><strong>Condiciones de pago:</strong> 50% anticipo y 50% contra entrega.</p>
    <p><strong>Validez:</strong> 15 días naturales.</p>

    <div style="font-family: Arial, sans-serif; font-size: 14px;">
        <p><strong>IMPORTANTE:</strong><br>
            a) Pagos que se realicen desde el extranjero están exentos de I.V.A., sin embargo, el cliente debe costear
            los gastos bancarios e impuestos por concepto de transferencia internacional (costo aproximado $50 por
            transferencia).<br>
            b) Los costos detallados no incluyen el pago de aranceles al Ministerio de Salud por concepto de
            Inscripción, $100 para el registro de un producto higiénico.
        </p>

        <p><strong>FORMA DE PAGO:</strong><br>
            Se solicita un adelanto del 50% al iniciar los procesos contratados y el restante 50% al presentar las
            solicitudes ante el Ministerio de Salud. A continuación, se detallan nuestros datos y cuentas bancarias.
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <tr>
                <td style="width: 50%; border: 1px solid #000; padding: 10px; vertical-align: top;">
                    <strong>Banco Nacional de Costa Rica (BNCR) – Cuenta colones</strong><br>
                    <strong>Cuenta BN:</strong> 100-01-000-221385-3<br>
                    <strong>Cuenta Cliente:</strong> 1510010012213852<br>
                    <strong>Cuenta IBAN:</strong> CR76015100010012213852
                </td>
                <td style="width: 50%; border: 1px solid #000; padding: 10px; vertical-align: top;">
                    <strong>Banco Nacional de Costa Rica (BNCR) – Cuenta dólares</strong><br>
                    <strong>Cuenta BN:</strong> 100-02-000-622411-1<br>
                    <strong>Cuenta Cliente:</strong> 1510010026224115<br>
                    <strong>Cuenta IBAN:</strong> CR83015100010026224115
                </td>
            </tr>
            <tr>
                <td style="width: 50%; border: 1px solid #000; padding: 10px; vertical-align: top;">
                    <strong>Nombre:</strong> QCM ASUNTOS REGULATORIOS REGULATORY AFFAIRS COSTA RICA SOCIEDAD ANONIMA<br>
                    <strong>Cédula Jurídica:</strong> 3-101-705975<br>
                </td>
                <td style="width: 50%; border: 1px solid #000; padding: 10px; vertical-align: top;">
                    <strong>Swift:</strong> BNCRCRSJ<br>
                    <strong>Número Fiscal:</strong> 3-101-705975-30
                </td>
            </tr>
        </table>
    </div>


</body>

</html>