<?php 
require_once '../functions.php';
if(empty($_GET['id'])){
	header('Location:users.php');
}
$id = $_GET['id'];
$row = bx_execute('delete from users where id in ('.$id.');');
if($row<=0){
	exit();
}
header('Location:users.php');
 ?>
