<?php 
require_once '../config.php';
require_once '../functions.php';

bx_get_current_user();

if(isset($_GET['id'])){
  $id = $_GET['id'];
  $categories_one = bx_fetch_one("select * from tb_booktypeinfo where BookTypeId={$id};");
}

function add_category(){
  if(empty($_POST['name'])){
    $GLOBALS['message'] = '请输入名称';
    return;
  }
  if(empty($_POST['slug'])){
    $GLOBALS['message'] = '请输入别名';
    return;
  }
  
  $category_name = $_POST['name'];
  $category_slug = $_POST['slug'];

  $row = bx_execute("insert into tb_booktypeinfo values (null,'{$category_name}','{$category_slug}');");

    $GLOBALS['message'] = $row<=0? '添加失败':'添加成功';
    $GLOBALS['success'] = $row>0;
}

function add_bianji(){ 
  global $categories_one;
  $category_name = empty($_POST['name'])?$categories_one['name']:$_POST['name'];
  $category_slug = empty($_POST['slug'])?$categories_one['slug']:$_POST['slug'];
  $categories_one['name'] = $category_name;
  $categories_one['slug'] = $category_slug;
  $id = $_GET['id'];
  $row = bx_execute("update tb_booktypeinfo set BookTypeSlug = '{$category_slug}' , BookTypeName = '{$category_name}'
    where BookTypeId = '{$id}';");
  $GLOBALS['message'] = $row<=0? '添加失败':'添加成功';
  $GLOBALS['success'] = $row>0;
  header('Location:categories.php');
}

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(empty($_GET['id'])){
      add_category();
    }else{
      add_bianji();
    }
  }




$categories = bx_fetch_all("select * from tb_booktypeinfo");
 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
        <h1>分类目录</h1>
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
          <?php if(isset($_GET['id'])): ?>
          <form action="<?php echo $_SERVER['PHP_SELF'].'?id='.$categories_one['BookTypeId']; ?>" method="post" autocomplete=off>
            <h2>编辑</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称"
              value="<?php echo $categories_one['BookTypeName']; ?>">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug"
              value="<?php echo $categories_one['BookTypeSlug']; ?>">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">添加</button>
            </div>
          </form>
          <?php else: ?>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" autocomplete=off>
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
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
            <a id = "btn_delete" class="btn btn-danger btn-sm" href="categories-delete.php" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($categories as $item): ?>
                <tr>
                  <td class="text-center"><input type="checkbox" data-id="<?php echo $item['id'];?>"></td>
                  <td><?php echo $item['BookTypeName'] ?></td>
                  <td><?php echo $item['BookTypeSlug'] ?></td>
                  <td class="text-center">
                    <a href="categories.php?id=<?php echo $item['BookTypeId']; ?>" class="btn btn-info btn-xs">编辑</a>
                    <a href="categories-delete.php?id=<?php echo $item['BookTypeId']; ?>" class="btn btn-danger btn-xs">删除</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php $name = 'categories'; ?>
  <?php include 'inc/aside.php';  ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script type="text/javascript">
    $(function($){
      var input = $('table input');
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
