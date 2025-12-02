<?php
require 'config.php';

$order_id = $_GET['id'] ?? null;
if (!$order_id) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = :id");
$stmt->execute([':id' => $order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "ไม่พบคำสั่งซื้อ";
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สั่งซื้อสำเร็จ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>🎉 สั่งซื้อสำเร็จแล้ว</h1>
    <p class="text-center">
        หมายเลขคำสั่งซื้อของคุณคือ<br>
        <strong>#<?php echo $order['order_id']; ?></strong>
    </p>
    <p class="text-center">
        สถานะปัจจุบัน: 
        <span class="badge status-<?php echo htmlspecialchars($order['order_status']); ?>">
            <?php echo htmlspecialchars($order['order_status']); ?>
        </span>
    </p>
    <div class="text-center" style="margin-top:15px;">
        <a class="btn" href="order_detail.php?id=<?php echo $order['order_id']; ?>">ดูรายละเอียดคำสั่งซื้อ</a>
    </div>
    <div class="text-center" style="margin-top:15px;">
        <a href="index.php" class="btn btn-secondary">🏠 กลับไปหน้าร้าน</a>
    </div>
</div>
</body>
</html>
