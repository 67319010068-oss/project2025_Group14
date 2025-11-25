<?php
session_start();
include 'config/db.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username,email,password) VALUES (?,?,?)");
    $stmt->bind_param("sss",$username,$email,$password);

    if($stmt->execute()){
        $_SESSION['user'] = $username;
        $_SESSION['role'] = 'user';
        header("Location: index.php");
    } else {
        $error = "สมัครสมาชิกไม่สำเร็จ";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>สมัครสมาชิก</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="form-container">
    <h2>สมัครสมาชิก</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="ชื่อผู้ใช้" required>
        <input type="email" name="email" placeholder="อีเมล" required>
        <input type="password" name="password" placeholder="รหัสผ่าน" required>
        <button type="submit" name="register">สมัครสมาชิก</button>
    </form>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <p>มีบัญชีแล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
</div>
</body>
</html>
