<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$dbname = "cosmetic_shop";

$conn = new mysqli($host, $user, $password, $dbname);
if($conn->connect_error){ die("Connection failed: " . $conn->connect_error); }

$session_id = session_id();

$sql = "SELECT c.id as cart_id, p.name, p.price, c.quantity 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.session_id='$session_id'";
$result = $conn->query($sql);

$total = 0;
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>สรุปคำสั่งซื้อ</title>
<style>
body { font-family: Arial; background-color: #f5f5f5; padding: 20px; }
table { border-collapse: collapse; width: 50%; margin:auto; background:white; border-radius:10px; overflow:hidden; }
th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: center; }
th { background-color: #ff69b4; color: white; }
.button { padding: 8px 15px; background:#ff69b4; color:white; border:none; border-radius:5px; cursor:pointer; text-decoration:none; }
.button:hover { background:#ff85c1; }
a { text-decoration:none; color:#ff69b4; }
a:hover { color:#ff85c1; }
</style>
</head>
<body>
<h1 style="text-align:center;">💳 สรุปคำสั่งซื้อ</h1>
<p style="text-align:center;"><a href="index.php">🏠 กลับไปหน้าแรก</a></p>

<?php
if($result->num_rows > 0){
    echo '<table>';
    echo '<tr><th>สินค้า</th><th>ราคา/ชิ้น</th><th>จำนวน</th><th>ราคารวม</th></tr>';
    while($row = $result->fetch_assoc()){
        $subtotal = $row['price'] * $row['quantity'];
        $total += $subtotal;
        echo '<tr>';
        echo '<td>'.$row["name"].'</td>';
        echo '<td>'.number_format($row["price"],2).' บาท</td>';
        echo '<td>'.$row["quantity"].'</td>';
        echo '<td>'.number_format($subtotal,2).' บาท</td>';
        echo '</tr>';
    }
    echo '<tr><th colspan="3">รวมทั้งหมด</th><th>'.number_format($total,2).' บาท</th></tr>';
    echo '</table>';
    echo '<p style="text-align:center;"><a href="clear_cart.php" class="button">✅ สั่งซื้อและล้างตะกร้า</a></p>';
} else {
    echo "<p style='text-align:center;'>ยังไม่มีสินค้าในตะกร้า</p>";
}
$conn->close();
?>
</body>
</html>
