<?php
session_start();

// รับข้อมูลจาก shipping form
$fullname = $_POST['fullname'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$province = $_POST['province'];
$zipcode = $_POST['zipcode'];
$shipping_method = $_POST['shipping_method'];
$payment_method = $_POST['payment_method'];

// ค่าจัดส่ง
$shipping_cost = 0;
if ($shipping_method == "EMS") $shipping_cost = 60;
if ($shipping_method == "REGISTERED") $shipping_cost = 40;
if ($shipping_method == "FLASH") $shipping_cost = 50;

// รับข้อมูลจากตะกร้า
$cart = $_SESSION['cart'];
$total = $_SESSION['total'];

// ราคารวมสุทธิ
$grand_total = $total + $shipping_cost;

?>

<h2>ตรวจสอบคำสั่งซื้อ</h2>

<h3>ข้อมูลผู้รับสินค้า</h3>
<p>ชื่อ: <?= $fullname ?></p>
<p>โทร: <?= $phone ?></p>
<p>ที่อยู่: <?= $address ?> จังหวัด <?= $province ?> <?= $zipcode ?></p>
<p>วิธีจัดส่ง: <?= $shipping_method ?> (<?= $shipping_cost ?> บาท)</p>
<p>วิธีชำระเงิน: <?= $payment_method ?></p>

<hr>

<h3>รายการสินค้า</h3>
<table border="1" cellpadding="10">
<tr>
    <th>สินค้า</th>
    <th>ราคา</th>
    <th>จำนวน</th>
    <th>รวม</th>
</tr>

<?php foreach ($cart as $item) { ?>
<tr>
    <td><?= $item['name'] ?></td>
    <td><?= $item['price'] ?></td>
    <td><?= $item['qty'] ?></td>
    <td><?= $item['price'] * $item['qty'] ?></td>
</tr>
<?php } ?>

<tr>
    <td colspan="3">รวมสินค้า</td>
    <td><?= $total ?></td>
</tr>
<tr>
    <td colspan="3">ค่าจัดส่ง</td>
    <td><?= $shipping_cost ?></td>
</tr>
<tr>
    <td colspan="3"><b>รวมทั้งหมด</b></td>
    <td><b><?= $grand_total ?></b></td>
</tr>

</table>

<br>

<form action="success.php" method="post">
    <input type="hidden" name="fullname" value="<?= $fullname ?>">
    <input type="hidden" name="phone" value="<?= $phone ?>">
    <input type="hidden" name="address" value="<?= $address ?>">
    <input type="hidden" name="province" value="<?= $province ?>">
    <input type="hidden" name="zipcode" value="<?= $zipcode ?>">
    <input type="hidden" name="shipping_method" value="<?= $shipping_method ?>">
    <input type="hidden" name="payment_method" value="<?= $payment_method ?>">
    <input type="hidden" name="total" value="<?= $grand_total ?>">
    <button type="submit">ยืนยันการสั่งซื้อ</button>
</form>
