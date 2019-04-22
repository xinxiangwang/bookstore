<?php 
require_once '../functions.php';
$current_user = bx_get_current_user();
 ?>
   <div class="aside">
    <div class="profile">
      <img class="avatar" src="<?php echo isset($target)?$target:$current_user['avatar'];?>">
      <h3 class="name"><?php echo $current_user['nickname']; ?></h3>
    </div>
    <ul class="nav">
      <li<?php echo $name === 'index' ? ' class="active"' : '' ?>>
        <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <?php $menu_posts = array('posts','post-add','categories'); ?>
      <li <?php echo in_array($name,$menu_posts)?'class="active"':'';?>>
        <a href="#menu-posts" <?php echo in_array($name,$menu_posts)?'':'class="collapsed"';?> data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse <?php echo in_array($name,$menu_posts)?'in':'';?>">
          <li <?php echo $name == 'post-add'? "class='active'":'';?>><a href="post-add.php">添加图书</a></li>
          <li <?php echo $name == 'categories'? "class='active'":'';?>><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li class="<?php echo $name == 'comments' ? 'active' : '' ?>">
        <a href="comments.php"><i class="fa fa-comments"></i>图书列表</a>
      </li>
      <li class="<?php echo $name == 'users' ? 'active' : '' ?>">
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
    </ul>
  </div>
  ?>