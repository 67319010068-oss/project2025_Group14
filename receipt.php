<?php
session_start();
include __DIR__ . '/config/db.php';

if (!isset($_GET['id'])) {
    die("❌ ไม่พบคำสั่งซื้อ");
}

$order_id = intval($_GET['id']);

// ดึงข้อมูล order
$sql = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

// ดึงสินค้าใน order
$sql_items = "
    SELECT oi.quantity, oi.price, p.name 
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
";
$stmt2 = $conn->prepare($sql_items);
$stmt2->bind_param("i", $order_id);
$stmt2->execute();
$items = $stmt2->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ใบเสร็จ #<?= $order_id ?></title>
<style>
body { font-family: Tahoma; padding: 20px; }
table { width: 100%; border-collapse: collapse; }
th, td { border: 1px solid #ccc; padding: 10px; }
th { background: #eee; }
</style>
</head>

<body>

<h1>ใบเสร็จคำสั่งซื้อ #<?= $order_id ?></h1>
<p>วันที่: <?= $order['created_at'] ?></p>

<table>
<tr>
    <th>สินค้า</th>
    <th>จำนวน</th>
    <th>ราคา</th>
    <th>รวม</th>
</tr>

<?php while ($r = $items->fetch_assoc()) : ?>
<tr>
    <td><?= $r['name'] ?></td>
    <td><?= $r['quantity'] ?></td>
    <td><?= number_format($r['price'],2) ?></td>
    <td><?= number_format($r['price'] * $r['quantity'],2) ?></td>
</tr>
<?php endwhile; ?>

</table>

<h2>ยอดรวม: <?= number_format($order['total_price'],2) ?> บาท</h2>

<a href="index.php">กลับหน้าหลัก</a>

</body>
</html>
