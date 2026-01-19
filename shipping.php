<?php
session_start();

// ป้องกันเข้าโดยไม่มีสินค้า
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}
?>

<h2>📦 ข้อมูลการจัดส่ง</h2>

<form action="save_shipping.php" method="post">

    ชื่อ - นามสกุล:<br>
    <input type="text" name="fullname" required><br><br>

    เบอร์โทร:<br>
    <input type="tel" name="phone" pattern="[0-9]{9,10}" required><br><br>

    ที่อยู่:<br>
    <textarea name="address" required></textarea><br><br>

    จังหวัด:<br>
    <input type="text" name="province" required><br><br>

    รหัสไปรษณีย์:<br>
    <input type="text" name="zipcode" pattern="[0-9]{5}" required><br><br>

    วิธีจัดส่ง:<br>
    <select name="shipping_method" required>
        <option value="EMS">EMS (+60)</option>
        <option value="REGISTERED">ลงทะเบียน (+40)</option>
        <option value="FLASH">Flash Express (+50)</option>
    </select><br><br>

    วิธีชำระเงิน:<br>
    <select name="payment_method" required>
        <option value="COD">เก็บเงินปลายทาง</option>
        <option value="BANK">โอนชำระผ่านบัญชี</option>
        <option value="PROMPTPAY">พร้อมเพย์</option>
    </select><br><br>

    <?php
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['qty'];
    }
    ?>
    <strong>💰 ยอดรวมสินค้า: <?= number_format($total,2) ?> บาท</strong><br><br>

    <button type="submit">✅ ดำเนินการต่อ</button>

</form>
