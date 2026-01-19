<?php
session_start();
require_once 'config.php';

if (!isset($_POST['product_id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_POST['product_id'];

// ดึงข้อมูลสินค้าจากฐานข้อมูล
$sql = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header("Location: index.php");
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ตรวจสอบว่ามีสินค้านี้ในตะกร้าหรือยัง
if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['qty'] += 1;
} else {
    // เพิ่มสินค้าใหม่พร้อมเก็บ ID ไว้ในอาร์เรย์
    $_SESSION['cart'][$id] = [
        'id'    => $product['id'], // เพิ่มส่วนนี้เพื่อให้ save_order.php เรียกใช้ง่ายขึ้น
        'name'  => $product['name'],
        'price' => $product['price'],
        'image' => $product['image'],
        'qty'   => 1
    ];
}

header("Location: cart.php");
exit;
?>