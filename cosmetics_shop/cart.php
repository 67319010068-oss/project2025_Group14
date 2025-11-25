<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$dbname = "cosmetic_shop";

$conn = new mysqli($host, $user, $password, $dbname);
if($conn->connect_error){ die("Connection failed: " . $conn->connect_error); }

$session_id = session_id();

$sql = "SELECT c.id as cart_id, p.name, p.price, p.image, c.quantity 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.session_id='$session_id'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ตะกร้าสินค้า</title>
<style>
body { font-family: Arial; background-color: #f5f5f5; padding: 20px; }
table { border-collapse: collapse; width: 100%; background:white; border-radius:10px; overflow:hidden; }
th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: center; }
th { background-color: #ff69b4; color: white; }
img { width: 80px; height: 80px; object-fit: cover; border-radius:5px; }
.button { padding: 5px 10px; background:#ff69b4; color:white; border:none; border-radius:5px; cursor:pointer; }
.button:hover { background:#ff85c1; }
a { text-decoration:none; color:#ff69b4; }
a:hover { color:#ff85c1; }
</style>
</head>
<body>

<h1>ตะกร้าสินค้า</h1>
<p><a href="index.php">🏠 กลับไปหน้าแรก</a></p>

<?php
if($result->num_rows > 0){
    $total = 0;
    echo '<table>';
    echo '<tr><th>สินค้า</th><th>ราคา/ชิ้น</th><th>จำนวน</th><th>ราคารวม</th></tr>';
    while($row = $result->fetch_assoc()){
        $subtotal = $row['price'] * $row['quantity'];
        $total += $subtotal;
        echo '<tr>';
        echo '<td><img src="images/'.$row["image"].'" alt="'.$row["name"].'"><br>'.$row["name"].'</td>';
        echo '<td>'.number_format($row["price"],2).' บาท</td>';
        echo '<td>'.$row["quantity"].'</td>';
        echo '<td>'.number_format($subtotal,2).' บาท</td>';
        echo '</tr>';
    }
    echo '<tr><th colspan="3">รวมทั้งหมด</th><th>'.number_format($total,2).' บาท</th></tr>';
    echo '</table>';
} else {
    echo "<p>ยังไม่มีสินค้าในตะกร้า</p>";
}

$conn->close();
?>
</body>
</html>
