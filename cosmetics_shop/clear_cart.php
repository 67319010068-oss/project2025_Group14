<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$dbname = "cosmetic_shop";

$conn = new mysqli($host, $user, $password, $dbname);
if($conn->connect_error){ die("Connection failed: " . $conn->connect_error); }

$session_id = session_id();
$conn->query("DELETE FROM cart WHERE session_id='$session_id'");

$conn->close();
header("Location: index.php");
exit;
