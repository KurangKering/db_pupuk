<?php 
session_start();

if (!isset($_SESSION['is_login'])) {
	
	header('Location: http://' . $_SERVER['SERVER_NAME'] . '/db_pupuk/index.php');
	exit;
}

