<?php
/*登录页面返回用户头像src*/
if(empty($_FILES['avatar'])){
	exit();
}
$avatar = $_FILES['avatar'];

if($avatar['error'] !== UPLOAD_ERR_OK){
	exit();
};

$ext = pathinfo($avatar['name'],PATHINFO_EXTENSION);

$target = '../../static/uploads/img-' . uniqid() . '.' . $ext;

if(!move_uploaded_file($avatar['tmp_name'], $target)){
	exit('上传失败');
}
echo substr($target,5);
