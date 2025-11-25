<?php
session_start();
include 'config/db.php';

$products = $conn->query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ร้านเครื่องสำอาง</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1>ร้านเครื่องสำอาง</h1>
    <nav>
        <?php if(isset($_SESSION['user'])): ?>
            <span>สวัสดี, <?php echo $_SESSION['user']; ?></span>
            <a href="cart.php">ตะกร้า</a>
            <?php if($_SESSION['role']=='admin'): ?>
                <a href="admin/dashboard.php">Admin</a>
            <?php endif; ?>
            <a href="logout.php">ออกจากระบบ</a>
        <?php else: ?>
            <a href="login.php">เข้าสู่ระบบ</a>
            <a href="register.php">สมัครสมาชิก</a>
        <?php endif; ?>
    </nav>
</header>

<main class="product-grid">
    <?php while($row = $products->fetch_assoc()): ?>
        <div class="product-card">
            <img src="assets/images/<?php echo $row['image']; ?>" alt="">
            <h3><?php echo $row['name']; ?></h3>
            <p><?php echo number_format($row['price'],2); ?> บาท</p>
            <a href="product.php?id=<?php echo $row['id']; ?>" class="btn">ดูรายละเอียด</a>
        </div>
    <?php endwhile; ?>
</main>
</body>
</html>
