<?php
session_start();

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];

    if (isset($_SESSION['cart'][$id])) {
        if ($action == 'increase') {
            $_SESSION['cart'][$id]['qty'] += 1;
        } 
        elseif ($action == 'decrease') {
            $_SESSION['cart'][$id]['qty'] -= 1;
            // ถ้าลดจนเหลือ 0 ให้ลบสินค้าออกเลย
            if ($_SESSION['cart'][$id]['qty'] < 1) {
                unset($_SESSION['cart'][$id]);
            }
        } 
        elseif ($action == 'remove') {
            unset($_SESSION['cart'][$id]);
        }
    }
}

// หลังจากจัดการเสร็จ ให้ส่งกลับไปหน้าตะกร้า
header("Location: cart.php");
exit;
?>