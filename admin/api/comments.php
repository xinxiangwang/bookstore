<?php
require_once '../../functions.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1 ;

$size = 10;

$offset = ($page-1) * $size;

$total_pages = bx_fetch_one('select 
count(1) as num from tb_bookinfo; ')['num'];

$total_pages = ceil($total_pages/$size);

$sql = sprintf('select 
BookId,a.BookTypeId,b.BookTypeName,BookName,BookPress,BookPubDate,BookSize,BookAuthor,
Bookisbn,BookPrice,BookOutline,BookMprice,BookDealmount,BookDiscount,BookPic,BookStoremount,
BookPackstyle,BookStatus
from tb_bookinfo a
left join tb_booktypeinfo b
on a.BookTypeId = b.BookTypeId
limit %d,%d;',$offset,$size);

$data = bx_fetch_all($sql);

$json = json_encode(array(
	'total_pages' => $total_pages,
	'comments' => $data
));

header('Content-Type:application/json');

echo $json;

