<?php
require_once '../functions.php'; 
if(empty($_GET['id'])){
	header('Location:categories.php');
}
$id =$_GET['id'];
echo $id;
bx_execute('delete from tb_booktypeinfo where BookTypeId in ('.$id.');');
header('Location:categories.php');
