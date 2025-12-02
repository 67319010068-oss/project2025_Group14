<?php
require 'config.php';

$order_id = $_GET['id'] ?? null;
if (!$order_id) {
    header("Location: index.php");
    exit;
}

// ข้อมูลคำสั่งซื้อ
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = :id");
$stmt->execute([':id' => $order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "ไม่พบคำสั่งซื้อ";
    exit;
}

// รายการสินค้า
$itemStmt = $conn->prepare("
    SELECT oi.*, p.product_name 
    FROM order_items oi
    LEFT JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = :id
");
$itemStmt->execute([':id' => $order_id]);
$items = $itemStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายละเอียดคำสั่งซื้อ #<?php echo $order['order_id']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>รายละเอียดคำสั่งซื้อ #<?php echo $order['order_id']; ?></h1>

    <p>
        สถานะ: 
        <span class="badge status-<?php echo htmlspecialchars($order['order_status']); ?>">
            <?php echo htmlspecialchars($order['order_status']); ?>
        </span>
        <br>
        เลขพัสดุ: <strong><?php echo $order['tracking_no'] ? htmlspecialchars($order['tracking_no']) : 'ยังไม่ระบุ'; ?></strong><br>
        วันที่สั่งซื้อ: <?php echo htmlspecialchars($order['created_at']); ?>
    </p>

    <h3>ข้อมูลผู้รับสินค้า</h3>
    <p>
        ชื่อ: <?php echo htmlspecialchars($order['fullname']); ?><br>
        ที่อยู่: <?php echo nl2br(htmlspecialchars($order['address'])); ?><br>
        เบอร์โทร: <?php echo htmlspecialchars($order['phone']); ?>
    </p>

    <h3>สินค้าในคำสั่งซื้อ</h3>
    <table class="table">
        <thead>
            <tr>
                <th>สินค้า</th>
                <th>จำนวน</th>
                <th>ราคา/ชิ้น</th>
                <th class="text-right">รวม</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['product_name'] ?? ('สินค้า #' . $item['product_id'])); ?></td>
                <td><?php echo (int)$item['quantity']; ?></td>
                <td><?php echo number_format($item['price'], 2); ?></td>
                <td class="text-right">
                    <?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <p class="text-right" style="font-size:18px; font-weight:bold; margin-top:10px;">
        ยอดรวมทั้งหมด: <?php echo number_format($order['total_price'], 2); ?> ฿
    </p>

    <div class="text-center" style="margin-top:20px;">
        <a href="index.php" class="btn btn-secondary">🏠 กลับหน้าร้าน</a>
    </div>
</div>
</body>
</html>
