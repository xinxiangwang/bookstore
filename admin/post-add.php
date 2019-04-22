<?php
require_once '../config.php';
require_once '../functions.php'; 

/*获取分类列表*/
$sql = "select * from tb_BookTypeinfo";
$data = bx_fetch_all($sql);

function add_book(){

  if(empty($_POST['BookName'])){
    $GLOBALS['message'] = '请输入书名';
    return;
  }
  $BookName = $_POST['BookName'];

  if(empty($_POST['BookAuthor'])){
    $GLOBALS['message'] = '请输入作者';
    return;
  }
  $BookAuthor = $_POST['BookAuthor'];

  if(empty($_POST['Bookisbn'])){
    $GLOBALS['message'] = '请输入编号';
    return;
  }
  $Bookisbn = $_POST['Bookisbn'];

  if(empty($_POST['BookPress'])){
    $GLOBALS['message'] = '请输入出版社';
    return;
  }
  $BookPress = $_POST['BookPress'];

  if(empty($_POST['BookPrice'])){
    $GLOBALS['message'] = '请输入图书定价';
    return;
  }
  $BookPrice = $_POST['BookPrice'];

  if(empty($_POST['BookStoremount'])){
    $GLOBALS['message'] = '请输入图书库存';
    return;
  }
  $BookStoremount = $_POST['BookStoremount'];

  if(empty($_POST['BookMprice'])){
    $GLOBALS['message'] = '请输入图书市场价';
    return;
  }
  $BookMprice = $_POST['BookMprice'];

  if(empty($_POST['BookPubDate'])){
    $GLOBALS['message'] = '请输入出版日期';
    return;
  }
  $BookPubDate = $_POST['BookPubDate'];

  if(empty($_POST['BookPackstyle'])){
    $GLOBALS['message'] = '请正确提交文件';
    return;
  }

  $BookPackstyle = $_POST['BookPackstyle'];

  $BookType = $_POST['BookType'];

  /*获取用户上传书封面*/
  $picture = $_FILES['BookPic'];
  //var_dump($picture);
  /*array(5) {
    ["name"]=>
    string(7) "zjz.jpg"
    ["type"]=>
    string(10) "image/jpeg"
    ["tmp_name"]=>
    string(27) "C:\Windows\Temp\php5C36.tmp"
    ["error"]=>
    int(0)
    ["size"]=>
    int(52847)
  }*/
  if($picture['error'] === UPLOAD_ERR_OK){
    global $target;
    $target = '../static/uploads/'.uniqid().'-'.$picture['name'];
    if(!move_uploaded_file($picture['tmp_name'],$target)){
      $GLOBALS['message'] = '上传文件失败';
      return;
    };
    $sql = "insert into 
      tb_bookinfo(BookName,BookAuthor,Bookisbn,BookOutline,BookPress,BookPrice,BookMprice,BookTypeId,BookPubDate,BookPackstyle,BookStoremount,BookPic) 
      values(
      '{$BookName}','{$BookAuthor}',{$Bookisbn},'{$BookOutline}','{$BookPress}',{$BookPrice},{$BookMprice},{$BookType},'{$BookPubDate}','{$BookPackstyle}',{$BookStoremount},'{$target}');";
    $row = bx_execute($sql);
  }
    var_dump($sql);
    $GLOBALS['message'] = $row<=0? '添加失败':'添加成功';
    $GLOBALS['success'] = $row>0;    
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  add_book();
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.php"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="login.php"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="page-title">
        <h1>添加图书</h1>
      </div>
      <?php if(isset($message)): ?>
        <?php if($success): ?>
            <div class="alert alert-success">
             <strong>成功</strong><?php echo $message; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
             <strong>错误</strong><?php echo $message; ?>
            </div>
        <?php endif; ?>
      <?php endif; ?>
      <form class="row" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" method="post">
        <div class="col-md-7">
          <div class="form-group">
            <label for="BookName">书名</label>
            <input id="BookName" class="form-control input-lg" name="BookName" type="text" placeholder="书名">
          </div>
          <div class="form-group">
            <label for="BookAuthor">图书作者</label>
            <input id="BookAuthor" class="form-control input-lg" name="BookAuthor" type="text" placeholder="图书作者">
          </div>
          <div class="form-group">
            <label for="Bookisbn">图书编号</label>
            <input id="Bookisbn" class="form-control input-lg" name="Bookisbn" type="text" placeholder="图书编号">
          </div>

          <div class="form-group">
            <label for="BookOutline">图书简介</label>
            <textarea id="BookOutline" class="form-control input-lg" name="BookOutline" cols="30" rows="10" placeholder="图书简介"></textarea>
          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group">
            <label for="BookPress">出版社</label>
            <input id="BookPress" class="form-control" name="BookPress" type="text" placeholder="出版社">
          </div>
          <div class="form-group">
            <label for="BookPic">图书封面</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none">
            <input id="BookPic" class="form-control" name="BookPic" type="file">
          </div>
          <div class="form-group">
            <label for="BookPrice">图书定价</label>
            <input type="text" id="BookPrice" class="form-control" name="BookPrice" placeholder="图书定价">
          </div>
          <div class="form-group">
            <label for="BookStoremount">库存</label>
            <input type="text" id="BookStoremount" class="form-control" name="BookStoremount" placeholder="库存">
          </div>
          <div class="form-group">
            <label for="BookMprice">市场价</label>
            <input type="text" id="BookMprice" class="form-control" name="BookMprice" placeholder="市场价">
          </div>

          <div class="form-group">
            <label for="BookType">所属分类</label>
            <select id="BookType" class="form-control" name="BookType">
              <?php foreach($data as $item): ?>
              <option value="<?php echo $item['BookTypeId']; ?>"><?php echo $item['BookTypeName']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="BookPubDate">出版日期</label>
            <input type="date" id="BookPubDate" class="form-control" name="BookPubDate">
          </div>
          <div class="form-group">
            <label for="BookPackstyle">封装方式</label>
            <select id="BookPackstyle" class="form-control" name="BookPackstyle">
              <option value="精装">精装</option>
              <option value="平装-胶订">平装-胶订</option>
              <option value="线装">线装</option>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <?php $name = 'post-add'; ?>
  <?php include 'inc/aside.php';  ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
