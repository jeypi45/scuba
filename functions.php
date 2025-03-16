<?php
session_start();

defined('APP') or die('direct script access denied!');

function authenticate($row)
{
	$_SESSION['USER'] = $row;
	$_SESSION['USER']['role'] = $row['role']; // Store role in session
}

function query($query)
{
	global $con;

	$result = mysqli_query($con, $query);
	if (!is_bool($result) && mysqli_num_rows($result) > 0) {
		$data = [];
		while ($row = mysqli_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	return false;
}

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
