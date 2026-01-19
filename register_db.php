<?php
session_start();
include 'config.php'; // ดึงไฟล์เชื่อมต่อฐานข้อมูลมาใช้

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = 'user'; // กำหนดสิทธิ์เริ่มต้นเป็น user

    // 1. ตรวจสอบว่ารหัสผ่านตรงกันหรือไม่
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "รหัสผ่านไม่ตรงกัน";
        header("location: register.php");
        exit();
    }

    // 2. เช็คว่ามี Username หรือ Email นี้ในระบบแล้วหรือยัง
    $user_check = "SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1";
    $stmt = $conn->prepare($user_check);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if ($user['username'] === $username) { $_SESSION['error'] = "ชื่อผู้ใช้นี้มีคนใช้แล้ว"; }
        if ($user['email'] === $email) { $_SESSION['error'] = "อีเมลนี้มีคนใช้แล้ว"; }
        header("location: register.php");
        exit();
    }

    // 3. ถ้าทุกอย่างถูกต้อง ให้บันทึกข้อมูล
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // เข้ารหัสลับรหัสผ่าน
    
    $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว! กรุณาเข้าสู่ระบบ";
        header("location: login.php");
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่";
        header("location: register.php");
    }
}
?>