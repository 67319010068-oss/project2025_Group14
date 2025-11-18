<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: login.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: admin.php');
    exit;
}

// ป้องกันลบตัวเอง
if ($id == $_SESSION['user_id']) {
    die('ไม่สามารถลบผู้ใช้ของตนเองได้');
}

$stmt = $conn->prepare("DELETE FROM users WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    header('Location: admin.php');
    exit;
} else {
    echo "ลบไม่สำเร็จ: " . $stmt->error;
}
