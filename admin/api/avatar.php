<?php 
require_once '../../config.php';
if(empty($_GET['username'])){
	exit();
}
$email = $_GET['username'];
$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if(!$connect){
	exit();
}
$query = mysqli_query($connect,"select avatar from users where email = '{$email}' limit 1;");
if(!$query){
	exit();
}
$aaa = mysqli_fetch_assoc($query);
if(isset($aaa['avatar'])){
	echo $aaa['avatar'];
}

?>
