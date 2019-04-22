<?php 
require_once '../functions.php';
bx_get_current_user();

 ?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
   <?php include 'inc/navbar.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
        <ul class="pagination pagination-sm pull-right">
          <!-- 分页数据 -->
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>类型</th>
            <th>书名</th>
            <th>出版社</th>
            <th>出版日期</th>
            <th>图书作者</th>
            <th>图书编号</th>
            <th>定价</th>
            <th>图书简介</th>
            <th>市场价</th>
            <th>成交量</th>
            <th>折扣</th>
            <th>图书封面图</th>
            <th>图书库存量</th>
            <th>封装方式</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
        <!-- 内容在下面渲染出来 -->                  
        </tbody>
      </table>
    </div>
  </div>
  <?php $name = 'comments';    ?>
  <?php include 'inc/aside.php';  ?>
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="/static/assets/vendors/jsrender/jsrender.js"></script>
  <script src="/static/assets/vendors/twbs-pagination/jquery.twbsPagination.js">></script>
  <script>NProgress.done()</script>
  <script id = "Tmpl" type="text/x-jsrender">
    {{for comments}}
        <tr>
          <td class="text-center"><input type="checkbox"></td>
          <td style="width:50px;">{{:BookTypeName}}</td>
          <td title="{{:BookName}}">{{toCut:BookName}}</td>
          <td>{{:BookPress}}</td>
          <td>{{:BookPubDate}}</td>
          <td>{{:BookAuthor}}</td>
          <td>{{:Bookisbn}}</td>
          <td>{{:BookPrice}}</td>
          <td title="{{:BookOutline}}">{{toCut:BookOutline}}</td>
          <td>{{:BookMprice}}</td>
          <td>{{:BookDealmount}}</td>
          <td>{{:BookDiscount}}</td>
          <td><img src="{{:BookPic}}" style="width:50px;height:50px" /></td>
          <td>{{:BookStoremount}}</td>
          <td>{{:BookPackstyle}}</td>
          <td style="width:50px;" class="text-center">{{:BookStatus}}</td>
          <td class="text-center" >
            <a href="javascript:;" class="btn btn-danger btn-xs delete" data-id="{{:BookId}}">删除</a>
          </td>
        <tr>
    {{/for}}
  </script>

  <script type="text/javascript">
    var current_page; 


   function loadPageData(page){
      $.get('/admin/api/comments.php',{page:page},function(res){
        if(page>res.total_pages){
          loadPageData(res.total_pages);
          return;
        }
        $('.pagination').twbsPagination('destroy');
        //分页功能
        $('.pagination').twbsPagination({
          startPage:page,
          totalPages:res.total_pages,
          visiblePages:7,
          initiateStartPageClick:false,
          first:'首页',
          last:'尾页',
          prev:'上一页',
          next:'下一页',
          onPageClick:function(e,page){
            loadPageData(page);
           }
        });
        //获取jsrender数据
        //对书名长度进行截取 超出部分用省略号代替
        $.views.converters({
          "toCut":function(name){
            if(name){
              return name = name.length > 10 ? name.substring(0,10)+'...' : name;
            }
            return name;
          }
        });
        var html = $('#Tmpl').render({comments:res.comments});
        $('tbody').html(html);
          current_page = page;
      });
    }


    loadPageData(1);


    $(document).ajaxStart(function(){
      NProgress.start();
    }).ajaxStop(function(){
      NProgress.done();
    })


    $('tbody').on('click','.delete',function(){
      var tr = $(this).parent().parent();
      var id = $(this).data('id');
      console.log(id);
      $.get('/admin/api/comments-delete.php',{ id : id },function(res){
        console.log(res);
        if(res){
          loadPageData(current_page);
        }
      })
    });


  </script>
</body>
</html>
