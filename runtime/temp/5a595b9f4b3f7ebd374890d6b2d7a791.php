<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:64:"D:\WEB\PHP\JustGo0\public/../application/backend\view\index.html";i:1526232934;}*/ ?>
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
    <div class="layui-logo">说走就走后台管理</div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
<!--     <ul class="layui-nav layui-layout-left">
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
    </ul> -->
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <?php echo $username; ?>
        </a>
<!--         <dl class="layui-nav-child">
          <dd><a href="">基本资料</a></dd>
          <dd><a href="">安全设置</a></dd>
        </dl> -->
      </li>
      <li class="layui-nav-item"><a href="<?php echo url('backend/index/loginOut'); ?>">溜了</a></li>
    </ul>
  </div>
  
  <div class="layui-side layui-bg-black" id="menu">
    <div class="layui-side-scroll">
	    <ul class="layui-nav layui-nav-tree"  lay-filter="test">
<?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['pfid'] == 0): ?>
	<li class="layui-nav-item layui-nav-itemed">
		<a class="" href="javascript:;"><?php echo $vo['pname']; ?></a>
		<dl class="layui-nav-child">
			<?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;if($vo1['pfid'] == $vo['pid']): ?>
			    	<dd><a href = '<?php echo $vo1['purl']; ?>' target="ifr"><?php echo $vo1['pname']; ?></a></dd>
			    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</dl>
	</li>
	<?php endif; endforeach; endif; else: echo "" ;endif; ?>


		</ul>
    </div>
  </div>
  
			
  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
    	<iframe id = 'frm1' name = 'ifr' src = "<?php echo url('backend/index/travels'); ?>"></iframe>
    </div>
  </div>
  
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    <!-- © layui.com - 底部固定区域 -->
  </div>
</div>
</div>
<script src="__STATIC__/layui/layui.js"></script>
<!-- <script src="__JS__/jquery.js"></script> -->
<script type="text/javascript" src = '__JS__/vue.js'></script>
<script type="text/javascript" src = '__JS__/jquery-3.2.1.min.js'></script>
<!-- <script src="https://unpkg.com/vue-router/dist/vue-router.js"></script> -->
<script>
//JavaScript代码区域
layui.use('element', function(){
	var element = layui.element;
});

</script>
</body>
</html>
     