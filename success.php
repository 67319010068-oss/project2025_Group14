<?php
if (empty($_GET['order_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สั่งซื้อสำเร็จ</title>
</head>
<body>

<h2>🎉 สั่งซื้อสำเร็จ</h2>
<p>เลขที่คำสั่งซื้อ: <strong><?= htmlspecialchars($_GET['order_id']); ?></strong></p>

<a href="index.php">กลับไปหน้าร้าน</a>

</body>
</html>
