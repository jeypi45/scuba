<?php
require_once 'config.inc.php';
$con->query("DELETE FROM `transaction` WHERE `transaction_id` = '$_REQUEST[transaction_id]'") or die(mysqli_error($con));
header("location:booking.php");
?>