<?php 
require_once 'config.php';
session_start();
function bx_get_current_user (){
	if(empty($_SESSION['limit'])){
  		header('Location:/admin/login.php');
  		exit();
	}
	return $_SESSION['limit'];
}

function bx_fetch_all($sql){
	$result = [];
	$con = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	if(!$con){
		exit();
	}
	$query = mysqli_query($con,$sql);
	if(!$query){
		return false;
	}
	while($data = mysqli_fetch_assoc($query)){
		$result[] = $data;
	}
	mysqli_close($con);
	return $result;
}

function bx_fetch_one($sql){
	$res = bx_fetch_all($sql);
	return isset($res[0])?$res[0]:false;
}

function bx_execute($sql){
	$con = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	if(!$con){
		exit();
	}
	$query = mysqli_query($con,$sql);
	if(!$query){
		return false;
	}
	$rows = mysqli_affected_rows($con);
	mysqli_close($con);
	return $rows;
}

