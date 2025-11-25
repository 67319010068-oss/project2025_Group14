<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$dbname = "cosmetic_shop";

$conn = new mysqli($host, $user, $password, $dbname);
if($conn->connect_error){ die("Connection failed: " . $conn->connect_error); }

if(isset($_POST['product_id']) && isset($_POST['quantity'])){
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $session_id = session_id();

    // ตรวจสอบว่ามีสินค้าอยู่ใน cart แล้วหรือไม่
    $sql_check = "SELECT * FROM cart WHERE product_id=$product_id AND session_id='$session_id'";
    $result = $conn->query($sql_check);
    if($result->num_rows > 0){
        // ถ้ามีแล้ว ให้บวกจำนวน
        $row = $result->fetch_assoc();
        $new_qty = $row['quantity'] + $quantity;
        $sql_update = "UPDATE cart SET quantity=$new_qty WHERE id=".$row['id'];
        $conn->query($sql_update);
    } else {
        // ถ้าไม่มี ให้เพิ่มใหม่
        $sql_insert = "INSERT INTO cart (product_id, quantity, session_id) VALUES ($product_id, $quantity, '$session_id')";
        $conn->query($sql_insert);
    }
}

$conn->close();
header("Location: cart.php"); // redirect ไปหน้า cart
exit;
