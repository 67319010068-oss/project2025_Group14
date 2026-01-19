<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = (int)$_POST['order_id'];
    
    // 1. จัดการโฟลเดอร์เก็บไฟล์
    $upload_dir = "slips/"; 
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    // 2. ตั้งชื่อไฟล์ใหม่ป้องกันชื่อซ้ำ
    $file_ext = pathinfo($_FILES['slip_image']['name'], PATHINFO_EXTENSION);
    $new_name = "slip_" . $order_id . "_" . time() . "." . $file_ext;
    $target_file = $upload_dir . $new_name;

    if (move_uploaded_file($_FILES['slip_image']['tmp_name'], $target_file)) {
        // 3. บันทึกลงตาราง payment_slips ตามโครงสร้างฐานข้อมูลของคุณ
        $sql = "INSERT INTO payment_slips (order_id, slip_image) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $order_id, $new_name);
        
        if ($stmt->execute()) {
            echo "<script>alert('แจ้งโอนเงินเรียบร้อย! รอแอดมินตรวจสอบค่ะ'); window.location='order_history.php';</script>";
        }
    } else {
        echo "การอัปโหลดผิดพลาด!";
    }
}
?>