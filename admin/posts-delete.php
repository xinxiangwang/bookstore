<?php 
require_once '../functions.php';
if(empty($_GET['id'])){
	header('Location:posts.php');
}
$id = $_GET['id'];
$row = bx_execute('delete from posts where id in ('.$id.');');
if($row<=0){
	exit();
}
header('Location:'.$_SERVER['HTTP_REFERER']);
 ?>