<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$host = "localhost";    // ชื่อโฮสต์
$user = "root";         // ชื่อผู้ใช้ฐานข้อมูล (XAMPP ใช้ root)
$pass = "";             // รหัสผ่าน (XAMPP ปกติว่าง)
$dbname = "cosmetic_shop";  // ชื่อฐานข้อมูลของคุณ

// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect($host, $user, $pass, $dbname);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตั้งค่าภาษาไทยให้ใช้งานได้ถูกต้อง
mysqli_set_charset($conn, "utf8");
?>
