<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role']!='admin'){
    header("Location: ../login.php");
    exit;
}
include '../config/db.php';

$products = $conn->query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<header><h1>Admin Dashboard</h1></header>
<main>
<a href="add_product.php">เพิ่มสินค้า</a>
<table border="1">
<tr><th>ชื่อ</th><th>ราคา</th><th>รูป</th><th>จัดการ</th></tr>
<?php while($row=$products->fetch_assoc()): ?>
<tr>
<td><?php echo $row['name'];?></td>
<td><?php echo $row['price'];?></td>
<td><img src="../assets/images/<?php echo $row['image'];?>" width="50"></td>
<td>
<a href="edit_product.php?id=<?php echo $row['id'];?>">แก้ไข</a>
<a href="delete_product.php?id=<?php echo $row['id'];?>" onclick="return confirm('ลบหรือไม่?')">ลบ</a>
</td>
</tr>
<?php endwhile;?>
</table>
<a href="../index.php">กลับหน้าหลัก</a>
</main>
</body>
</html>
