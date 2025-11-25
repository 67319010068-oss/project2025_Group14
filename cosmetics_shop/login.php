<?php
session_start();
include 'config/db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if($user && password_verify($password,$user['password'])){
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>เข้าสู่ระบบ</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="form-container">
    <h2>เข้าสู่ระบบ</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="ชื่อผู้ใช้" required>
        <input type="password" name="password" placeholder="รหัสผ่าน" required>
        <button type="submit" name="login">เข้าสู่ระบบ</button>
    </form>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <p>ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
</div>
</body>
</html>
