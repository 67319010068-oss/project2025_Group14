<?php
session_start();
include "config.php";

// ตรวจสอบว่ามี order_id ถูกส่งมาหรือไม่
if (!isset($_POST['order_id'])) {
    die("Error: order_id not found");
}

$order_id = $_POST['order_id'];

$target_dir = "admin/upload_slip/";

// สร้างโฟลเดอร์ถ้ายังไม่มี
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$filename = "slip_" . time() . ".jpg";
$target_file = $target_dir . $filename;

// อัปโหลดไฟล์
if (move_uploaded_file($_FILES["slip"]["tmp_name"], $target_file)) {

    // บันทึกข้อมูลลงฐานข้อมูล
    $sql = "UPDATE orders 
            SET payment_slip='$filename', order_status='paid'
            WHERE id='$order_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<h2>อัปโหลดสลิปสำเร็จ!</h2>";
        echo "<a href='index.php'>กลับหน้าหลัก</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {
    echo "อัปโหลดไม่สำเร็จ กรุณาลองใหม่!";
}
?>
