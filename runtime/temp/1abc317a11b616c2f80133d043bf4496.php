<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:95:"C:\AppServ\www\hf171029-stage4\hf1710-justgo\public/../application/index\view\travelorders.html";i:1526229426;}*/ ?>
	<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">  <!--向下兼容IE8以下，让IE8以下的浏览器最好的适应bootstrap的各个组件-->
    	<meta name="viewport" content="width=device-width, initial-scale=1"> <!--手机端打开网页，就会被【禁止缩放】,原生APP的体验就是无法进行放大缩小的，所以要禁用-->
		<title>我的订单-bootstrap</title>
		<link href="__CSS__/bootstrap.min.css" rel="stylesheet">
		<style>
			@media only screen and (min-width: 1200px) {
				.logoImg{
					height: 50px;
				}
			}
		</style>
	</head>
	<body>
		<!--导航条-->
		<nav class="navbar navbar-inverse">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myQuestionnaires">
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#" style="padding: 0;">
						<img src="https://www.wjx.cn/images/newimg/index/mobieindexnew.png" class="img-responsive logoImg"/>
					</a>
				</div>
				<div class="collapse navbar-collapse navbar-right" id="myQuestionnaires">
					 <ul class="nav navbar-nav">
					 	<li>
					 		<a>
					 			<span class="glyphicon glyphicon-home"></span>
					 			<span>我的问卷</span>
					 		</a>
					 	</li>
					 	<li class="dropdown">
					 		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					 			<span class="glyphicon glyphicon-user"></span>
					 			<span>189XXXXXXXX</span>
					 			<span class="caret"></span>
					 		</a>
					 		<ul class="dropdown-menu">
					 			<li><a href="#">用户信息</a></li>
					 			<li><a href="#">升级</a></li>
					 			<li><a href="#">客服中心</a></li>
					 		</ul>
					 	</li>
					 	<li>
					 		<a>
					 			<span class="glyphicon glyphicon-bell"></span>
					 			<span>消息</span>
					 			<span class="badge">3</span>
					 		</a>
					 	</li>
					 	<li>
					 		<a>
					 			<span class="glyphicon glyphicon-log-out"></span>
					 			<span>退出</span>
					 		</a>
					 	</li>
					 </ul>
				</div>
			</div>
		</nav>
		
		
		<!--分隔线-->
		<hr />
		
		<!--栅格系统-->
		<div class="container">
			<div class="row">
				<ul id="myTab" class="nav nav-tabs">
					<li class="active">
						<a href="#all" data-toggle="tab">
							全部
						</a>
					</li>
					<li>
						<a href="#pending" data-toggle="tab">待支付</a>
					</li>
					<li>
						<a href="#paid" data-toggle="tab">待收货</a>
					</li>
				</ul>
				<div id="myTabContent" class="tab-content">
					<div class="tab-pane fade in active" id="all">
						<p>菜鸟教程是一个提供最新的web技术站点，本站免费提供了建站相关的技术文档，帮助广大web技术爱好者快速入门并建立自己的网站。菜鸟先飞早入行——学的不仅是技术，更是梦想。</p>
					</div>
					<div class="tab-pane fade" id="pending">
						<p>iOS 是一个由苹果公司开发和发布的手机操作系统。最初是于 2007 年首次发布 iPhone、iPod Touch 和 Apple TV。iOS 派生自 OS X，它们共享 Darwin 基础。OS X 操作系统是用在苹果电脑上，iOS 是苹果的移动版本。</p>
					</div>
					<div class="tab-pane fade" id="paid">
						<p>iOS 是一个由苹果公司开发和发布的手机操作系统。最初是于 2007 年首次发布 iPhone、iPod Touch 和 Apple TV。iOS 派生自 OS X，它们共享 Darwin 基础。OS X 操作系统是用在苹果电脑上，iOS 是苹果的移动版本。</p>
					</div>
				</div>
			</div>
		</div>
		
	</body>
	<script type='text/javascript' src='__JS__/jquery.js'></script>
	<script type='text/javascript' src='__JS__/vue.js'></script>
	<script type='text/javascript' src='__JS__/test.js'></script>
	<script type='text/javascript' src='__JS__/bootstrap.min.js'></script>
	<script>
		var App = new Vue({
			el:'#App'
		})
	</script>
</html>
