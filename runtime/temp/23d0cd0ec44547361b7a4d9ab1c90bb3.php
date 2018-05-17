<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:94:"C:\AppServ\www\hf171029-stage4\hf1710-justgo\public/../application/index\view\travelgoods.html";i:1526221827;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>商品列表</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="__STATIC__/layui/css/layui.css">
    <link rel="stylesheet" type="text/css" href="__CSS__/public.css">
    <link rel="stylesheet" type="text/css" href="__CSS__/travelmall.css">
    <script src="__STATIC__/layui/layui.js"></script>
    <script type="text/javascript" src = '__JS__/jquery-3.2.1.min.js'></script>
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
            <li class="layui-nav-item layui-this"><a href="#">旅行商城<span class="layui-badge-dot"></span></a></li>
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
                <a href="javascript:;">
                    <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                    贤心
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="">基本资料</a></dd>
                    <dd><a href="">安全设置</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="#" id="loginOut">注销</a></li>
        </ul>
    </div>
</div>
<!--导航结束-->

<!--主体内容-->
<div class="layui-container">
	
	<!--搜索框-->
	<div class="layui-row becenter" style="margin: 30px;">
		<div class="layui-inline">
			<input style="width: 600px;" placeholder="输入景点名或目标城市" class="layui-input" >
		</div>
		<button placeholder="输入景点名或者目标城市" id="search" class="layui-btn layui-btn-warm" data-type="reload">
			<i class="layui-icon layui-icon-search"></i>搜索
		</button>
	</div>
	
	<!--小导航-->
	<div class="layui-row" style="margin: 10px;">
		<span class="layui-breadcrumb">
		  <a href="<?php echo url('index/index/index'); ?>">首页</a>
		  <a href="<?php echo url('index/goods/travelmall'); ?>">旅行商城</a>
		   <a><cite>商品选择</cite></a>
		</span>
	</div>
	<hr class="layui-bg-blue">
	
	<!--商品-->
	<div class="layui-row layui-col-space2">
		<div class="layui-col-md7">
			<!--商品内容-->
			<div class="layui-tab">
				<ul class="layui-tab-title">
					<li class="layui-this">综合排序</li>
					<li>销量优先</li>
				</ul>
				<div class="layui-tab-content">
					<!--<div class="layui-tab-item layui-show">内容1</div>
						<div class="layui-tab-item">内容2</div>-->
					<?php foreach($travelgoods as $value): ?>
					<div style="margin: 30px;" class="layui-row layui-col-space2">
						<div class="layui-col-md5">
							<a href="traveldetails?goodsid=<?php echo $value['goodsid']; ?>">
								<img style="width:225px" src="<?php echo $value['image']; ?>" />
							</a>
						</div>
						<div class="layui-col-md7">
							<a href="traveldetails?goodsid=<?php echo $value['goodsid']; ?>">
								<p class="grayminis">已售<?php echo $value['soldqty']; ?></p>
								<p class="goodsname"><?php echo $value['name']; ?></p>
								<p style="margin: 8px 0;font-size: 12px;line-height: 24px;max-height: 48px;overflow: hidden;"><?php echo $value['intro']; ?></p>
								<span class="forprice">￥<?php echo $value['price']; ?></span>
							</a>
							<button style="float: right;" class="layui-btn layui-btn-primary">立即购买</button>
						</div>
					</div>
					<?php endforeach; ?>
					<br />
					<?php echo $page; ?>
				</div>
			</div>
		</div>
		<div class="layui-col-md3 layui-col-md-offset2">
			<p style="margin: 15px; font-size: 16px;">本周热卖</p>
			<?php foreach($bestSold as $val): ?>
			<div style="margin: 5px;" class="layui-row layui-col-space2">
				<div class="layui-col-md6">
					<img style="width: 120px;" src="<?php echo $val['image']; ?>" />
				</div>
				<div class="layui-col-md4">
					<p><?php echo $val['name']; ?></p>
					<p>￥<?php echo $val['price']; ?></p>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	
	
</div>


<!--页脚-->
<div id="footer">
    <div class="ft_content">
        <div class="ft_info">
            <dl class="ft-info-col ft-info-intro">
                <dt>全球旅游消费指南 </dt>
                <dd>覆盖全国百来个省市和地区</dd>
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

<script>
    layui.use(['element'], function(){
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

    

</script>

</html>