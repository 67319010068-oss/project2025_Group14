<style>
    form { max-width: 500px; margin: auto; padding: 20px; background: #fff; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); font-family: 'Sarabun', sans-serif; }
    input, textarea, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
    .btn-submit { width: 100%; padding: 15px; background-color: #ff6b6b; color: white; border: none; border-radius: 10px; font-weight: bold; cursor: pointer; margin-top: 20px; transition: 0.3s; }
    .btn-submit:hover { background-color: #ee5253; }
</style>

<form action="save_order.php" method="POST">
    <h3>📍 ข้อมูลจัดส่งสินค้า</h3>
    
    <label>ชื่อ-นามสกุล:</label>
    <input type="text" name="fullname" placeholder="ระบุชื่อและนามสกุลผู้รับ" required>

    <label>เบอร์โทรศัพท์:</label>
    <input type="text" name="phone" placeholder="เช่น 0812345678" required>

    <label>ที่อยู่จัดส่ง:</label>
    <textarea name="address" rows="3" placeholder="เลขที่บ้าน, หมู่บ้าน, ถนน, แขวง/ตำบล" required></textarea>

    <div style="display: flex; gap: 10px; margin-top: 10px;">
        <div style="flex: 1;">
            <label>จังหวัด:</label>
            <input type="text" name="province" required>
        </div>
        <div style="flex: 1;">
            <label>รหัสไปรษณีย์:</label>
            <input type="text" name="zipcode" maxlength="5" required>
        </div>
    </div>

    <label style="margin-top: 15px; display: block;">🚚 วิธีจัดส่ง:</label>
    <select name="shipping_method">
        <option value="EMS">EMS (+60 บาท)</option>
        <option value="REGISTERED">ลงทะเบียน (+40 บาท)</option>
        <option value="FLASH">Flash Express (+50 บาท)</option>
    </select>

    <label style="margin-top: 15px; display: block;">💳 วิธีชำระเงิน:</label>
    <select name="payment_method">
        <option value="bank">โอนผ่านธนาคาร (แนะนำ)</option>
        <option value="cod">ชำระเงินปลายทาง (COD)</option>
        <option value="wallet">TrueMoney Wallet</option>
    </select>

    <input type="hidden" name="total_price" value="<?= $_SESSION['total'] ?>">
    <button type="submit" class="btn-submit">ยืนยันการสั่งซื้อ</button>
</form>