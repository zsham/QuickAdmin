<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'save_password'){
	$save = $crud->save_password();
	if($save)
		echo $save;
}
if($action == 'update_user_verify'){
	$save = $crud->update_user_verify();
	if($save)
		echo $save;
}
if($action == "delete_user"){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == "save_category"){
	$save = $crud->save_category();
	if($save)
		echo $save;
}
if($action == "delete_category"){
	$save = $crud->delete_category();
	if($save)
		echo $save;
}
if($action == "cancel_book"){
	$save = $crud->cancel_book();
	if($save)
		echo $save;
}
if($action == "cancel_book_admin"){
	$save = $crud->cancel_book_admin();
	if($save)
		echo $save;
}
if($action == "save_item"){
	$save = $crud->save_item();
	if($save)
		echo $save;
}
if($action == "delete_item"){
	$save = $crud->delete_item();
	if($save)
		echo $save;
}
if($action == "save_check-in"){
	$save = $crud->save_check_in();
	if($save)
		echo $save;
}
if($action == "save_checkout"){
	$save = $crud->save_checkout();
	if($save)
		echo $save;
}
if($action == "save_book"){
	$save = $crud->save_book();
	if($save)
		echo $save;
}

