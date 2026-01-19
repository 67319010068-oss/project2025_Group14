<?php
session_start();
// ตรวจสอบว่ามีสินค้าในตะกร้าไหม ถ้าไม่มีให้กลับไปหน้าตะกร้า
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}
$total_price = $_SESSION['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ชำระเงิน - Cosmetics Shop</title>
    <style>
        :root { --primary-color: #ff6b6b; --secondary-color: #4ecdc4; --bg-color: #f9f9fb; }
        body { font-family: 'Sarabun', sans-serif; background-color: var(--bg-color); margin: 0; padding: 20px; color: #333; }
        .checkout-container { max-width: 600px; margin: 0 auto; background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        h2 { color: var(--primary-color); text-align: center; margin-bottom: 30px; font-size: 24px; }
        
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        input[type="text"], textarea, select { 
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 10px; 
            box-sizing: border-box; transition: 0.3s; font-size: 16px;
        }
        input:focus, textarea:focus { border-color: var(--primary-color); outline: none; box-shadow: 0 0 8px rgba(255,107,107,0.2); }
        
        .row { display: flex; gap: 15px; }
        .row > div { flex: 1; }
        
        .order-summary { background: #fff5f5; padding: 20px; border-radius: 15px; margin-bottom: 25px; border: 1px dashed var(--primary-color); }
        .summary-row { display: flex; justify-content: space-between; font-size: 18px; font-weight: bold; }

        .btn-submit { 
            width: 100%; padding: 15px; background: linear-gradient(45deg, #ff6b6b, #ff8787); 
            color: white; border: none; border-radius: 12px; font-size: 18px; font-weight: bold;
            cursor: pointer; transition: 0.3s; box-shadow: 0 5px 15px rgba(255,107,107,0.3);
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(255,107,107,0.4); }
    </style>
</head>
<body>

<div class="checkout-container">
    <h2>🚚 ข้อมูลที่อยู่จัดส่ง</h2>
    
    <div class="order-summary">
        <div class="summary-row">
            <span>ยอดชำระรวม:</span>
            <span><?= number_format($total_price, 2) ?> บาท</span>
        </div>
    </div>

    <form action="save_order.php" method="POST">
        <div class="form-group">
            <label>ชื่อ-นามสกุล</label>
            <input type="text" name="fullname" placeholder="ระบุชื่อผู้รับสินค้า" required>
        </div>

        <div class="form-group">
            <label>เบอร์โทรศัพท์</label>
            <input type="text" name="phone" placeholder="08x-xxxxxxx" required>
        </div>

        <div class="form-group">
            <label>ที่อยู่จัดส่ง</label>
            <textarea name="address" rows="3" placeholder="บ้านเลขที่, ถนน, แขวง/ตำบล, เขต/อำเภอ" required></textarea>
        </div>

        <div class="row">
            <div class="form-group">
                <label>จังหวัด</label>
                <input type="text" name="province" required>
            </div>
            <div class="form-group">
                <label>รหัสไปรษณีย์</label>
                <input type="text" name="zipcode" required>
            </div>
        </div>

        <div class="form-group">
            <label>วิธีจัดส่ง</label>
            <select name="shipping_method" required>
                <option value="EMS">EMS (ด่วนพิเศษ)</option>
                <option value="REGISTERED">ลงทะเบียน</option>
                <option value="FLASH">Flash Express</option>
            </select>
        </div>

        <div class="form-group">
            <label>วิธีชำระเงิน</label>
            <select name="payment_method" required>
                <option value="cod">เก็บเงินปลายทาง (COD)</option>
                <option value="bank">โอนผ่านธนาคาร</option>
            </select>
        </div>

        <input type="hidden" name="total_price" value="<?= $total_price ?>">
        
        <button type="submit" class="btn-submit">ยืนยันการสั่งซื้อ</button>
    </form>
</div>

</body>
</html>