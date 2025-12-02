<?php
require 'config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: admin_orders.php");
    exit;
}

// โหลดคำสั่งซื้อเดิม
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = :id");
$stmt->execute([':id' => $id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "ไม่พบคำสั่งซื้อ";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['order_status'] ?? $order['order_status'];
    $tracking = trim($_POST['tracking_no'] ?? '');

    $updateStmt = $conn->prepare("
        UPDATE orders
        SET order_status = :status, tracking_no = :tracking
        WHERE order_id = :id
    ");
    $updateStmt->execute([
        ':status' => $status,
        ':tracking' => $tracking,
        ':id' => $id
    ]);

    header("Location: admin_orders.php");
    exit;
}

$statuses = ['pending','paid','processing','shipping','delivered','cancelled'];
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>อัปเดตคำสั่งซื้อ #<?php echo $order['order_id']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>อัปเดตคำสั่งซื้อ #<?php echo $order['order_id']; ?></h1>
    <p>
        ลูกค้า: <?php echo htmlspecialchars($order['fullname']); ?><br>
        ยอดรวม: <?php echo number_format($order['total_price'], 2); ?> ฿<br>
        วันที่สั่งซื้อ: <?php echo htmlspecialchars($order['created_at']); ?>
    </p>

    <form method="post">
        <div class="form-group">
            <label>สถานะคำสั่งซื้อ</label>
            <select name="order_status">
                <?php foreach ($statuses as $s): ?>
                    <option value="<?php echo $s; ?>" <?php if ($s === $order['order_status']) echo 'selected'; ?>>
                        <?php echo $s; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>เลขพัสดุ (Tracking No.)</label>
            <input type="text" name="tracking_no" value="<?php echo htmlspecialchars($order['tracking_no']); ?>">
        </div>

        <button type="submit" class="btn">💾 บันทึก</button>
        <a href="admin_orders.php" class="btn btn-secondary">ยกเลิก</a>
    </form>
</div>
</body>
</html>
