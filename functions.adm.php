<?php


function logged_in()
{
	return !empty($_SESSION['USER']);
}

function logout()
{
	if (!empty($_SESSION['USER'])) {
		unset($_SESSION['USER']);
	}
}

// Get user role
function get_role()
{
	return $_SESSION['USER']['role'] ?? 'guest'; // Default to 'guest' if not logged in
}

// Role-based access functions
function is_admin()
{
	return logged_in() && $_SESSION['USER']['role'] === 'admin';
}

function is_user()
{
	return logged_in() && $_SESSION['USER']['role'] === 'user';
}

// Function to check if user owns a post
function i_own_post($row)
{
	return logged_in() && $_SESSION['USER']['id'] == $row['user_id'];
}

// Function to check if user owns a profile
function i_own_profile($row)
{
	return logged_in() && $_SESSION['USER']['id'] == $row['id'];
}

// Get user profile image
function get_image($path)
{
	if (!empty($path) && file_exists($path)) {
		return $path;
	}
	return 'images/user.jpg?v1';
}

// DELETE ROOM FUNCTION
function delete_room($room_id)
{
	global $con; // Use global $conn for database connection
	if (!is_admin()) {
		return false; // Only admins can delete rooms
	}

	// Get room photo path
	$query = $con->prepare("SELECT photo FROM room WHERE room_id = ?");
	$query->bind_param("i", $room_id);
	$query->execute();
	$result = $query->get_result();

	if ($row = $result->fetch_assoc()) {
		$photo_path = "images/" . $row['photo'];

		// Delete the photo file if it exists
		if (!empty($row['photo']) && file_exists($photo_path)) {
			unlink($photo_path);
		}
	}

	// Delete room from database
	$delete_query = $con->prepare("DELETE FROM room WHERE room_id = ?");
	$delete_query->bind_param("i", $room_id);

	if ($delete_query->execute()) {
		return true; // Room deleted successfully
	}

	return false; // Deletion failed
}


function update_message_status($message_id)
{
	global $con; // Access the database connection

	if (!is_admin()) {
		return ["status" => "error", "message" => "Unauthorized"];
	}

	$query = "UPDATE message SET status = 'read' WHERE id = ?";
	$stmt = $con->prepare($query);
	$stmt->bind_param("i", $message_id);

	if ($stmt->execute()) {
		return ["status" => "success"];
	} else {
		return ["status" => "error", "message" => "Database update failed"];
	}
}

function deleteMessage($messageId, $con)
{
	$query = "DELETE FROM message WHERE id = ?";
	if ($stmt = $con->prepare($query)) {
		$stmt->bind_param("i", $messageId);
		if ($stmt->execute()) {
			return ["status" => "success"];
		} else {
			return ["status" => "error", "message" => "Database error"];
		}
	}
	return ["status" => "error", "message" => "Failed to prepare query"];
}

