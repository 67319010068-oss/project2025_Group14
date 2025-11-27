<?php
session_start();
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ตะกร้าสินค้า</title>
<style>
table { width: 100%; border-collapse: collapse; background: #ffe6ee; }
th, td { border: 1px solid #999; padding: 10px; text-align: center; }
body { background: #ffe6ee; font-family: Arial; }
</style>
</head>
<body>

<h2>ตะกร้าสินค้า</h2>
<a href="index.php">⬅️ กลับไปหน้าร้าน</a>
<br><br>

<table>
    <tr>
        <th>สินค้า</th>
        <th>ราคา</th>
        <th>จำนวน</th>
        <th>รวม</th>
        <th>ลบ</th>
    </tr>

<?php
$total = 0;

if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){
    foreach($_SESSION['cart'] as $id => $item){

        // ป้องกัน error ถ้าไม่ได้เป็น array
        if(!is_array($item)){ continue; }

        $sum = $item['qty'] * $item['price'];
        $total += $sum;
?>
        <tr>
            <td>
                <img src="assets/images/<?php echo $item['image']; ?>" width="80"><br>
                <?php echo $item['name']; ?>
            </td>
            <td><?php echo number_format($item['price'],2); ?> บาท</td>
            <td><?php echo $item['qty']; ?></td>
            <td><?php echo number_format($sum,2); ?> บาท</td>
            <td><a href="cartdeletepro.php?id=<?php echo $id; ?>">ลบ</a></td>
        </tr>
<?php 
    }
}
?>

</table>

<h3>ยอดรวมทั้งหมด: <?php echo number_format($total, 2); ?> บาท</h3>

<form action="checkout.php" method="post">
    <button type="submit">สั่งซื้อ</button>
</form>

</body>
</html>
