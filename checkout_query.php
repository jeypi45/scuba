<?php
require_once 'config.inc.php';
$time = date("H:i:s", strtotime("+8 HOURS"));
$con->query("UPDATE `transaction` SET `checkout_time` = '$time', `status` = 'Check Out' WHERE `transaction_id` = '$_REQUEST[transaction_id]'") or die(mysqli_error($con));
header("location:checkout.php");
?>