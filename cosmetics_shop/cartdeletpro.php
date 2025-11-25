<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$dbname = "cosmetic_shop";

$conn = new mysqli($host, $user, $password, $dbname);
if($conn->connect_error){ die("Connection failed: " . $conn->connect_error); }

$session_id = session_id();

// อัปเดตจำนวน
if(isset($_POST['update'])){
    foreach($_POST['quantity'] as $cart_id => $qty){
        $qty = (int)$qty;
        if($qty > 0){
            $conn->query("UPDATE cart SET quantity=$qty WHERE id=$cart_id AND session_id='$session_id'");
        }
    }
}

// ลบสินค้า
if(isset($_POST['delete'])){
    $delete_id = (int)$_POST['delete_id'];
    $conn->query("DELETE FROM cart WHERE id=$delete_id AND session_id='$session_id'");
}

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
input[type=number]{ width:50px; }
</style>
</head>
<body>

<h1>ตะกร้าสินค้า</h1>
<p><a href="index.php">🏠 กลับไปหน้าแรก</a></p>

<form method="post">
<?php
if($result->num_rows > 0){
    $total = 0;
    echo '<table>';
    echo '<tr><th>สินค้า</th><th>ราคา/ชิ้น</th><th>จำนวน</th><th>ราคารวม</th><th>จัดการ</th></tr>';
    while($row = $result->fetch_assoc()){
        $subtotal = $row['price'] * $row['quantity'];
        $total += $subtotal;
        echo '<tr>';
        echo '<td><img src="images/'.$row["image"].'" alt="'.$row["name"].'"><br>'.$row["name"].'</td>';
        echo '<td>'.number_format($row["price"],2).' บาท</td>';
        echo '<td><input type="number" name="quantity['.$row["cart_id"].']" value="'.$row["quantity"].'" min="1"></td>';
        echo '<td>'.number_format($subtotal,2).' บาท</td>';
        echo '<td>
                <button type="submit" name="delete" class="button" value="ลบ">
                    ลบ
                </button>
                <input type="hidden" name="delete_id" value="'.$row["cart_id"].'">
              </td>';
        echo '</tr>';
    }
    echo '<tr><th colspan="3">รวมทั้งหมด</th><th colspan="2">'.number_format($total,2).' บาท</th></tr>';
    echo '</table>';
    echo '<br><button type="submit" name="update" class="button">อัปเดตจำนวน</button>';
    echo ' <a href="checkout.php" class="button">💳 สรุปคำสั่งซื้อ</a>';
} else {
    echo "<p>ยังไม่มีสินค้าในตะกร้า</p>";
}
$conn->close();
?>
</form>
</body>
</html>
