<?php
session_start();
include 'config/db.php';

if(!isset($_GET['id'])){ header("Location: index.php"); }
$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$res = $stmt->get_result();
$product = $res->fetch_assoc();

if(isset($_POST['add_cart'])){
    if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    $qty = intval($_POST['quantity']);
    if(isset($_SESSION['cart'][$id])){
        $_SESSION['cart'][$id] += $qty;
    } else {
        $_SESSION['cart'][$id] = $qty;
    }
    header("Location: cart.php");
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title><?php echo $product['name']; ?></title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1><a href="index.php">ร้านเครื่องสำอาง</a></h1>
</header>
<main class="product-detail">
    <img src="assets/images/<?php echo $product['image']; ?>" alt="">
    <h2><?php echo $product['name']; ?></h2>
    <p><?php echo $product['description']; ?></p>
    <p>ราคา: <?php echo number_format($product['price'],2); ?> บาท</p>
    <form method="POST">
        <input type="number" name="quantity" value="1" min="1">
        <button type="submit" name="add_cart">เพิ่มใส่ตะกร้า</button>
    </form>
</main>
</body>
</html>
