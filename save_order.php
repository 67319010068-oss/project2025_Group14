<?php
session_start();
include 'config.php';

// ส่วนตกแต่ง CSS สำหรับหน้า Error/Success
echo "<style>
    body { font-family: 'Sarabun', sans-serif; background-color: #f8f9fa; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
    .message-box { max-width: 500px; width: 90%; padding: 40px; border-radius: 20px; background: #fff; box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center; }
    .error-title { color: #e74c3c; font-size: 24px; margin-bottom: 15px; }
    .success-title { color: #2ecc71; font-size: 24px; margin-bottom: 15px; }
    .btn { display: inline-block; margin-top: 20px; padding: 10px 25px; background: #ff6b6b; color: #fff; text-decoration: none; border-radius: 10px; transition: 0.3s; margin: 5px; }
    .btn:hover { background: #ee5253; transform: translateY(-2px); }
</style>";

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("<div class='message-box'><h2 class='error-title'>❌ ไม่มีสินค้าในตะกร้า</h2><a href='index.php' class='btn'>กลับหน้าร้าน</a></div>");
}

// รับข้อมูลจาก POST
$fullname = $_POST['fullname'] ?? '';
$phone    = $_POST['phone'] ?? '';
$address  = $_POST['address'] ?? '';
$province = $_POST['province'] ?? '';
$zipcode  = $_POST['zipcode'] ?? '';
$shipping_method = $_POST['shipping_method'] ?? 'EMS';
$payment_method  = $_POST['payment_method'] ?? 'bank';
$total = (float)($_POST['total_price'] ?? 0);

// คำนวณค่าส่ง
$shipping_cost = ($shipping_method == 'EMS') ? 60 : (($shipping_method == 'REGISTERED') ? 40 : 50);
$grand_total = $total + $shipping_cost;

$conn->begin_transaction();

try {
    // 1. ตรวจสอบสต๊อกสินค้า
    foreach ($_SESSION['cart'] as $product_id => $item) {
        $qty = (int)$item['qty'];
        $sql = "SELECT name, stock FROM products WHERE id = ? FOR UPDATE";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$row || $row['stock'] < $qty) {
            throw new Exception("สินค้า '" . ($row['name'] ?? 'ไม่ทราบชื่อ') . "' มีไม่พอในสต๊อก (คงเหลือ " . ($row['stock'] ?? 0) . ")");
        }
    }

    // 2. บันทึกข้อมูลลงตาราง orders
    $full_address = "$address จ.$province $zipcode";
    $sql_order = "INSERT INTO orders (fullname, address, phone, shipping_method, payment_method, shipping_cost, total_price) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_order = $conn->prepare($sql_order);
    $stmt_order->bind_param("sssssdd", $fullname, $full_address, $phone, $shipping_method, $payment_method, $shipping_cost, $grand_total);
    $stmt_order->execute();
    $order_id = $conn->insert_id;

    // 3. บันทึกรายการสินค้าลง order_details และตัดสต๊อก
    foreach ($_SESSION['cart'] as $product_id => $item) {
        $price = (float)$item['price'];
        $qty   = (int)$item['qty'];

        // บันทึกรายละเอียดสินค้า
        $sql_detail = "INSERT INTO order_details (order_id, product_id, price, qty) VALUES (?, ?, ?, ?)";
        $stmt_detail = $conn->prepare($sql_detail);
        $stmt_detail->bind_param("iidi", $order_id, $product_id, $price, $qty);
        $stmt_detail->execute();

        // ตัดสต๊อกสินค้า
        $sql_update = "UPDATE products SET stock = stock - ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ii", $qty, $product_id);
        $stmt_update->execute();
    }

    // ถ้าทำงานครบถ้วนให้ยืนยัน Transaction
    $conn->commit();
    unset($_SESSION['cart']);

    // แสดงผลสำเร็จ
    echo "<div class='message-box'>";
    echo "<h2 class='success-title'>✅ สั่งซื้อสำเร็จ!</h2>";
    echo "<p>เลขที่คำสั่งซื้อของคุณคือ: <strong>#$order_id</strong></p>";
    echo "<p>ยอดชำระสุทธิ: <strong>" . number_format($grand_total, 2) . " บาท</strong></p>";
    echo "<hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>";

    if ($payment_method == 'bank' || $payment_method == 'wallet') {
        echo "<p style='color: #666;'>กรุณาโอนเงินและแจ้งหลักฐานการชำระเงิน</p>";
        echo "<a href='payment.php?order_id=$order_id' class='btn' style='background-color: #2ecc71;'>แจ้งชำระเงินทันที</a>";
    } else {
        echo "<p style='color: #2ecc71;'>เตรียมรอรับสินค้าและชำระเงินที่หน้าบ้านได้เลยค่ะ!</p>";
    }

    echo "<a href='order_history.php?phone=$phone' class='btn' style='background-color: #3498db;'>ดูประวัติการสั่งซื้อ</a>";
    echo "</div>";

} catch (Exception $e) {
    // หากเกิดข้อผิดพลาดให้ยกเลิกการทำงานทั้งหมด (Rollback)
    $conn->rollback();
    echo "<div class='message-box'>";
    echo "<h2 class='error-title'>❌ เกิดข้อผิดพลาด</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<a href='cart.php' class='btn'>กลับไปที่ตะกร้า</a>";
    echo "</div>";
}
?>