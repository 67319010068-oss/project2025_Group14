<?php
require 'config.php';

// สมมติว่า user_id ถูกเก็บใน session แล้วตอนล็อกอิน
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo "กรุณาเข้าสู่ระบบเพื่อดูประวัติการสั่งซื้อ";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = :uid ORDER BY created_at DESC");
$stmt->execute([':uid' => $user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ประวัติคำสั่งซื้อของฉัน</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>🧾 ประวัติคำสั่งซื้อของฉัน</h1>
    <table class="table">
        <thead>
            <tr>
                <th>เลขที่</th>
                <th>ยอดรวม</th>
                <th>สถานะ</th>
                <th>เลขพัสดุ</th>
                <th>วันที่</th>
                <th>ดูรายละเอียด</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $o): ?>
            <tr>
                <td>#<?php echo $o['order_id']; ?></td>
                <td><?php echo number_format($o['total_price'], 2); ?> ฿</td>
                <td>
                    <span class="badge status-<?php echo htmlspecialchars($o['order_status']); ?>">
                        <?php echo htmlspecialchars($o['order_status']); ?>
                    </span>
                </td>
                <td><?php echo htmlspecialchars($o['tracking_no']); ?></td>
                <td><?php echo htmlspecialchars($o['created_at']); ?></td>
                <td>
                    <a class="btn btn-secondary" href="order_detail.php?id=<?php echo $o['order_id']; ?>">ดู</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-center" style="margin-top:15px;">
        <a href="index.php" class="btn btn-secondary">🏠 กลับหน้าร้าน</a>
    </div>
</div>
</body>
</html>
