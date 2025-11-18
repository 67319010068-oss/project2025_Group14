<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-8">
  <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-4">ยินดีต้อนรับคุณ, <?= $_SESSION['username'] ?></h1>
    <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">ออกจากระบบ</a>
  </div>
</body>
</html>
