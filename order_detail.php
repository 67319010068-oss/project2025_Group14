<?php
session_start();
include 'config.php';

// 1. รับค่า order_id จาก URL (ตรวจสอบว่าเป็นตัวเลข)
if (!isset($_GET['order_id'])) {
    header("Location: order_history.php");
    exit;
}

$order_id = intval($_GET['order_id']);

/* 2. ดึงข้อมูล Order - เปลี่ยนเงื่อนไขเป็น order_id = ? */
$order_sql = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $conn->prepare($order_sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    echo "❌ ไม่พบข้อมูลคำสั่งซื้อที่ระบุ";
    exit;
}

/* 3. ดึงรายการสินค้า โดย JOIN กับ products เพื่อดึงชื่อสินค้ามาแสดง */
$item_sql = "SELECT oi.*, p.name AS product_name 
             FROM order_items oi
             JOIN products p ON oi.product_id = p.id
             WHERE oi.order_id = ?";
$item_stmt = $conn->prepare($item_sql);
$item_stmt->bind_param("i", $order_id);
$item_stmt->execute();
$items = $item_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายละเอียดคำสั่งซื้อ #<?= $order['order_id']; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container" style="max-width: 800px; margin: 20px auto; font-family: sans-serif;">
    <h2>📄 รายละเอียดคำสั่งซื้อ #<?= $order['order_id']; ?></h2>

    <div style="background: #fdfdfd; padding: 20px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 20px;">
        <p><strong>ชื่อผู้สั่ง:</strong> <?= htmlspecialchars($order['fullname']); ?></p>
        <p><strong>เบอร์โทร:</strong> <?= htmlspecialchars($order['phone']); ?></p>
        <p><strong>ที่อยู่จัดส่ง:</strong> <?= nl2br(htmlspecialchars($order['address'])); ?> 
           <?= htmlspecialchars($order['province']); ?> <?= htmlspecialchars($order['zipcode']); ?></p>
        <hr>
        <p><strong>วิธีจัดส่ง:</strong> <?= $order['shipping_method']; ?></p>
        <p><strong>วิธีชำระเงิน:</strong> <?= strtoupper($order['payment_method']); ?></p>
        <p><strong>วันที่สั่งซื้อ:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
    </div>

    <h3>📦 รายการสินค้า</h3>
    
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background: #f2f2f2;">
                <th>สินค้า</th>
                <th style="text-align: right;">ราคา/ชิ้น</th>
                <th style="text-align: center;">จำนวน</th>
                <th style="text-align: right;">รวม</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($item = $items->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($item['product_name']); ?></td>
                <td style="text-align: right;"><?= number_format($item['price'], 2); ?></td>
                <td style="text-align: center;"><?= $item['qty']; ?></td>
                <td style="text-align: right;"><?= number_format($item['subtotal'], 2); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right;">ค่าจัดส่ง</td>
                <td style="text-align: right;"><?= number_format($order['shipping_cost'], 2); ?></td>
            </tr>
            <tr style="background: #eee; font-weight: bold;">
                <td colspan="3" style="text-align: right;">ยอดรวมสุทธิ</td>
                <td style="text-align: right; color: #d9534f;"><?= number_format($order['total_price'], 2); ?> บาท</td>
            </tr>
        </tfoot>
    </table>

    <br>
    <a href="order_history.php" style="display: inline-block; padding: 10px 15px; background: #5bc0de; color: white; text-decoration: none; border-radius: 4px;">
        ← กลับไปหน้าประวัติการสั่งซื้อ
    </a>
</div>

</body>
</html>