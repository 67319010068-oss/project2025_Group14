<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $status   = $_POST['order_status'];
    $tracking = $_POST['tracking_no'];

    // อัปเดตลงตาราง orders (อ้างอิงชื่อคอลัมน์จาก Screenshot 306)
    $sql = "UPDATE orders SET order_status = ?, tracking_no = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$status, $tracking, $order_id]);

    $_SESSION['success'] = "อัปเดตสถานะออเดอร์เรียบร้อยแล้ว!";
    header("Location: admin_orders.php"); // อัปเดตเสร็จให้กลับไปหน้าตาราง
    exit();
}