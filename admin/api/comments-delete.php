<?php
require_once '../../functions.php';
if(empty($_GET['id'])){
	exit();
}
$id = $_GET['id'];
$row = bx_execute('delete from tb_bookinfo where BookId in ('.$id.');');
header('Content-Type:application/json');
echo json_encode($row>0);