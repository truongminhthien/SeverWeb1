<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eef5f9;
            padding: 40px;
            color: #333;
        }

        .order-container {
            background-color: #ffffff;
            padding: 30px 40px;
            max-width: 700px;
            margin: 0 auto;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            border: 1px solid #d0dbe5;
        }

        h2 {
            color: #2e7d32;
            text-align: left;
            margin-bottom: 20px;
        }

        h4 {
            margin-top: 30px;
            color: #1565c0;
        }

        p {
            margin: 8px 0;
            line-height: 1.6;
        }

        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 25px 0;
        }

        b {
            color: #d32f2f;
        }

        .highlight {
            background-color: #f1f8e9;
            padding: 10px 15px;
            border-left: 5px solid #8bc34a;
            margin: 15px 0;
            border-radius: 6px;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: #f7fafd;
            border: 1px solid #cce4f7;
            border-radius: 8px;
            overflow: hidden;
        }

        .order-table th,
        .order-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #d6eaf8;
        }

        .order-table th {
            background-color: #1976d2;
            color: white;
        }

        .order-table tr:last-child td {
            border-bottom: none;
        }
    </style>
</head>

<body>
    <div class="order-container">
        <h2>Order Placed Successfully!</h2>
        <?php if ($order['id_user']['role'] === 0): ?>
            <p>Hello <?php echo htmlspecialchars($order['id_user']['username']); ?>,</p>
        <?php else: ?>
            <p>Hello <?php echo htmlspecialchars($order['customer_name']); ?>,</p>
        <?php endif; ?>
        <p>Thank you for placing your order with our store.</p>

        <div class="highlight">
            <p>Order ID: <b><?php echo htmlspecialchars($order['id_order']); ?></b></p>
            <p>Total Amount: <b><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VND</b></p>
            <p>Status: <?php echo htmlspecialchars($order['status']); ?></p>
        </div>

        <hr>

        <h4>Order Details:</h4>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order['order_detail'] as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p>Shipping Address: <b><?php echo htmlspecialchars($order['address']); ?></b></p>
        <p>Phone Number: <b><?php echo htmlspecialchars($order['phone']); ?></b></p>
        <hr>
        <?php if ($order['id_user']['role'] === 0): ?>
            <p><strong>Thank you for your order!</strong></p>
            <p>Your order has been successfully placed and is being processed.</p>
        <?php else: ?>
            <p><strong>Note:</strong> Please register an account with this email to track your order status.</p>
        <?php endif; ?>
        <hr>

        <p>If you have any questions, feel free to contact us:</p>
        <p>📞 Hotline: 0123 456 789</p>
        <p>📧 Email: support@store.com</p>
        <p>🌐 Website: <a href="https://store.com">store.com</a></p>
        <p>Best regards,<br><strong>Our Store Team</strong></p>
    </div>


</body>

</html>