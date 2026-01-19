<?php
session_start();
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: admin_orders.php");
    exit;
}

$order_id = intval($_GET['id']);

/* order */
$stmt = $conn->prepare("SELECT * FROM orders WHERE id=?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    echo "ไม่พบคำสั่งซื้อ";
    exit;
}

/* items */
$item_stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id=?");
$item_stmt->bind_param("i", $order_id);
$item_stmt->execute();
$items = $item_stmt->get_result();
?>

<h2>ออเดอร์ #<?= $order['id']; ?></h2>

<p>
ลูกค้า: <?= htmlspecialchars($order['fullname']); ?><br>
สถานะปัจจุบัน: <b><?= $order['status']; ?></b>
</p>

<form action="update_status.php" method="post">
    <input type="hidden" name="order_id" value="<?= $order['id']; ?>">

    <select name="status">
        <option value="รอดำเนินการ">รอดำเนินการ</option>
        <option value="ชำระเงินแล้ว">ชำระเงินแล้ว</option>
        <option value="กำลังจัดส่ง">กำลังจัดส่ง</option>
        <option value="จัดส่งแล้ว">จัดส่งแล้ว</option>
    </select>

    <button type="submit">อัปเดตสถานะ</button>
</form>

<h3>รายการสินค้า</h3>
<table border="1" cellpadding="8">
<tr>
    <th>สินค้า</th>
    <th>ราคา</th>
    <th>จำนวน</th>
    <th>รวม</th>
</tr>

<?php while ($item = $items->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($item['product_name']); ?></td>
    <td><?= number_format($item['price'],2); ?></td>
    <td><?= $item['qty']; ?></td>
    <td><?= number_format($item['subtotal'],2); ?></td>
</tr>
<?php endwhile; ?>
</table>

<br>
<a href="admin_orders.php">← กลับ</a>
