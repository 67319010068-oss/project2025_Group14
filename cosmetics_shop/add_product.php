<?php
session_start();
include '../config/db.php';

// ตรวจสอบสิทธิ์ Admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: ../index.php");
    exit;
}

if(isset($_POST['add_product'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // อัปโหลดรูปภาพ
    $image = $_FILES['image']['name'];
    $target = "../assets/images/" . basename($image);
    
    if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
        $stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (?,?,?,?)");
        $stmt->bind_param("sdss", $name, $price, $description, $image);
        if($stmt->execute()){
            $success = "เพิ่มสินค้าสำเร็จ!";
        } else {
            $error = "เกิดข้อผิดพลาดในการเพิ่มสินค้า";
        }
    } else {
        $error = "ไม่สามารถอัปโหลดรูปภาพได้";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>เพิ่มสินค้าเครื่องสำอาง</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="form-container">
    <h2>เพิ่มสินค้าเครื่องสำอาง</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="ชื่อสินค้า" required>
        <input type="number" step="0.01" name="price" placeholder="ราคา" required>
        <textarea name="description" placeholder="รายละเอียดสินค้า"></textarea>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit" name="add_product">เพิ่มสินค้า</button>
    </form>
    <?php 
    if(isset($success)) echo "<p class='success'>$success</p>";
    if(isset($error)) echo "<p class='error'>$error</p>";
    ?>
    <p><a href="dashboard.php">กลับไปหน้าจัดการสินค้า</a></p>
</div>
</body>
</html>
