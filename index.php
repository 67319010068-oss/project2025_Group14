<?php
session_start();
require_once 'config.php';

/* ดึงข้อมูลสินค้า */
$sql = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌸 ร้านเครื่องสำอาง - New Collection 2026</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-pink: #ff85a1;
            --dark-pink: #d6004a;
            --bg-soft: #fff5f8;
            --banner-gray: #b1a7a6;
        }

        body { margin: 0; font-family: 'Sarabun', sans-serif; background: var(--bg-soft); color: #333; }
        
        /* Navigation */
        header { 
            background: var(--dark-pink); 
            color: #fff; 
            padding: 15px 30px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        header a { color: white; text-decoration: none; margin-left: 20px; font-weight: bold; font-size: 14px; }
        header a:hover { color: #ffd1df; }
        .btn-admin-access { background: #333; padding: 8px 15px; border-radius: 20px; }

        /* Banner Slider */
        .banner-slider {
            position: relative;
            width: 100%;
            height: 400px;
            background-color: var(--banner-gray);
            overflow: hidden;
        }
        .slide {
            position: absolute;
            width: 100%;
            height: 100%;
            display: none;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            background-size: cover;
            background-position: center;
        }
        .slide.active { display: flex; animation: fade 0.8s; }
        @keyframes fade { from { opacity: 0.4; } to { opacity: 1; } }

        .slide-content h2 { font-size: 3.5rem; margin: 0 0 10px 0; text-shadow: 2px 2px 10px rgba(0,0,0,0.2); }
        .slide-content p { font-size: 1.3rem; margin-bottom: 25px; opacity: 0.9; }
        .btn-banner {
            padding: 12px 35px;
            background-color: var(--primary-pink);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .btn-banner:hover { background-color: white; color: var(--dark-pink); }

        .prev, .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.3);
            color: white;
            border: none;
            padding: 15px 20px;
            cursor: pointer;
            border-radius: 50%;
            font-size: 20px;
            z-index: 10;
            transition: 0.3s;
        }
        .prev:hover, .next:hover { background: var(--dark-pink); }
        .prev { left: 20px; }
        .next { right: 20px; }

        /* Products Grid */
        .container { padding: 40px 20px; max-width: 1200px; margin: 0 auto; }
        h2.section-title { text-align: center; color: var(--dark-pink); margin-bottom: 30px; }
        .products { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 25px; }
        
        .card { 
            background: white; 
            border-radius: 15px; 
            padding: 20px; 
            text-align: center; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); 
            transition: 0.3s; 
            border: 1px solid #eee;
        }
        .card:hover { transform: translateY(-10px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .card img { width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 15px; }
        .card h3 { font-size: 1.1rem; margin: 10px 0; color: #444; height: 2.4em; overflow: hidden; }
        .price { color: var(--dark-pink); font-weight: bold; font-size: 1.3rem; margin-bottom: 15px; }

        .btn-group { display: flex; flex-direction: column; gap: 8px; }
        .btn { padding: 10px; border: none; cursor: pointer; border-radius: 8px; text-decoration: none; font-weight: bold; transition: 0.3s; }
        .btn-detail { background: #f8f9fa; color: #666; border: 1px solid #ddd; }
        .btn-detail:hover { background: #eee; }
        .btn-cart { background: var(--primary-pink); color: white; }
        .btn-cart:hover { background: var(--dark-pink); }
    </style>
</head>
<body>

<header>
    <div><strong>🌸 ร้านเครื่องสำอาง</strong></div>
    <nav>
        <a href="index.php">หน้าแรก</a>
        <a href="cart.php">ตะกร้า</a>
        <a href="order_history.php">ประวัติ</a>
        <a href="admin/dashboard.php" class="btn-admin-access">⚙️ จัดการระบบ</a>
        <?php if(isset($_SESSION['user'])): ?>
            <a href="logout.php">ออกจากระบบ</a>
        <?php else: ?>
            <a href="login.php">เข้าสู่ระบบ</a>
        <?php endif; ?>
    </nav>
</header>

<div class="banner-slider">
    <div class="slides">
        <div class="slide active">
            <div class="slide-content">
                <h2>New Collection 2026</h2>
                <p>สัมผัสความงามระดับพรีเมียมได้แล้ววันนี้</p>
                <a href="#products-list" class="btn-banner">ช้อปเลย</a>
            </div>
        </div>
        <div class="slide">
            <div class="slide-content">
                <h2>Hot Promotion!</h2>
                <p>ลดสูงสุด 50% สำหรับสมาชิกใหม่</p>
                <a href="#products-list" class="btn-banner">ดูโปรโมชั่น</a>
            </div>
        </div>
    </div>
    <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
    <button class="next" onclick="changeSlide(1)">&#10095;</button>
</div>

<div class="container" id="products-list">
    <h2 class="section-title">📦 สินค้าทั้งหมด</h2>
    <div class="products">
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="card">
                    <img src="assets/images/<?= htmlspecialchars($row['image']) ?>" onerror="this.src='https://via.placeholder.com/250x200?text=No+Image'">
                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                    <p class="price"><?= number_format($row['price'], 2) ?> บาท</p>

                    <div class="btn-group">
                        <a class="btn btn-detail" href="product_detail.php?id=<?= $row['id'] ?>">ดูรายละเอียด</a>
                        <form action="add_to_cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                            <button class="btn btn-cart" type="submit" style="width:100%;">🛒 เพิ่มลงตะกร้า</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center; grid-column: 1/-1;">ขออภัย ยังไม่มีสินค้าในขณะนี้</p>
        <?php endif; ?>
    </div>
</div>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');

    function showSlide(index) {
        slides.forEach(s => s.classList.remove('active'));
        
        if (index >= slides.length) currentSlide = 0;
        else if (index < 0) currentSlide = slides.length - 1;
        else currentSlide = index;
        
        slides[currentSlide].classList.add('active');
    }

    function changeSlide(step) {
        currentSlide += step;
        showSlide(currentSlide);
    }

    // เลื่อนอัตโนมัติทุก 5 วินาที
    let autoSlide = setInterval(() => changeSlide(1), 5000);

    // หยุดเลื่อนชั่วคราวเมื่อมีการกดปุ่ม
    document.querySelectorAll('.prev, .next').forEach(btn => {
        btn.addEventListener('click', () => {
            clearInterval(autoSlide);
            autoSlide = setInterval(() => changeSlide(1), 5000);
        });
    });
</script>

</body>
</html><?php

session_start();

require_once 'config.php';



/* ดึงข้อมูลสินค้า */

$sql = "SELECT * FROM products ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>

<html lang="th">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>🌸 ร้านเครื่องสำอาง - New Collection 2026</title>

    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap" rel="stylesheet">

    <style>

        :root {

            --primary-pink: #ff85a1;

            --dark-pink: #d6004a;

            --bg-soft: #fff5f8;

            --banner-gray: #b1a7a6;

        }



        body { margin: 0; font-family: 'Sarabun', sans-serif; background: var(--bg-soft); color: #333; }

       

        /* Navigation */

        header {

            background: var(--dark-pink);

            color: #fff;

            padding: 15px 30px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            box-shadow: 0 2px 10px rgba(0,0,0,0.1);

            position: sticky;

            top: 0;

            z-index: 1000;

        }

        header a { color: white; text-decoration: none; margin-left: 20px; font-weight: bold; font-size: 14px; }

        header a:hover { color: #ffd1df; }

        .btn-admin-access { background: #333; padding: 8px 15px; border-radius: 20px; }



        /* Banner Slider */

        .banner-slider {

            position: relative;

            width: 100%;

            height: 400px;

            background-color: var(--banner-gray);

            overflow: hidden;

        }

        .slide {

            position: absolute;

            width: 100%;

            height: 100%;

            display: none;

            align-items: center;

            justify-content: center;

            text-align: center;

            color: white;

            background-size: cover;

            background-position: center;

        }

        .slide.active { display: flex; animation: fade 0.8s; }

        @keyframes fade { from { opacity: 0.4; } to { opacity: 1; } }



        .slide-content h2 { font-size: 3.5rem; margin: 0 0 10px 0; text-shadow: 2px 2px 10px rgba(0,0,0,0.2); }

        .slide-content p { font-size: 1.3rem; margin-bottom: 25px; opacity: 0.9; }

        .btn-banner {

            padding: 12px 35px;

            background-color: var(--primary-pink);

            color: white;

            text-decoration: none;

            border-radius: 30px;

            font-weight: bold;

            transition: 0.3s;

            box-shadow: 0 4px 15px rgba(0,0,0,0.1);

        }

        .btn-banner:hover { background-color: white; color: var(--dark-pink); }



        .prev, .next {

            position: absolute;

            top: 50%;

            transform: translateY(-50%);

            background: rgba(0,0,0,0.3);

            color: white;

            border: none;

            padding: 15px 20px;

            cursor: pointer;

            border-radius: 50%;

            font-size: 20px;

            z-index: 10;

            transition: 0.3s;

        }

        .prev:hover, .next:hover { background: var(--dark-pink); }

        .prev { left: 20px; }

        .next { right: 20px; }



        /* Products Grid */

        .container { padding: 40px 20px; max-width: 1200px; margin: 0 auto; }

        h2.section-title { text-align: center; color: var(--dark-pink); margin-bottom: 30px; }

        .products { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 25px; }

       

        .card {

            background: white;

            border-radius: 15px;

            padding: 20px;

            text-align: center;

            box-shadow: 0 5px 15px rgba(0,0,0,0.05);

            transition: 0.3s;

            border: 1px solid #eee;

        }

        .card:hover { transform: translateY(-10px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }

        .card img { width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 15px; }

        .card h3 { font-size: 1.1rem; margin: 10px 0; color: #444; height: 2.4em; overflow: hidden; }

        .price { color: var(--dark-pink); font-weight: bold; font-size: 1.3rem; margin-bottom: 15px; }



        .btn-group { display: flex; flex-direction: column; gap: 8px; }

        .btn { padding: 10px; border: none; cursor: pointer; border-radius: 8px; text-decoration: none; font-weight: bold; transition: 0.3s; }

        .btn-detail { background: #f8f9fa; color: #666; border: 1px solid #ddd; }

        .btn-detail:hover { background: #eee; }

        .btn-cart { background: var(--primary-pink); color: white; }

        .btn-cart:hover { background: var(--dark-pink); }

    </style>

</head>

<body>



<header>

    <div><strong>🌸 ร้านเครื่องสำอาง</strong></div>

    <nav>

        <a href="index.php">หน้าแรก</a>

        <a href="cart.php">ตะกร้า</a>

        <a href="order_history.php">ประวัติ</a>

        <a href="admin/dashboard.php" class="btn-admin-access">⚙️ จัดการระบบ</a>

        <?php if(isset($_SESSION['user'])): ?>

            <a href="logout.php">ออกจากระบบ</a>

        <?php else: ?>

            <a href="login.php">เข้าสู่ระบบ</a>

        <?php endif; ?>

    </nav>

</header>



<div class="banner-slider">

    <div class="slides">

        <div class="slide active">

            <div class="slide-content">

                <h2>New Collection 2026</h2>

                <p>สัมผัสความงามระดับพรีเมียมได้แล้ววันนี้</p>

                <a href="#products-list" class="btn-banner">ช้อปเลย</a>

            </div>

        </div>

        <div class="slide">

            <div class="slide-content">

                <h2>Hot Promotion!</h2>

                <p>ลดสูงสุด 50% สำหรับสมาชิกใหม่</p>

                <a href="#products-list" class="btn-banner">ดูโปรโมชั่น</a>

            </div>

        </div>

    </div>

    <button class="prev" onclick="changeSlide(-1)">&#10094;</button>

    <button class="next" onclick="changeSlide(1)">&#10095;</button>

</div>



<div class="container" id="products-list">

    <h2 class="section-title">📦 สินค้าทั้งหมด</h2>

    <div class="products">

        <?php if ($result && mysqli_num_rows($result) > 0): ?>

            <?php while($row = mysqli_fetch_assoc($result)): ?>

                <div class="card">

                    <img src="assets/images/<?= htmlspecialchars($row['image']) ?>" onerror="this.src='https://via.placeholder.com/250x200?text=No+Image'">

                    <h3><?= htmlspecialchars($row['name']) ?></h3>

                    <p class="price"><?= number_format($row['price'], 2) ?> บาท</p>



                    <div class="btn-group">

                        <a class="btn btn-detail" href="product_detail.php?id=<?= $row['id'] ?>">ดูรายละเอียด</a>

                        <form action="add_to_cart.php" method="post">

                            <input type="hidden" name="product_id" value="<?= $row['id'] ?>">

                            <button class="btn btn-cart" type="submit" style="width:100%;">🛒 เพิ่มลงตะกร้า</button>

                        </form>

                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <p style="text-align:center; grid-column: 1/-1;">ขออภัย ยังไม่มีสินค้าในขณะนี้</p>

        <?php endif; ?>

    </div>

</div>



<script>

    let currentSlide = 0;

    const slides = document.querySelectorAll('.slide');



    function showSlide(index) {

        slides.forEach(s => s.classList.remove('active'));

       

        if (index >= slides.length) currentSlide = 0;

        else if (index < 0) currentSlide = slides.length - 1;

        else currentSlide = index;

       

        slides[currentSlide].classList.add('active');

    }



    function changeSlide(step) {

        currentSlide += step;

        showSlide(currentSlide);

    }



    // เลื่อนอัตโนมัติทุก 5 วินาที

    let autoSlide = setInterval(() => changeSlide(1), 5000);



    // หยุดเลื่อนชั่วคราวเมื่อมีการกดปุ่ม

    document.querySelectorAll('.prev, .next').forEach(btn => {

        btn.addEventListener('click', () => {

            clearInterval(autoSlide);

            autoSlide = setInterval(() => changeSlide(1), 5000);

        });

    });

</script>



</body>

</html>
