<<<<<<< HEAD
<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:62:"D:\WEB\PHP\JustGo0\public/../application/index\view\index.html";i:1526623845;}*/ ?>
=======
<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:62:"D:\WEB\PHP\JustGo0\public/../application/index\view\index.html";i:1526607259;}*/ ?>
>>>>>>> b08317171fb1fb13137c05c0657c13ee6b73d437
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>前台首页</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="__STATIC__/layui/css/layui.css">
    <link rel="stylesheet" type="text/css" href="__CSS__/public.css">
<style type="text/css">
#frm1{
    width: 99%;
    min-height: 100vh;
    border: 0;
}
</style>
</head>
<body>
<!--导航开始-->
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo layui-layout-left">
            <a href="#" class="nav_logo"></a>
        </div>
        <ul class="layui-nav layui-layout-left"  lay-filter="demo">
            <li class="layui-nav-item"><a href="#">首页</a></li>
            <li class="layui-nav-item "><a href="#">目的地</a></li>
            <li class="layui-nav-item"><a href="<?php echo url('index/goods/travelmall'); ?>">旅行商城<span class="layui-badge-dot"></span></a></li>
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
                <a id="login">
                    <img src="<?php echo $userHead; ?>" class="layui-nav-img">
                    请登录
                </a>
                <?php endif; if($username != "请登录"): ?>
                <a href = "<?php echo url('index/index/user_center'); ?>">
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
</div>
<!--导航结束-->
<div id="main">
    <iframe id = 'frm1' name = 'ifr' src = "<?php echo url('index/index/first'); ?>"></iframe>

</div>
<!--页脚-->
<div id="footer">
    <div class="ft_content">
        <div class="ft_info">
            <dl class="ft-info-col ft-info-intro">
                <dt>全球旅游消费指南 </dt>
                <dd>覆盖全球200多个国家和地区</dd>
                <dd><strong>100,000,000</strong> 位旅行者</dd>
                <dd><strong>920,000</strong> 家国际酒店</dd>
                <dd><strong>21,000,000</strong> 条真实点评</dd>
                <dd><strong>382,000,000</strong> 次攻略下载</dd>
                <dd><a class="highlight" href="http://www.mafengwo.cn/activity/sales_report2017/index" target="_blank">中国旅游行业第一部“玩法”</a></dd>
            </dl>
            <dl class="ft-info-col ft-info-about">
                <dt>关于我们</dt>
                <dd><a href="http://www.mafengwo.cn/s/about.html" rel="nofollow">关于马蜂窝</a></dd>
                <dd><a href="http://www.mafengwo.cn/s/property.html" rel="nofollow">网络信息侵权通知指引</a></dd>
                <dd><a href="http://www.mafengwo.cn/s/private.html" rel="nofollow">隐私政策</a><a href="http://www.mafengwo.cn/s/agreement.html" rel="nofollow" class="m_l_10">服务协议</a></dd>
                <dd><a href="http://www.mafengwo.cn/s/contact.html" rel="nofollow">联系我们</a></dd>
                <dd><a href="http://www.mafengwo.cn/s/sitemap.html" target="_blank">网站地图</a></dd>
                <dd><a class="joinus highlight" title="马蜂窝团队招聘" target="_blank" href="http://www.mafengwo.cn/s/hr.html" rel="nofollow">加入马蜂窝</a></dd>
            </dl>
            <dl class="ft-info-col ft-info-service">
                <dt>旅行服务</dt>
                <dd>
                    <ul class="clearfix">
                        <li><a target="_blank" href="http://www.mafengwo.cn/gonglve/">旅游攻略</a></li>
                        <li><a target="_blank" href="http://www.mafengwo.cn/hotel/">酒店预订</a></li>
                        <li><a target="_blank" href="http://www.mafengwo.cn/sales/">旅游特价</a></li>
                        <li><a target="_blank" href="http://zuche.mafengwo.cn/">国际租车</a></li>
                        <li><a target="_blank" href="http://www.mafengwo.cn/wenda/">旅游问答</a></li>
                        <li><a target="_blank" href="http://www.mafengwo.cn/insure/">旅游保险</a></li>
                        <li><a target="_blank" href="http://z.mafengwo.cn">旅游指南</a></li>
                        <li><a target="_blank" href="http://huoche.mafengwo.cn">订火车票</a></li>
                        <li><a target="_blank" href="http://www.mafengwo.cn/travel-news/">旅游资讯</a></li>
                        <li><a target="_blank" href="http://www.mafengwo.cn/app/intro/gonglve.php">APP下载</a></li>
                        <li style="width: 120px;"><a target="_blank" href="http://www.mafengwo.cn/sales/alliance.php" class="highlight">旅行商城全球商家入驻</a></li>
                    </ul>
                </dd>
            </dl>
        </div>
    </div>
</div>
<!--页脚结束-->
</body>
    <script src="__STATIC__/layui/layui.js"></script>
    <script type="text/javascript" src = '__JS__/jquery-3.2.1.min.js'></script>
<script>

//注册
document.getElementById('register').onclick = function(){
    layui.use(['layer','table'], function(){ 
    var layer = layui.layer;
        layer.open({
            type: 2,
            title: '注册',
            shadeClose: true,
            shade: 0.8,
            area: ['380px', '90%'],
            content: '../index/register' //iframe的url
        });
      //触发事件
    });
}
//登录
document.getElementById('login').onclick = function(){
    layui.use(['layer','table'], function(){ 
    var layer = layui.layer;
        layer.open({
            type: 2,
            title: '登录',
            shadeClose: true,
            shade: 0.8,
            area: ['380px', '90%'],
            content: "<?php echo url('index/index/login'); ?>" //iframe的url
            // content: 'index/index/login' //iframe的url
        });
      //触发事件
    });
}

</script>
</html>