<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:88:"C:\AppServ\www\hf171029-stage4\hf1710-justgo\public/../application/index\view\first.html";i:1526350309;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>注册</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="__STATIC__/layui/css/layui.css">
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>
    <!-- 搜索框 -->
    <div class = 'search-box'>
        <form class="layui-form"> <!-- 提示：如果你不想用form，你可以换成div等任何一个普通元素 -->

          <div class="layui-form-item">
            <div class="layui-input-block">
              <input type="radio" name="search_type" value="游记" title="游记" checked="">
              <input type="radio" name="search_type" value="商品" title="商品">
            </div>
          </div>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <input type="text" name="ename" placeholder="请输入" autocomplete="off" class="layui-input" lay-verify="required|username">
            </div>
          </div>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button class="layui-btn" lay-submit lay-filter="*" id = 'add_admin_sub'>搜索</button>
            </div>
          </div>
          <!-- 更多表单结构排版请移步文档左侧【页面元素-表单】一项阅览 -->
        </form>
    </div>
    <!-- 热门游记 -->
    <div class="layui-carousel" id="travels" style="margin-top: 15px;">
        <div carousel-item="">
            <div>游记1</div>
            <div>游记2</div>
            <div>游记3</div>
            <div>游记4</div>
        </div>
    </div>
    <!-- 热门商品 -->
    <div class="layui-carousel" id="goods" style="margin-top: 15px;">
        <div carousel-item="">
            <div>商品1</div>
            <div>商品2</div>
            <div>商品3</div>
            <div>商品4</div>
        </div>
    </div>

          
<script src="__JS__/jquery-3.2.1.min.js"></script>
<script src="__STATIC__/layui/layui.js"></script>
<script src="__JS__/md5.js"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
layui.use('carousel', function(){
  var carousel = layui.carousel;
  //建造实例
  carousel.render({
    elem: '#travels'
    ,width: '100%' //设置容器宽度
    ,arrow: 'always' //始终显示箭头
    //,anim: 'updown' //切换动画方式
  });
  carousel.render({
    elem: '#goods'
    ,width: '100%' //设置容器宽度
    ,arrow: 'always' //始终显示箭头
    //,anim: 'updown' //切换动画方式
  });
});
      layui.use('element', function(){
        var element = layui.element;
        element.on('nav(demo)', function(elem){
            console.log(elem); //得到当前点击的DOM对象
        });
        element.on('navDelete(nav_user)',function (elem) {
            console.log(elem);
        });
    });

    $("#loginOut").click(function () {
        $("#nav_user").hide();
    });

    //轮播
    layui.use(['carousel', 'form'], function() {
        var carousel = layui.carousel
            , form = layui.form;

        carousel.render({
            elem: '#test2'
            ,interval: 1800
            ,anim: 'fade'
            ,height: '500px'
            ,width:'100%'
        });
    });

</script>

</body>
</html>