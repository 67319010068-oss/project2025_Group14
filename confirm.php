<?php
session_start();
include "config.php";

// รับข้อมูลจาก shipping.php
$fullname = $_POST['fullname'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$province = $_POST['province'];
$zipcode = $_POST['zipcode'];
$shipping_method = $_POST['shipping_method'];
$payment_method = $_POST['payment_method'];

$shipping_cost = 0;
if ($shipping_method == "EMS") $shipping_cost = 60;
if ($shipping_method == "REGISTERED") $shipping_cost = 40;
if ($shipping_method == "FLASH") $shipping_cost = 50;

// เก็บลง SESSION
$_SESSION['shipping'] = [
    "fullname" => $fullname,
    "phone" => $phone,
    "address" => $address,
    "province" => $province,
    "zipcode" => $zipcode,
    "shipping_method" => $shipping_method,
    "payment_method" => $payment_method,
    "shipping_cost" => $shipping_cost
];

// ตะกร้า
$cart = $_SESSION['cart'];
$total = 0;

foreach ($cart as $item) {
    $total += $item['price'] * $item['qty'];
}

$grand_total = $total + $shipping_cost;
$_SESSION['total'] = $grand_total;
?>

<h2>ยืนยันคำสั่งซื้อ</h2>

<h3>ข้อมูลลูกค้า</h3>
ชื่อ: <?= $fullname ?><br>
โทร: <?= $phone ?><br>
ที่อยู่: <?= $address ?><br>
จังหวัด: <?= $province ?><br>
รหัสไปรษณีย์: <?= $zipcode ?><br>
วิธีจัดส่ง: <?= $shipping_method ?> (+<?= $shipping_cost ?> บาท)<br>
วิธีชำระเงิน: <?= $payment_method ?><br><br>

<h3>ยอดรวมคำสั่งซื้อ: <?= $grand_total ?> บาท</h3>

<form action="success.php" method="post">
    <button type="submit">ยืนยันสั่งซื้อ</button>
</form>
