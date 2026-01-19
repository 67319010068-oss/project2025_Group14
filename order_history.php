<?php
session_start();
include 'config.php';

$search_phone = $_GET['phone'] ?? '';
$result = null;

if (!empty($search_phone)) {
    // ค้นหาข้อมูลโดยใช้เบอร์โทรศัพท์ และเรียงตาม order_id ตามโครงสร้างตาราง Screenshot 306
    $search_phone = mysqli_real_escape_string($conn, $search_phone);
    $sql = "SELECT * FROM orders WHERE phone = '$search_phone' ORDER BY order_id DESC";
    $result = mysqli_query($conn, $sql);
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการสั่งซื้อ - Cosmetics Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-pink: #ff85a1;
            --soft-pink: #fff5f7;
            --accent-red: #ff4d6d;
            --success-green: #2ecc71;
            --info-blue: #3498db;
        }

        body { 
            font-family: 'Sarabun', sans-serif; 
            background-color: var(--soft-pink); 
            margin: 0; 
            padding: 40px 20px;
            color: #444;
        }

        .container { 
            max-width: 700px; 
            margin: 0 auto; 
            background: #fff; 
            padding: 40px; 
            border-radius: 25px; 
            box-shadow: 0 15px 35px rgba(255, 133, 161, 0.15); 
        }

        h2 { 
            color: var(--accent-red); 
            text-align: center; 
            margin-bottom: 30px;
            font-size: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        /* Search Section */
        .search-section { 
            background: #fff;
            padding: 5px; 
            border-radius: 15px; 
            margin-bottom: 40px; 
            display: flex;
            border: 2px solid var(--primary-pink);
        }
        
        .search-input { 
            flex: 1;
            padding: 15px; 
            border: none;
            border-radius: 12px; 
            font-size: 16px; 
            outline: none; 
        }

        .btn-search { 
            padding: 0 30px; 
            background: var(--primary-pink); 
            color: white; 
            border: none; 
            border-radius: 10px; 
            cursor: pointer; 
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-search:hover {
            background: var(--accent-red);
        }

        /* Order Card */
        .order-card { 
            border: 1px solid #ffe4e9; 
            border-radius: 20px; 
            padding: 25px; 
            margin-bottom: 25px; 
            transition: 0.3s;
            background: #fff;
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        .order-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            border-bottom: 1px dashed #fce4ec; 
            padding-bottom: 15px; 
            margin-bottom: 20px; 
        }

        .order-id { font-weight: bold; color: var(--accent-red); font-size: 18px; }
        
        /* Status Badge */
        .status-badge { 
            padding: 6px 16px; 
            border-radius: 50px; 
            font-size: 13px; 
            font-weight: bold; 
        }
        .status-pending { background: #fff3e0; color: #ff9800; }
        .status-paid { background: #e8f5e9; color: var(--success-green); }
        .status-shipped { background: #e3f2fd; color: var(--info-blue); }

        .order-info p { margin: 8px 0; font-size: 15px; }
        .label { color: #888; width: 100px; display: inline-block; }

        /* Tracking Box */
        .tracking-box { 
            background: #f8fbff; 
            padding: 18px; 
            border-radius: 15px; 
            margin-top: 20px; 
            border: 2px solid #e3f2fd;
        }
        
        .tracking-box strong { color: var(--info-blue); display: block; margin-bottom: 5px; }
        
        .track-number {
            font-family: 'Courier New', Courier, monospace;
            font-size: 20px;
            color: #2c3e50;
            letter-spacing: 2px;
            font-weight: bold;
        }

        .btn-back { 
            display: block; 
            text-align: center; 
            margin-top: 30px; 
            color: var(--primary-pink); 
            text-decoration: none;
            font-weight: bold;
        }

        .empty-state { text-align: center; padding: 40px; color: #bbb; }
    </style>
</head>
<body>

<div class="container">
    <h2>💖 ประวัติการสั่งซื้อ</h2>

    <form method="GET" class="search-section">
        <input type="text" name="phone" class="search-input" placeholder="ใส่เบอร์โทรศัพท์ของคุณ..." value="<?= htmlspecialchars($search_phone) ?>" required>
        <button type="submit" class="btn-search">ค้นหา</button>
    </form>

    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="order-card">
                <div class="order-header">
                    <span class="order-id">#<?= $row['order_id'] ?></span>
                    <span class="status-badge status-<?= $row['order_status'] ?>">
                        <?php 
                            if($row['order_status'] == 'pending') echo '⏳ รอตรวจสอบ';
                            elseif($row['order_status'] == 'paid') echo '💰 ชำระเงินแล้ว';
                            elseif($row['order_status'] == 'shipped') echo '🚚 จัดส่งแล้ว';
                            else echo strtoupper($row['order_status']);
                        ?>
                    </span>
                </div>
                
                <div class="order-info">
                    <p><span class="label">ผู้รับ:</span> <strong><?= htmlspecialchars($row['fullname']) ?></strong></p>
                    <p><span class="label">ยอดรวม:</span> <strong style="color:var(--accent-red); font-size: 18px;"><?= number_format($row['total_price'], 2) ?> บาท</strong></p>
                </div>

                <?php if ($row['order_status'] == 'shipped' && !empty($row['tracking_no'])): ?>
                    <div class="tracking-box">
                        <strong>📦 เลขพัสดุของคุณ</strong>
                        <div class="track-number"><?= htmlspecialchars($row['tracking_no']) ?></div>
                        <p style="font-size: 12px; color: #999; margin-top: 10px;">ขอบคุณที่ใช้บริการ Cosmetics Shop ค่ะ ✨</p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php elseif (!empty($search_phone)): ?>
        <div class="empty-state">
            <p style="font-size: 50px;">🛍️</p>
            <p>ไม่พบประวัติการสั่งซื้อสำหรับเบอร์นี้ค่ะ</p>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <p>กรุณาใส่เบอร์โทรศัพท์เพื่อตรวจสอบออเดอร์นะคะ ✨</p>
        </div>
    <?php endif; ?>

    <a href="index.php" class="btn-back">← กลับไปช้อปปิ้งต่อ</a>
</div>

</body>
</html>