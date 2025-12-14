<?php
require "koneksi.php";

$ip = $_SERVER['REMOTE_ADDR'];

$stmt = $conn->prepare("INSERT INTO visitor_log(ip_address) VALUES(?)");
$stmt->bind_param("s", $ip);
$stmt->execute();
$stmt->close();
