<?php
session_start();
include 'config.php';

$order_id = intval($_POST['order_id']);
$status = $_POST['status'];

$stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
$stmt->bind_param("si", $status, $order_id);
$stmt->execute();

header("Location: admin_order_detail.php?id=" . $order_id);
exit;
