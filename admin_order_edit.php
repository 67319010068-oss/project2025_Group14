<?php
session_start();
require_once 'config.php';

$order_id = $_GET['id'] ?? null;
if (!$order_id) { header("Location: admin_orders.php"); exit; }

// บันทึกข้อมูล
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_order'])) {
    $new_status = $_POST['order_status'];
    $tracking = $_POST['tracking_no'];

    try {
        $sql = "UPDATE orders SET order_status = ?, tracking_no = ? WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$new_status, $tracking, $order_id]);

        $_SESSION['success'] = "อัปเดตคำสั่งซื้อ #$order_id เรียบร้อยแล้ว";
        header("Location: admin_orders.php");
        exit;
    } catch (PDOException $e) { $error = "Error: " . $e->getMessage(); }
}

// ดึงข้อมูลเดิม
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการออเดอร์ #<?php echo $order_id; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Sarabun', sans-serif; background-color: #fff5f7; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .edit-box { max-width: 450px; width: 90%; background: #fff; padding: 40px; border-radius: 30px; box-shadow: 0 15px 40px rgba(255, 77, 109, 0.15); border: 1px solid #ffe4e9; }
        
        h2 { color: #ff4d6d; text-align: center; margin-bottom: 30px; font-size: 24px; }
        .info-card { background: #fff9fa; border: 1px dashed #ff85a1; padding: 15px; border-radius: 15px; margin-bottom: 25px; }
        .info-card p { margin: 5px 0; font-size: 14px; color: #666; }

        label { display: block; margin-bottom: 8px; font-weight: bold; color: #444; font-size: 14px; }
        select, input[type="text"] { width: 100%; padding: 12px 15px; margin-bottom: 20px; border: 1px solid #ffd1dc; border-radius: 12px; font-size: 15px; outline: none; box-sizing: border-box; }
        select:focus, input:focus { border-color: #ff4d6d; box-shadow: 0 0 5px rgba(255, 77, 109, 0.2); }

        .btn-group { display: flex; flex-direction: column; gap: 10px; }
        .btn-save { background: #ff4d6d; color: white; border: none; padding: 15px; border-radius: 12px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .btn-save:hover { background: #ff758f; transform: translateY(-2px); }
        .btn-back { text-align: center; color: #aaa; text-decoration: none; font-size: 14px; }
        .btn-back:hover { color: #ff4d6d; }
    </style>
</head>
<body>

<div class="edit-box">
    <h2>⚙️ จัดการคำสั่งซื้อ</h2>
    
    <div class="info-card">
        <p><strong>📦 ออเดอร์:</strong> #<?php echo $order['order_id']; ?></p>
        <p><strong>👤 ลูกค้า:</strong> <?php echo htmlspecialchars($order['fullname']); ?></p>
        <p><strong>💰 ยอดรวม:</strong> <span style="color:#ff4d6d;"><?php echo number_format($order['total_price'], 2); ?> ฿</span></p>
    </div>

    <form method="POST">
        <label>📍 สถานะพัสดุ</label>
        <select name="order_status">
            <option value="pending" <?php if($order['order_status']=='pending') echo 'selected'; ?>>⏳ รอตรวจสอบ</option>
            <option value="paid" <?php if($order['order_status']=='paid') echo 'selected'; ?>>💰 ชำระเงินแล้ว</option>
            <option value="shipped" <?php if($order['order_status']=='shipped') echo 'selected'; ?>>🚚 จัดส่งแล้ว</option>
        </select>

        <label>🚚 เลขพัสดุ (Tracking No.)</label>
        <input type="text" name="tracking_no" value="<?php echo htmlspecialchars($order['tracking_no'] ?? ''); ?>" placeholder="เช่น TH123456789">

        <div class="btn-group">
            <button type="submit" name="update_order" class="btn-save">💾 บันทึกข้อมูล</button>
            <a href="admin_orders.php" class="btn-back">🔙 กลับหน้าจัดการ</a>
        </div>
    </form>
</div>

</body>
</html>