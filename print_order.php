<?php
include 'config.php';
$order_id = (int)$_GET['order_id'];

// ดึงข้อมูลออเดอร์
$sql = "SELECT * FROM orders WHERE order_id = $order_id";
$res = mysqli_query($conn, $sql);
$order = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ใบสั่งซื้อ #<?= $order_id ?></title>
    <style>
        body { font-family: 'Sarabun', sans-serif; padding: 40px; }
        .invoice-box { border: 1px solid #eee; padding: 30px; max-width: 800px; margin: auto; }
        .header { display: flex; justify-content: space-between; border-bottom: 2px solid #ff6b6b; padding-bottom: 20px; }
        .billing { margin-top: 30px; display: flex; justify-content: space-between; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        .items-table th { background: #f8f9fa; padding: 10px; border: 1px solid #ddd; }
        .items-table td { padding: 10px; border: 1px solid #ddd; }
        .total-section { text-align: right; margin-top: 20px; font-size: 1.2em; }
        @media print { .no-print { display: none; } } /* ซ่อนปุ่มเวลาสั่งพิมพ์ */
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <div>
                <h1>ใบสั่งซื้อ / รายการสินค้า</h1>
                <p>เลขที่ออเดอร์: #<?= $order['order_id'] ?></p>
            </div>
            <div style="text-align: right;">
                <h3>Cosmetics Shop</h3>
                <p>วันที่สั่งซื้อ: <?= $order['created_at'] ?? date('d/m/Y') ?></p>
            </div>
        </div>

        <div class="billing">
            <div>
                <strong>📍 ที่อยู่จัดส่ง:</strong><br>
                <?= $order['fullname'] ?><br>
                <?= $order['address'] ?><br>
                โทร: <?= $order['phone'] ?>
            </div>
            <div style="text-align: right;">
                <strong>💳 วิธีชำระเงิน:</strong> <?= strtoupper($order['payment_method']) ?><br>
                <strong>🚚 วิธีส่ง:</strong> <?= $order['shipping_method'] ?>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>สินค้า</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th>รวม</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql_item = "SELECT oi.*, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = $order_id";
                $res_item = mysqli_query($conn, $sql_item);
                while($item = mysqli_fetch_assoc($res_item)):
                ?>
                <tr>
                    <td><?= $item['name'] ?></td>
                    <td><?= number_format($item['price'], 2) ?></td>
                    <td align="center"><?= $item['qty'] ?></td>
                    <td align="right"><?= number_format($item['subtotal'], 2) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="total-section">
            <p>ค่าส่ง: <?= number_format($order['shipping_cost'], 2) ?> บาท</p>
            <p><strong>รวมสุทธิ: <?= number_format($order['total_price'], 2) ?> บาท</strong></p>
        </div>
    </div>

    <div style="text-align: center; margin-top: 30px;" class="no-print">
        <button onclick="window.print()" style="padding: 10px 20px; background: #2ecc71; color: white; border: none; border-radius: 5px; cursor: pointer;">🖨️ พิมพ์ใบเสร็จ / ใบปะหน้า</button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #eee; border: none; border-radius: 5px; cursor: pointer;">ปิดหน้าต่าง</button>
    </div>
</body>
</html>