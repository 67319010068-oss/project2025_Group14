<?php
// สร้าง Tracking Number แบบง่าย
$tracking = "TRK" . rand(100000, 999999);

// รับข้อมูลจาก confirm
$fullname = $_POST['fullname'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$province = $_POST['province'];
$zipcode = $_POST['zipcode'];
$shipping_method = $_POST['shipping_method'];
$payment_method = $_POST['payment_method'];
$total = $_POST['total'];

// บันทึกลงฐานข้อมูล
$conn = mysqli_connect("localhost", "root", "", "cosmetics_shop");
$sql = "INSERT INTO orders 
        (fullname, phone, address, province, zipcode, shipping_method, payment_method, total, tracking)
        VALUES 
        ('$fullname', '$phone', '$address', '$province', '$zipcode', '$shipping_method', '$payment_method', '$total', '$tracking')";
mysqli_query($conn, $sql);

?>

<h2>สั่งซื้อสำเร็จ!</h2>
<p>ขอบคุณสำหรับการสั่งซื้อ</p>

<p><b>หมายเลขติดตามพัสดุ (Tracking):</b> <?= $tracking ?></p>

<a href="index.php">กลับหน้าหลัก</a>
