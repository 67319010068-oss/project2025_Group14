<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "cosmetic_shop";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ร้านเครื่องสำอาง</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    margin: 0; padding: 0;
}
header {
    background-color: #ff69b4;
    color: white;
    padding: 20px;
    text-align: center;
}
.products {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding: 20px;
}
.product {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    margin: 15px;
    width: 220px;
    padding: 15px;
    text-align: center;
}
.product img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 5px;
}
.product h3 {
    margin: 10px 0 5px;
}
.product p {
    margin: 5px 0;
    font-size: 14px;
}
.button {
    display: inline-block;
    padding: 8px 15px;
    margin-top: 10px;
    background-color: #ff69b4;
    color: white;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    cursor: pointer;
}
.button:hover {
    background-color: #ff85c1;
}
.add-product {
    display: block;
    text-align: center;
    margin: 20px;
    text-decoration: none;
    font-size: 18px;
    color: #ff69b4;
}
.add-product:hover {
    color: #ff85c1;
}
</style>
</head>
<body>

<header>
    <h1>ร้านเครื่องสำอาง</h1>
</header>

<a class="add-product" href="add_product.php">➕ เพิ่มสินค้าใหม่</a>

<div class="products">
<?php
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo '<div class="product">';
        echo '<img src="images/'.$row["image"].'" alt="'.$row["name"].'">';
        echo '<h3>'.$row["name"].'</h3>';
        echo '<p>ราคา: '.number_format($row["price"],2).' บาท</p>';
        echo '<p>'.$row["description"].'</p>';
        echo '<a class="button" href="#">ซื้อสินค้า</a>';
        echo '</div>';
    }
} else {
    echo "<p>ยังไม่มีสินค้า</p>";
}
$conn->close();
?>
</div>

</body>
</html>
