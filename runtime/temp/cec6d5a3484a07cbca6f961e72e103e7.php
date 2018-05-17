<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:94:"C:\AppServ\www\hf171029-stage4\hf1710-justgo\public/../application/index\view\user_center.html";i:1526350318;}*/ ?>
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
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo layui-layout-left">
            <a href="#" class="nav_logo"></a>
        </div>
        <ul class="layui-nav layui-layout-left"  lay-filter="demo">
            <li class="layui-nav-item"><a href="#">首页</a></li>
            <li class="layui-nav-item "><a href="#">目的地</a></li>
            <li class="layui-nav-item"><a href="#">旅行商城<span class="layui-badge-dot"></span></a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">社区</a>
                <dl class="layui-nav-child"> <!-- 二级菜单 -->
                    <dd><a href="#">结伴</a></dd>
                    <dd><a href="#">游记</a></dd>
                </dl>
            </li>
        </ul>
        <ul class="layui-nav layui-layout-right" id="nav_user"  lay-filter="nav_user">
            <li class="layui-nav-item">
                <?php if($username == "请登录"): ?>
                <a href="#" id="login">
                    <img src="<?php echo $userHead; ?>" class="layui-nav-img">
                    请登录
                </a>
                <?php endif; if($username != "请登录"): ?>
                <a href = "<?php echo url('index/index/user_center'); ?>" target="ifr">
                    <img src="<?php echo $userHead; ?>" class="layui-nav-img"><?php echo $username; ?>
                </a>
                <?php endif; ?>
            <!--     <dl class="layui-nav-child">
                    <dd><a href="">基本资料</a></dd>
                    <dd><a href="">安全设置</a></dd>
                </dl> -->
            </li>
            <li class="layui-nav-item">
                <?php if($userBtn0 == "注销"): ?>
                <a href="<?php echo url('index/index/loginOut'); ?>" id="loginOut">注销</a>
                <?php endif; if($userBtn0 == "注册"): ?>
                <a href="#" id="register">注册</a>
                <?php endif; ?>
            </li>
        </ul>
    </div>
  <div class="layui-side layui-bg-black" id="user_menu">
    <div class="layui-side-scroll">
	    <ul class="layui-nav layui-nav-tree"  lay-filter="test">
<?php if(is_array($user_menu) || $user_menu instanceof \think\Collection || $user_menu instanceof \think\Paginator): $i = 0; $__LIST__ = $user_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['pfid'] == 0): ?>
	<li class="layui-nav-item layui-nav-itemed">
		<a class="" href="javascript:;"><?php echo $vo['pname']; ?></a>
		<dl class="layui-nav-child">
			<?php if(is_array($user_menu) || $user_menu instanceof \think\Collection || $user_menu instanceof \think\Paginator): $i = 0; $__LIST__ = $user_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;if($vo1['pfid'] == $vo['pid']): ?>
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
     


