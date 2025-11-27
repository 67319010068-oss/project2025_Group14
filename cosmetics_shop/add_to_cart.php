<?php
session_start();
include __DIR__ . '/config/db.php';

if (!isset($_POST['product_id'])) {
    header("Location: index.php");
    exit();
}

$product_id = intval($_POST['product_id']);
$qty = intval($_POST['qty']);

// ดึงข้อมูลสินค้า
$sql = "SELECT * FROM products WHERE id = $product_id";
$res = $conn->query($sql);
$product = $res->fetch_assoc();

if (!$product) {
    die("สินค้าไม่พบ!");
}

// ถ้ายังไม่มี cart → ให้สร้าง array ว่าง
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ถ้ามีสินค้านี้อยู่แล้ว → เพิ่มจำนวน
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['qty'] += $qty;
} 
// ถ้ายังไม่มี → เพิ่มใหม่
else {
    $_SESSION['cart'][$product_id] = [
        "id"    => $product['id'],
        "name"  => $product['name'],
        "price" => $product['price'],
        "image" => $product['image'],
        "qty"   => $qty
    ];
}

header("Location: cart.php");
exit();
?>
