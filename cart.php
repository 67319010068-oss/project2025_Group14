<?php
session_start();
$total = 0;
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ตะกร้าสินค้า - Cosmetics Shop</title>
    <style>
        body { font-family: 'Sarabun', sans-serif; background-color: #f4f7f6; padding: 20px; color: #333; }
        .cart-container { max-width: 900px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        h2 { color: #ff6b6b; text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #ff6b6b; color: white; padding: 15px; text-align: left; }
        td { padding: 15px; border-bottom: 1px solid #eee; }
        .qty-btn { background: #eee; border: none; padding: 5px 10px; cursor: pointer; border-radius: 5px; text-decoration: none; color: #333; font-weight: bold; }
        .qty-btn:hover { background: #ddd; }
        .del-btn { color: #e74c3c; text-decoration: none; font-weight: bold; }
        .total-price { text-align: right; font-size: 1.5rem; margin-top: 20px; font-weight: bold; color: #ff6b6b; }
        .btn-group { display: flex; justify-content: space-between; margin-top: 30px; }
        .btn { padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; transition: 0.3s; }
        .btn-back { background: #6c757d; color: white; }
        .btn-checkout { background: #2ecc71; color: white; }
        .btn-checkout:hover { background: #27ae60; transform: translateY(-2px); }
    </style>
</head>
<body>

<div class="cart-container">
    <h2>🛍️ ตะกร้าสินค้าของคุณ</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
    <table>
        <thead>
            <tr>
                <th>สินค้า</th>
                <th>ราคา</th>
                <th style="text-align: center;">จำนวน</th>
                <th>รวม</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cart'] as $id => $item): 
                $sum = $item['price'] * $item['qty'];
                $total += $sum;
            ?>
            <tr>
                <td><strong><?= htmlspecialchars($item['name']) ?></strong></td>
                <td><?= number_format($item['price'], 2) ?></td>
                <td style="text-align: center;">
                    <a href="update_cart.php?id=<?= $id ?>&action=decrease" class="qty-btn">-</a>
                    <span style="margin: 0 10px; font-weight: bold;"><?= $item['qty'] ?></span>
                    <a href="update_cart.php?id=<?= $id ?>&action=increase" class="qty-btn">+</a>
                </td>
                <td><?= number_format($sum, 2) ?></td>
                <td><a href="update_cart.php?id=<?= $id ?>&action=remove" class="del-btn" onclick="return confirm('ยืนยันการลบ?')">🗑️ ลบ</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total-price">
        ยอดรวมทั้งหมด: <?= number_format($total, 2) ?> บาท
    </div>

    <?php $_SESSION['total'] = $total; ?>

    <div class="btn-group">
        <a href="index.php" class="btn btn-back">⬅️ เลือกสินค้าต่อ</a>
        <a href="checkout.php" class="btn btn-checkout">ยืนยันการสั่งซื้อ (Checkout) ➔</a>
    </div>

    <?php else: ?>
    <div style="text-align: center; padding: 50px;">
        <p style="font-size: 1.2rem; color: #999;">ตะกร้าสินค้าว่างเปล่า</p>
        <a href="index.php" class="btn btn-back">ไปหน้าร้านค้า</a>
    </div>
    <?php endif; ?>
</div>

</body>
</html>