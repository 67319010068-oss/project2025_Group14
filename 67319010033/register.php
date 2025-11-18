<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = $_POST['role']; // admin หรือ user

  $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
  if ($conn->query($sql)) {
    echo "<script>alert('สมัครสมาชิกสำเร็จ!');window.location='login.php';</script>";
  } else {
    echo "Error: " . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>สมัครสมาชิก</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
  <form method="post" class="bg-white p-8 rounded-2xl shadow-md w-80">
    <h2 class="text-2xl font-bold text-center mb-6">สมัครสมาชิก</h2>
    <input name="username" placeholder="ชื่อผู้ใช้" required class="border p-2 w-full rounded mb-3">
    <input type="password" name="password" placeholder="รหัสผ่าน" required class="border p-2 w-full rounded mb-3">
    <select name="role" class="border p-2 w-full rounded mb-3">
      <option value="user">User</option>
      <option value="admin">Admin</option>
    </select>
    <button type="submit" class="bg-blue-500 text-white w-full py-2 rounded hover:bg-blue-600">สมัคร</button>
    <p class="text-sm text-center mt-4">มีบัญชีแล้ว? <a href="login.php" class="text-blue-500">เข้าสู่ระบบ</a></p>
  </form>
</body>
</html>
