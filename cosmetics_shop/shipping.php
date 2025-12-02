<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Shipping Information</title>
</head>
<body>

<h2>ข้อมูลการจัดส่งสินค้า</h2>

<form action="confirm.php" method="post">

    <label>ชื่อ-นามสกุล:</label><br>
    <input type="text" name="fullname" required><br><br>

    <label>เบอร์โทรศัพท์:</label><br>
    <input type="text" name="phone" required><br><br>

    <label>ที่อยู่:</label><br>
    <textarea name="address" required></textarea><br><br>

    <label>จังหวัด:</label><br>
    <input type="text" name="province" required><br><br>

    <label>รหัสไปรษณีย์:</label><br>
    <input type="text" name="zipcode" required><br><br>

    <label>วิธีการจัดส่ง:</label><br>
    <select name="shipping_method">
        <option value="EMS">EMS - 60 บาท</option>
        <option value="REGISTERED">ลงทะเบียน - 40 บาท</option>
        <option value="FLASH">Flash Express - 50 บาท</option>
    </select><br><br>

    <label>วิธีการชำระเงิน:</label><br>
    <select name="payment_method">
        <option value="COD">เก็บปลายทาง (COD)</option>
        <option value="BANK">โอนผ่านธนาคาร</option>
        <option value="PROMPTPAY">PromptPay</option>
    </select><br><br>

    <button type="submit">ยืนยันข้อมูลการจัดส่ง</button>

</form>

</body>
</html>
