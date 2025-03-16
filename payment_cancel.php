<?php
session_start();
$_SESSION['error'] = "Payment was cancelled. Your reservation has not been completed.";
header("Location: add_reserve.php");
exit;
?>