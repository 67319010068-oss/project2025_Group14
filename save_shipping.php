<?php
session_start();

$_SESSION['shipping'] = [
    'fullname' => $_POST['fullname'],
    'phone' => $_POST['phone'],
    'address' => $_POST['address'],
    'province' => $_POST['province'],
    'zipcode' => $_POST['zipcode'],
    'shipping_method' => $_POST['shipping_method'],
    'payment_method' => $_POST['payment_method']
];

header("Location: save_order.php");
exit;
