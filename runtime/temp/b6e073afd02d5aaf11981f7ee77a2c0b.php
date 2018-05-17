<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"D:\WEB\PHP\justgo\public/../application/backend\view\index\index.html";i:1525441563;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>说走就走后台</title>
  <link rel="stylesheet" href="__STATIC__/layui/css/layui.css">
  <link rel="stylesheet" type="text/css" href="__CSS__/backend.css">
</head>
<body class="layui-layout-body">
<div id = 'backend'>
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo">说走就走</div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item"><a href="">控制台</a></li>
      <li class="layui-nav-item"><a href="">商品管理</a></li>
      <li class="layui-nav-item"><a href="">用户</a></li>
      <li class="layui-nav-item">
        <a href="javascript:;">其它系统</a>
        <dl class="layui-nav-child">
          <dd><a href="">邮件管理</a></dd>
          <dd><a href="">消息管理</a></dd>
          <dd><a href="">授权管理</a></dd>
        </dl>
      </li>
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
          超级码力
        </a>
        <dl class="layui-nav-child">
          <dd><a href="">基本资料</a></dd>
          <dd><a href="">安全设置</a></dd>
        </dl>
      </li>
      <li class="layui-nav-item"><a href="">溜了</a></li>
    </ul>
  </div>
  
  <div class="layui-side layui-bg-black" id="menu">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
<!-- 		<ul class="layui-nav layui-nav-tree"  lay-filter="test">
			<li class="layui-nav-item layui-nav-itemed">
			  <a class="" href="javascript:;">所有商品</a>
			  <dl class="layui-nav-child">
			    <dd><a href="javascript:;">列表一</a></dd>
			    <dd><a href="javascript:;">列表二</a></dd>
			    <dd><a href="javascript:;">列表三</a></dd>
			    <dd><a href="">超链接</a></dd>
			  </dl>
			</li>
			<li class="layui-nav-item">
			  <a href="javascript:;">解决方案</a>
			  <dl class="layui-nav-child">
			    <dd><a href="javascript:;">列表一</a></dd>
			    <dd><a href="javascript:;">列表二</a></dd>
			    <dd><a href="">超链接</a></dd>
			  </dl>
			</li>
			<li class="layui-nav-item"><a href="">云市场</a></li>
			<li class="layui-nav-item"><a href="">发布商品</a></li>
		</ul> -->
<!--       	<ul class="layui-nav layui-nav-tree"  lay-filter="test">
			<li class="layui-nav-item layui-nav-itemed" v-for="item in menuArr" v-if = 'item.pfid == 0'>
	      		<a class="" href="javascript:;">{{ item.pname }}</a>
	      		<dl class="layui-nav-child">
					<dd v-for="item1 in menuArr" v-if = 'item1.pfid == item.pid'>
						<a v-bind:id="item1.purl" onclick="chk()">{{ item1.pname }}</a>
					</dd>
	      		</dl>
	      	</li>
		</ul> -->
    </div>
  </div>
  
			
  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
    
<?php echo $menu; ?>
<!-- <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $key=>$vo): ?>
    <?php echo $vo['pid']; ?>:<?php echo $vo['pname']; endforeach; endif; else: echo "" ;endif; ?> -->
    	<!-- <iframe v-bind:src="iframeSrc" id = 'mainBody'></iframe> -->
    </div>
  </div>
  
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © layui.com - 底部固定区域
  </div>
</div>
</div>
<script src="__STATIC__/layui/layui.js"></script>
<!-- <script src="__JS__/jquery.js"></script> -->
<!-- <script type="text/javascript" src = '__JS__/vue.js'></script> -->
<script type="text/javascript" src = '__JS__/jquery-3.2.1.min.js'></script>
<!-- <script src="https://unpkg.com/vue-router/dist/vue-router.js"></script> -->
<script>
//JavaScript代码区域
layui.use('element', function(){
	var element = layui.element;
});
$.ajax({ 
	url: "<?php echo url('backend/Index/show_menu'); ?>", 
	type:"GET",
    success: function(data){
        // data = JSON.parse(data);
        console.log(data);
        // this.menuArr = data;
    },
    error: function(data){
        console.log("读取error!");
    }
});

</script>
</body>
</html>
     