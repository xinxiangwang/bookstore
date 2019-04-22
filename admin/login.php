<?php 
require_once '../config.php';
session_start();
function login(){
  if(empty($_POST['email'])){
    $GLOBALS['message'] = '请输入邮箱';
    return;
  }
  if(empty($_POST['password'])){
    $GLOBALS['message'] = '请输入密码';
    return;
  }

  $email = $_POST['email'];
  $password = $_POST['password'];

  $connect = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if(!$connect){
    exit('<h1>数据库连接失败</h1>');
  }

  $query = mysqli_query($connect,"select * from users where email = '{$email}' limit 1;");
  if(!$query){
    $GLOBALS['message'] = '数据库连接失败';
    return;
  }
  $user = mysqli_fetch_assoc($query);
  if(!$user){
    $GLOBALS['message'] = '用户名不存在';
    return;
  }
  if($user['password'] !== $password){
    $GLOBALS['message'] = '密码错误';
    return;
  }
  $_SESSION['limit'] = $user;

  header('Location: index.php');

}
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] == 'logout'){
  unset($_SESSION['limit']);
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  login();
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <link rel="stylesheet" href="/static/assets/vendors/animate/animate.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap <?php echo isset($message)?' tada animated':'' ?>" method = "post" action ="<?php echo $_SERVER['PHP_SELF']; ?>" autocomplete="off">
      <img id="img" class="avatar" src="/static/assets/img/default.png">
      <?php if(isset($message)): ?>
       <div class="alert alert-danger">
        <strong>错误！</strong> <?php echo $message; ?>
      </div> 
      <?php endif ?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" name = "email" type="email" class="form-control" placeholder="邮箱" autofocus value = "<?php echo isset($_POST['email'])? $_POST['email'] : '' ?>">
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" name="password" type="password" class="form-control" placeholder="密码">
      </div>
      <button class="btn btn-primary btn-block" href="index.php">登 录</button>
    </form>
  </div>
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script type="text/javascript">
    /*var email = document.getElementById("email");
    email.onblur=function(){
      var un = this.value;
      if(this.value!=''){
        var xhr = new XMLHttpRequest();
        xhr.open("GET","/admin/api/avatar.php?username="+un+"");
        xhr.send();
        xhr.onreadystatechange=function(){
          if(this.readyState!==4) return;
          document.getElementById("img").src = this.responseText;
        }
      }
    }*/
    $(function($){
      var emailFormat = /^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/;
      $('#email').on('blur',function(){
        var value = $(this).val();
        if(!value || !emailFormat.test(value)) return
          $.get('/admin/api/avatar.php?username='+value+'',null,function(res){
            if(!res) return;
            $('#img').fadeOut(function(){
              $(this).on('load',function(){
                $(this).fadeIn();
              }).attr('src',res);
            });
          });
      });
    });
  </script>
</body>
</html>
