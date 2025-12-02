<?php
require 'config.php';

// TODO: คุณสามารถเพิ่มระบบเช็คสิทธิ์ admin ตรงนี้ได้

$orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

function status_class($status) {
    return 'status-' . $status;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการคำสั่งซื้อ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>📦 จัดการคำสั่งซื้อ</h1>
    <div class="text-center" style="margin-bottom:15px;">
        <a href="index.php" class="btn btn-secondary">🏠 กลับหน้าร้าน</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>ลูกค้า</th>
                <th>ยอดรวม</th>
                <th>สถานะ</th>
                <th>เลขพัสดุ</th>
                <th>วันที่สั่งซื้อ</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $o): ?>
            <tr>
                <td>#<?php echo $o['order_id']; ?></td>
                <td><?php echo htmlspecialchars($o['fullname']); ?></td>
                <td><?php echo number_format($o['total_price'], 2); ?> ฿</td>
                <td>
                    <span class="badge <?php echo status_class($o['order_status']); ?>">
                        <?php echo htmlspecialchars($o['order_status']); ?>
                    </span>
                </td>
                <td><?php echo htmlspecialchars($o['tracking_no']); ?></td>
                <td><?php echo htmlspecialchars($o['created_at']); ?></td>
                <td>
                    <a class="btn btn-secondary" href="admin_order_edit.php?id=<?php echo $o['order_id']; ?>">แก้ไข</a>
                    <a class="btn btn-secondary" href="order_detail.php?id=<?php echo $o['order_id']; ?>" target="_blank">ดู</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
