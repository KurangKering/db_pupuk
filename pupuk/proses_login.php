<?php 
session_start();
include 'CRUD.php';

$username = isset($_POST['login_username']) ? $_POST['login_username'] : "";
$password = isset($_POST['login_password']) ? $_POST['login_password'] : "";
$crud = new CRUD();
$result = $crud->log_in($username, $password);
if ($result == true) {
	$_SESSION['is_login'] = true;
	$_SESSION['username'] = $username;
}
echo $result;

?>