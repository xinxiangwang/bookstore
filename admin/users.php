<?php 
require_once '../config.php';
require_once '../functions.php';

bx_get_current_user();
if(isset($_GET['id'])){
  $user_one = bx_fetch_one('select * from users where id = '.$_GET['id'].';');
}
function update_user(){
  $GLOBALS['success'] =false;
  global $user_one;
  if(empty($_POST['email'])){
    $GLOBALS['message'] = '请输入邮箱';
    return;
  }
  if(empty($_POST['slug'])){
    $GLOBALS['message'] = '请输入别名';
    return;
  }
  if(empty($_POST['nickname'])){
    $GLOBALS['message'] = '请输入昵称';
    return;
  }
  if(empty($_POST['password'])){
    $GLOBALS['message'] = '请输入密码';
    return;
  }
  
  $user_nickname = $_POST['nickname'];
  $user_slug = $_POST['slug'];
  $user_email = $_POST['email'];
  $user_password = $_POST['password'];
  $user_one['nickname'] = $user_nickname;
  $user_one['slug'] = $user_slug;
  $user_one['email'] = $user_email;
  $user_one['password'] = $user_password;
  $id = $_GET['id'];

  $row = bx_execute("update users set nickname = '{$user_nickname}',slug = '{$user_slug}',email = '{$user_email}',password = '{$user_password}' where id = {$id};");

    $GLOBALS['message'] = $row<=0? '添加失败':'添加成功';
    $GLOBALS['success'] = $row>0;
}
function add_user(){
  $GLOBALS['success'] =false;
  if(empty($_POST['email'])){
    $GLOBALS['message'] = '请输入邮箱';
    return;
  }
  if(empty($_POST['slug'])){
    $GLOBALS['message'] = '请输入别名';
    return;
  }
  if(empty($_POST['nickname'])){
    $GLOBALS['message'] = '请输入昵称';
    return;
  }
  if(empty($_POST['password'])){
    $GLOBALS['message'] = '请输入密码';
    return;
  }
  
  
  $user_nickname = $_POST['nickname'];
  $user_slug = $_POST['slug'];
  $user_email = $_POST['email'];
  $user_password = $_POST['password'];

  $row = bx_execute("insert into users(id,slug,email,password,nickname,status) values (null,'{$user_slug}','{$user_email}','{$user_password}','{$user_nickname}','activated');");

    $GLOBALS['message'] = $row<=0? '添加失败':'添加成功';
    $GLOBALS['success'] = $row>0;
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if(empty($_GET['id'])){
    add_user();
  }else{
    update_user(); 
  }
}
$users = bx_fetch_all("select * from users;");
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Users &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
  <?php include 'inc/navbar.php' ?> 
    <div class="container-fluid">
      <div class="page-title">
        <h1>用户</h1>
      </div>
      <!-- 有错误信息时展示 -->
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
      <div class="row">
        <div class="col-md-4">
          <?php if(empty($_GET['id'])): ?>
          <form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = 'post'>
            <h2>添加新用户</h2>
            <div class="form-group">
              <label for="email">邮箱</label>
              <input id="email" class="form-control" name="email" type="email" placeholder="邮箱"
              value="<?php echo isset($user_one['email'])?$user_one['email']:''; ?>">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug"
              value="<?php echo isset($user_one['slug'])?$user_one['slug']:''; ?>">
              <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称" value="<?php echo isset($user_one['nickname'])?$user_one['nickname']:''; ?>">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" class="form-control" name="password" type="text" placeholder="密码" value="<?php echo isset($user_one['password'])?$user_one['password']:''; ?>">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">添加</button>
            </div>
          </form>
          <?php else: ?>
            <form action = "<?php echo $_SERVER['PHP_SELF'].'?id='.$_GET['id']; ?>" method = 'post'>
            <h2>编辑用户</h2>
            <div class="form-group">
              <label for="email">邮箱</label>
              <input id="email" class="form-control" name="email" type="email" placeholder="邮箱"
              value="<?php echo isset($user_one['email'])?$user_one['email']:''; ?>">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug"
              value="<?php echo isset($user_one['slug'])?$user_one['slug']:''; ?>">
              <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称" value="<?php echo isset($user_one['nickname'])?$user_one['nickname']:''; ?>">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" class="form-control" name="password" type="text" placeholder="密码" value="<?php echo isset($user_one['password'])?$user_one['password']:''; ?>">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">添加</button>
            </div>
          </form>
        <?php endif; ?>

        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a id="btn_delete" class="btn btn-danger btn-sm" href="users-delete.php" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                <th class="text-center" width="40"><input  type="checkbox"></th>
                <th class="text-center" width="80">头像</th>
                <th>邮箱</th>
                <th>别名</th>
                <th>昵称</th>
                <th>状态</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($users as $item ): ?>
              <tr>
                <td class="text-center"><input data-id="<?php echo $item['id']; ?>" type="checkbox"></td>
                <td class="text-center"><img class="avatar" src="<?php echo $item['avatar']; ?>"></td>
                <td><?php echo $item['email']; ?></td>
                <td><?php echo $item['slug']; ?></td>
                <td><?php echo $item['nickname']; ?></td>
                <td>激活</td>
                <td class="text-center">
                  <a href="users.php?id=<?php echo $item['id']; ?>" class="btn btn-default btn-xs">编辑</a>
                  <a href="users-delete.php?id=<?php echo $item['id']; ?>" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php $name = 'users'; ?>
  <?php include 'inc/aside.php';  ?>
  </div>
  
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
   <script type="text/javascript">
    $(function($){
      var input = $('tbody input');
      var btn_delete = $('#btn_delete');
      var checked = [];

      input.on('change',function(){
        if($(this).prop('checked')){
          checked.push($(this).prop('dataset')['id']);
        }else{
          checked.splice(checked.indexOf($(this).prop('dataset')['id']),1);
        }
        checked.length ? btn_delete.fadeIn() : btn_delete.fadeOut();
        //console.log(checked);
        btn_delete.prop('search','?id='+checked);
      });      
      /*input.on('change',function(){
        var flag = false;
        input.each(function(i,item){
          if($(item).prop('checked')){
            flag = true;
          }
        });
        flag ? btn_delete.fadeIn():btn_delete.fadeOut();
      });*/
    });
  </script>
</body>
</html>
