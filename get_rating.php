<?php
require('config.inc.php');

header("Content-Type: application/json");

// Ensure database connection exists
if (!$con) {
    echo json_encode(["success" => false, "message" => "Database connection error"]);
    exit;
}

// Get item ID from request (ensure it's valid)
$item_id = $_GET['item_id'] ?? 0;
$item_id = (int) $item_id;

if ($item_id < 1) {
    echo json_encode(["success" => false, "message" => "Invalid item ID"]);
    exit;
}

// Fetch average rating for the specific item
$query = "SELECT AVG(rating) as avg_rating FROM ratings WHERE item_id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $item_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode(["average" => round($row["avg_rating"], 2)]); // Round for cleaner output
} else {
    echo json_encode(["success" => false, "message" => "Query failed"]);
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>