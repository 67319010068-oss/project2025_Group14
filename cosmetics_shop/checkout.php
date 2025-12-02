<?php
include __DIR__ . '/config.php';

// ตัวอย่าง: แสดงสินค้าที่อยู่ในตะกร้า (จำลอง)
$cart = [
    ['name' => 'ลิปสติก', 'price' => 350, 'qty' => 2],
    ['name' => 'ครีมบำรุง', 'price' => 500, 'qty' => 1]
];

$total = 0;

echo "<h2>Checkout</h2><table border='1' cellpadding='5'>";
echo "<tr><th>สินค้า</th><th>ราคา</th><th>จำนวน</th><th>รวม</th></tr>";

foreach ($cart as $item) {
    $subtotal = $item['price'] * $item['qty'];
    $total += $subtotal;

    echo "<tr>
            <td>{$item['name']}</td>
            <td>{$item['price']}</td>
            <td>{$item['qty']}</td>
            <td>{$subtotal}</td>
        </tr>";
}

echo "<tr><td colspan='3'>รวมทั้งหมด</td><td>$total</td></tr>";
echo "</table>";
?>

<br>

<!-- ปุ่มไปหน้าจัดส่งสินค้า -->
<a href="shipping.php">
    <button>ดำเนินการจัดส่ง</button>
</a>
