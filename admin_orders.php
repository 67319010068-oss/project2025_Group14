<?php
session_start();
require_once 'config.php';

try {
    $stmt = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Admin - รายการคำสั่งซื้อ</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root { --pink: #ff4d6d; --soft-pink: #ff85a1; --light-pink: #fff5f7; --bg: #f8f9fa; }
        body { font-family: 'Sarabun', sans-serif; background-color: var(--bg); margin: 0; }
        
        /* Navbar */
        .navbar { background: white; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
        .navbar h2 { margin: 0; color: var(--pink); font-size: 20px; }
        .btn-home { text-decoration: none; color: #666; font-size: 14px; border: 1px solid #ddd; padding: 5px 15px; border-radius: 20px; transition: 0.3s; }
        .btn-home:hover { background: var(--pink); color: white; border-color: var(--pink); }

        .container { max-width: 1100px; margin: 30px auto; padding: 20px; }
        .card { background: white; border-radius: 20px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #f0f0f0; }
        
        /* Table Style */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: var(--light-pink); color: var(--pink); padding: 15px; text-align: left; font-size: 14px; border-bottom: 2px solid #ffe4e9; }
        td { padding: 15px; border-bottom: 1px solid #eee; font-size: 14px; color: #444; }
        tr:hover { background-color: #fafafa; }

        /* Status Badge */
        .badge { padding: 6px 15px; border-radius: 20px; font-size: 12px; font-weight: bold; color: white; display: inline-block; }
        .status-pending { background: #ff9f43; }
        .status-paid { background: #28c76f; }
        .status-shipped { background: #00cfe8; }

        /* Action Buttons */
        .btn-manage { background: var(--pink); color: white; text-decoration: none; padding: 7px 15px; border-radius: 10px; font-size: 13px; transition: 0.3s; }
        .btn-manage:hover { background: var(--soft-pink); box-shadow: 0 5px 15px rgba(255, 77, 109, 0.3); }

        .alert-success { background: #d4edda; color: #155724; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; border-left: 5px solid #28a745; }
    </style>
</head>
<body>

<div class="navbar">
    <h2>💖 CMS Cosmetic Admin</h2>
    <a href="../index.php" class="btn-home">🏠 ไปยังหน้าร้าน</a>
</div>

<div class="container">
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert-success"> ✨ <?php echo $_SESSION['success']; unset($_SESSION['success']); ?> </div>
    <?php endif; ?>

    <div class="card">
        <h3 style="margin-top:0;">📦 รายการคำสั่งซื้อทั้งหมด</h3>
        <table>
            <thead>
                <tr>
                    <th>เลขที่ออเดอร์</th>
                    <th>ชื่อลูกค้า</th>
                    <th>ยอดชำระ</th>
                    <th>สถานะ</th>
                    <th>เลขพัสดุ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                <tr>
                    <td><strong>#<?php echo $o['order_id']; ?></strong></td>
                    <td><?php echo htmlspecialchars($o['fullname']); ?></td>
                    <td style="font-weight:bold; color: var(--pink);"><?php echo number_format($o['total_price'], 2); ?> ฿</td>
                    <td>
                        <?php 
                        $status_map = ['pending' => 'รอตรวจสอบ', 'paid' => 'ชำระเงินแล้ว', 'shipped' => 'ส่งแล้ว'];
                        $status_class = "status-" . $o['order_status'];
                        ?>
                        <span class="badge <?php echo $status_class; ?>"><?php echo $status_map[$o['order_status']] ?? $o['order_status']; ?></span>
                    </td>
                    <td><code style="color:#888;"><?php echo $o['tracking_no'] ?: '-'; ?></code></td>
                    <td>
                        <a href="admin_order_edit.php?id=<?php echo $o['order_id']; ?>" class="btn-manage">⚙️ จัดการ</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>