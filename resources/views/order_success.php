<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Xác Nhận Đặt Hàng</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            color: #333;
            padding: 30px;
            background-color: #eef2f7;
            line-height: 1.6;
        }

        .container {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 25px 30px;
            max-width: 800px;
            margin: auto;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        h2 {
            color: #007BFF;
            text-align: center;
            margin-bottom: 15px;
        }

        h3 {
            margin-top: 20px;
            color: #444;
            border-left: 4px solid #007BFF;
            padding-left: 8px;
        }

        ul {
            background: #f9fafe;
            border: 1px solid #e2e6ea;
            padding: 15px 20px;
            border-radius: 8px;
            list-style: none;
        }

        ul li {
            margin-bottom: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 14px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f1f4f9;
            color: #333;
        }

        tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        tfoot td {
            font-weight: bold;
        }

        .total {
            font-weight: bold;
            color: #d32f2f;
        }

        p strong {
            color: #222;
        }

        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #666;
        }

        .footer a {
            color: #007BFF;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>XÁC NHẬN ĐẶT HÀNG THÀNH CÔNG</h2>
        <p>Kính gửi <strong><?php echo $order['id_address']['recipient_name']; ?></strong>,</p>
        <p>Cảm ơn bạn đã đặt hàng tại <strong>CHANEL</strong>. Chúng tôi xin xác nhận đơn hàng của bạn với các thông tin sau:</p>

        <h3>Thông tin đơn hàng:</h3>
        <ul>
            <li><strong>Mã đơn hàng:</strong> #<?php echo $order['id_order']; ?></li>
            <li><strong>Tên khách hàng:</strong> <?php echo $order['id_address']['recipient_name']; ?></li>
            <li><strong>Số điện thoại:</strong> <?php echo $order['id_address']['phone']; ?></li>
            <li><strong>Ngày đặt:</strong> <?php echo date('d/m/Y', strtotime($order['order_date'])); ?></li>
            <li><strong>Phương thức thanh toán:</strong> <?php echo $order['payment_method']; ?></li>
            <li><strong>Trạng thái thanh toán:</strong> <?php echo $order['payment_status']; ?></li>
            <li><strong>Địa chỉ giao hàng:</strong> <?php echo $order['id_address']['address_line']; ?></li>
        </ul>

        <h3>Chi tiết sản phẩm:</h3>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá (VNĐ)</th>
                    <th>Thành tiền (VNĐ)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order['order_detail'] as $index => $item): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                        <td><?php echo number_format($item['quantity'] * $item['price'], 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right;">Tổng tiền:</td>
                    <td class="total"><?php echo number_format($order['total'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right;">Phí vận chuyển:</td>
                    <td class="total"><?php echo number_format($order['shipping_fee'], 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right;">Thành tiền thanh toán:</td>
                    <td class="total"><?php echo number_format($order['total_amount']); ?></td>
                </tr>
            </tfoot>
        </table>

        <p><strong>Lưu ý:</strong> Đơn hàng sẽ được giao trong vòng 7 - 14 ngày. Vui lòng giữ điện thoại để tài xế liên hệ khi giao hàng.</p>

        <div class="footer">
            <p>Mọi thắc mắc xin liên hệ:</p>
            <p>📞 Hotline: 0123 456 789</p>
            <p>📧 Email: lienhe@cuahang.com</p>
            <p>🌐 Website: <a href="https://cuahang.com">cuahang.com</a></p>
            <p>Trân trọng,<br><strong>CHANEL</strong></p>
        </div>
    </div>
</body>

</html>