<?php
session_start();
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$product = $res->fetch_assoc();

if (!$product) {
    die("<div style='text-align:center; padding:50px;'><h1>ไม่พบสินค้า</h1><a href='index.php'>กลับหน้าหลัก</a></div>");
}

// โค้ดส่วนจัดการตะกร้าสินค้า
if (isset($_POST['add_cart'])) {
    $qty = intval($_POST['qty']);
    if ($qty < 1) { die("จำนวนไม่ถูกต้อง"); }
    if ($product['stock'] <= 0) { die("สินค้าหมด"); }
    
    // ส่วนนี้จัดการ Session ตะกร้าสินค้าตามระบบเดิมของคุณ
    $_SESSION['cart'][$id] = array(
        'name' => $product['name'],
        'price' => $product['price'],
        'qty' => $qty,
        'image' => $product['image']
    );
    echo "<script>alert('เพิ่มสินค้าลงตะกร้าแล้ว'); window.location='cart.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> - ร้านเครื่องสำอาง</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-pink: #ff85a1;
            --dark-pink: #f75c7e;
            --accent-red: #d90429;
            --soft-white: #fff5f7;
            --text-dark: #4a4a4a;
        }

        body {
            font-family: 'Sarabun', sans-serif;
            background-color: var(--soft-white);
            margin: 0;
            color: var(--text-dark);
        }

        .header {
            background: linear-gradient(135deg, var(--primary-pink), var(--accent-red));
            color: white;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .header h1 { margin: 0; font-size: 2.5rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.2); }

        .container {
            max-width: 1000px;
            margin: -30px auto 50px;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }

        .product-image {
            flex: 1;
            min-width: 300px;
            text-align: center;
        }

        .product-image img {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .product-image img:hover { transform: scale(1.02); }

        .product-details {
            flex: 1.2;
            min-width: 300px;
        }

        .product-details h2 {
            color: var(--accent-red);
            font-size: 2rem;
            margin-top: 0;
        }

        .price-tag {
            font-size: 1.8rem;
            color: var(--dark-pink);
            font-weight: bold;
            margin: 20px 0;
        }

        .stock-status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            background: #e8f5e9;
            color: #2e7d32;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .order-section {
            background: #fff0f3;
            padding: 20px;
            border-radius: 15px;
            margin-top: 25px;
        }

        .qty-input {
            width: 80px;
            padding: 10px;
            border: 2px solid var(--primary-pink);
            border-radius: 8px;
            text-align: center;
            font-size: 1rem;
        }

        .btn-add-cart {
            background: var(--accent-red);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background 0.3s;
            margin-left: 10px;
        }

        .btn-add-cart:hover { background: #b90422; }

        .back-link {
            display: block;
            margin-top: 20px;
            color: var(--primary-pink);
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>ร้านเครื่องสำอาง</h1>
    </div>

    <div class="container">
        <div class="product-image">
            <?php 
                // ตรวจสอบชื่อไฟล์จาก DB และกำหนด Path ไปยังโฟลเดอร์ assets/images/
                $img_name = !empty($product['image']) ? $product['image'] : "no_image.jpg";
                $img_path = "assets/images/" . $img_name;
            ?>
            <img src="<?php echo $img_path; ?>" alt="<?php echo $product['name']; ?>">
        </div>

        <div class="product-details">
            <h2><?php echo $product['name']; ?></h2>
            
            <div class="stock-status">
                คงเหลือ: <strong><?php echo $product['stock']; ?></strong> ชิ้น
            </div>

            <div class="price-tag">
                ฿<?php echo number_format($product['price'], 2); ?>
            </div>

            <div class="description">
                <p><?php echo $product['description']; ?></p>
            </div>

            <div class="order-section">
                <form method="POST">
                    <label for="qty">จำนวน: </label>
                    <input type="number" name="qty" class="qty-input" value="1" min="1" max="<?php echo $product['stock']; ?>">
                    <button type="submit" name="add_cart" class="btn-add-cart">
                        เพิ่มใส่ตะกร้า
                    </button>
                </form>
            </div>

            <a href="index.php" class="back-link">← กลับไปหน้าเลือกสินค้า</a>
        </div>
    </div>

</body>
</html>