<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION['username'] = $row['username'];
      $_SESSION['role'] = $row['role'];

      if ($row['role'] == 'admin') {
        header("Location: admin_dashboard.php");
      } else {
        header("Location: user_dashboard.php");
      }
      exit;
    } else {
      $error = "รหัสผ่านไม่ถูกต้อง";
    }
  } else {
    $error = "ไม่พบบัญชีนี้";
  }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>เข้าสู่ระบบ</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
  <form method="post" class="bg-white p-8 rounded-2xl shadow-md w-80">
    <h2 class="text-2xl font-bold text-center mb-6">เข้าสู่ระบบ</h2>
    <?php if (!empty($error)) echo "<p class='text-red-500 text-center mb-3'>$error</p>"; ?>
    <input name="username" placeholder="ชื่อผู้ใช้" required class="border p-2 w-full rounded mb-3">
    <input type="password" name="password" placeholder="รหัสผ่าน" required class="border p-2 w-full rounded mb-3">
    <button type="submit" class="bg-green-500 text-white w-full py-2 rounded hover:bg-green-600">เข้าสู่ระบบ</button>
    <p class="text-sm text-center mt-4">ยังไม่มีบัญชี? <a href="register.php" class="text-blue-500">สมัครสมาชิก</a></p>
  </form>
</body>
</html>
