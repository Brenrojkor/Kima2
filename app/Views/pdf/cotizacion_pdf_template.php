<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { width: 150px; }
        .details, .products, .totals { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .details td, .products th, .products td, .totals td { border: 1px solid #ccc; padding: 8px; }
        .products th { background-color: #eee; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
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

</body>
</html>
