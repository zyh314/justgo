<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:101:"C:\AppServ\www\hf171029-stage4\hf1710-justgo\public/../application/index\view\travelmall_replica.html";i:1526023658;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">  <!--向下兼容IE8以下，让IE8以下的浏览器最好的适应bootstrap的各个组件-->
    	<meta name="viewport" content="width=device-width, initial-scale=1"> <!--手机端打开网页，就会被【禁止缩放】,原生APP的体验就是无法进行放大缩小的，所以要禁用-->
		<title>JustGoTravel</title>
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
		<nav class="navbar navbar-default">
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
					 			<span>旅行商城</span>
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
					 		<a href="<?php echo url('index/index/quit'); ?>">
					 			<span class="glyphicon glyphicon-log-out"></span>
					 			<span>退出</span>
					 		</a>
					 	</li>
					 </ul>
				</div>
			</div>
		</nav>
		
		<!--警告条-->
		<!--<div class="alert alert-warning text-center">
			重要提醒：请，<span class="badge" style="background-color: deepskyblue;">绑定微信账号</span> 绑定后可通过微信管理问卷、获得新答卷提醒以及找回密码！
		</div>-->
		
		<!--主体内容-->
		<div class="container">
			<!--小标签-->
			<div class="row">
				<ul>
					<li class="divider-vertical" href="">丽江</li>
					<li class="divider-vertical" href="">兰州</li>
					<li class="divider-vertical" href="">成都</li>
					<li class="divider-vertical" href="">秒杀ing</li>
					<li class="divider-vertical" href="">热门活动</li>
					<li class="divider-vertical" href="">高赞游记</li>
				</ul>
			</div>
			
			<!--搜索框-->
			<div class="row input-group" style="margin: 30px;">
				<input type="text" class="form-control" placeholder="输入景点名或者目标城市">
				<span class="input-group-btn" id="sizing-addon1">
			        <button class="btn btn-default" type="button">
			        	<span class="glyphicon glyphicon-search"></span>
			        	搜索
			        </button>
			    </span>
			</div>
		</div>
		
	</div>
		
	</body>
	<script type='text/javascript' src='__JS__/jquery.js'></script>
	<script type='text/javascript' src='__JS__/bootstrap.min.js'></script>
	<script type='text/javascript' src='__JS__/vue.js'></script>
	<script>
		function search(){
			location.href="<?php echo url('index/index/search'); ?>?key="+$('#searchKey').val();
//			$.ajax({
//				type:"post",
//				url:"<?php echo url('index/index/search'); ?>",
//				data:{'key':$('#searchKey').val()},
//				dataType:'json',
//				success:function(res){
//					console.log(res);
//				}
//			});
		}
	</script>
</html>
