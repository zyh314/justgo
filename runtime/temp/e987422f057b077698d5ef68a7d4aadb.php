<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:96:"C:\AppServ\www\hf171029-stage4\hf1710-justgo\public/../application/index\view\travelconfirm.html";i:1526546176;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>支付页面</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="__STATIC__/layui/css/layui.css">
    <link rel="stylesheet" type="text/css" href="__CSS__/public.css">
    <link rel="stylesheet" type="text/css" href="__CSS__/travelmall.css">
    <script src="__STATIC__/layui/layui.js"></script>
    <script src="__JS__/vue.js"></script>
    <script type="text/javascript" src = '__JS__/jquery-3.2.1.min.js'></script>
</head>

<body>

</br>

<!--导航开始-->
<div class="layui-layout layui-layout-admin">
	<div class="layui-header">
		<div class="layui-logo layui-layout-left">
			<a href="#" class="nav_logo"></a>
		</div>
		<ul class="layui-nav layui-layout-left" lay-filter="demo">
			<li class="layui-nav-item">
				<a href="#">首页</a>
			</li>
			<li class="layui-nav-item ">
				<a href="#">目的地</a>
			</li>
			<li class="layui-nav-item layui-this">
				<a href="#">旅行商城<span class="layui-badge-dot"></span></a>
			</li>
			<li class="layui-nav-item">
				<a href="javascript:;">社区</a>
				<dl class="layui-nav-child">
					<!-- 二级菜单 -->
					<dd>
						<a href="#">结伴</a>
					</dd>
					<dd>
						<a href="#">游记</a>
					</dd>
				</dl>
			</li>
		</ul>
		<ul class="layui-nav layui-layout-right" id="nav_user" lay-filter="nav_user">
			<li class="layui-nav-item">
				<a href="javascript:;">
					<img src="http://t.cn/RCzsdCq" class="layui-nav-img"> 贤心
				</a>
				<dl class="layui-nav-child">
					<dd>
						<a href="">基本资料</a>
					</dd>
					<dd>
						<a href="">安全设置</a>
					</dd>
				</dl>
			</li>
			<li class="layui-nav-item">
				<a href="#" id="loginOut">注销</a>
			</li>
		</ul>
	</div>
</div>
<!--导航结束-->


<!--主体内容-->
<div id="vueApp">
	<div class="layui-container">
		<div class="layui-row">
			<div class="layui-row goodsname" style="margin-top:30px">
				<span>确认收货信息：</span>
				<span style="float:right">用户名：{{onlineUser.uname}}</span>
			</div>
			<hr class="layui-bg-gray">
			<div class="layui-row bothEnds" style="padding:20px; border-color:#f40; background-color:#fff0e8;">
				<div>
					<img src="http://p8int7f8g.bkt.clouddn.com/%E5%AE%9A%E4%BD%8D.png" />
					<span>发送到</span>
				</div>
				<div>
					<input type="radio" name="receiptWay" checked="">
					<span>Tel：{{onlineUser.uphoneNo}}</span>
				</div>
				<div>
					<input type="radio" name="receiptWay">
					<span>Email：{{onlineUser.uemail}}</span>
				</div>
			</div>
		</div>
		
		<div class="layui-row goodsname" style="margin-top:30px;">
			确认订单信息
		</div>
		
		<div class="layui-row spaceAround">
			<span>商品信息</span>
			<span>单价</span>
			<span>数量</span>
			<span>优惠金额</span>
			<span>小计</span>
		</div>
		<hr class="layui-bg-blue">
		
		<div class="layui-row layui-col-space1" v-for = 'x in goodsArr'>
			<div class="layui-row layui-col-md4 layui-col-space1">
				<div class="layui-col-md4">
					<img style="width: 120px;" v-bind:src="(x.image)" />
				</div>
				<div class="layui-col-md2 layui-elip">
					{{x.name}}
				</div>
			</div>
			
			<div class="layui-row layui-col-md8 layui-col-space2">
				<div class="layui-col-md2">
					<p v-if="(x.saleType=='普购')">￥{{x.price}}</p>
					<p v-if="(x.saleType=='秒杀')">￥{{x.saleprice}}</p>
				</div>
				<div class="layui-col-md2">
					<img src="http://p8int7f8g.bkt.clouddn.com/%E5%87%8F.png" style="height: 20px;"/>
					<input name="confirmqty" lay-verify="required|number|positiveint" style="width: 52px; height: 25px; text-align: center;" v-model="x.quantity" @>
					<img src="http://p8int7f8g.bkt.clouddn.com/%E5%8A%A0.png" style="height: 20px;" />
				</div>
				<div class="layui-col-md1 layui-col-md-offset2">
					<p v-if="(x.saleType=='普购')">无</p>
					<p v-if="x.saleType=='秒杀'">省{{(x.price-x.saleprice)*x.quantity}}元</p>
				</div>
				<div class="layui-col-md2 layui-col-md-offset1">
					<p v-if="(x.saleType=='普购')">￥{{x.price*x.quantity}}</p>
					<p v-if="(x.saleType=='秒杀')">￥{{x.saleprice*x.quantity}}</p>
				</div>
			</div>
		</div>
		<br />
		<hr class="layui-bg-orange">
		<div class="layui-row" style="margin: 30px;">
			<div class="layui-col-md7">
				<span>给卖家留言:</span>
				<input v-model="ordernote" style="width:350px;height: 45px;" type="text" placeholder="选填：填写内容已和卖家协商确认" />
			</div>
			<div style="float: right;">
				<p>实付款：￥<span style="color: red;font-size: 24px;font-weight: bold;">{{totalprice}}</span></p>
			</div>
		</div>
		</div>
		<div class="layui-row" style="margin: 0px 50px 30px 0; float: right;">
			<button v-on:click='placeOrder' class="layui-btn layui-btn-lg layui-btn-danger">提交订单</button>
		</div>

</div>


</body>

<script>
    layui.use(['element','jquery','laytpl','layer'], function(){
        var element = layui.element
        ,$ = layui.jquery
        ,laytpl = layui.laytpl
        ,layer = layui.layer;

        
        element.on('nav(demo)', function(elem){
            console.log(elem); //得到当前点击的DOM对象
        });
        element.on('navDelete(nav_user)',function (elem) {
            console.log(elem);
        });
        
        
        var app = new Vue({
		el: '#vueApp',
		data: {
		    onlineUser:[],
		    goodsArr:[],
		    totalprice:0,
		    ordernote:''
		},
		methods:{
			/*下单*/
		  	placeOrder:function(){
		  		var loadpop = layer.load(2, {time: 3*1000});
		  		$.ajax({
		  			type:"post",
		  			url:"<?php echo url('index/goods/placeorder'); ?>",
		  			data:{goodsArr:JSON.stringify(this.goodsArr),ordernote:this.ordernote},
		  			dataType:'json',
		  			success:function(res){
		  				console.log(res.data)
		  				if(res.code=='211'){
		  					layer.close(loadpop); //关闭加载层
		  					/*付款提示*/
		  					var paypop = layer.confirm("下单成功！！！",{title: "付款提示",btn: ['立即付款','取消']}, function(index){
		  						layer.close(paypop);
		  						/*输密码提示*/
				            	layer.prompt({title: '请输入密码',}, function(value, index, elem){
									$.post("pay", {pendingorders:JSON.stringify(res.data[0]),totalprice:res.data[1],password:value}, 
									function (data){
										console.log(data);
										/*查看提示*/
					                    layer.confirm('付款成功', { 
					                    	icon: 1
					                        ,title: "查看提示"  
					                        ,btn: ['立即查看','继续购物']
					                        ,closeBtn: 0
					                        ,yes:function(index, layero){
					  							location.href="<?php echo url('index/goods/usercenter'); ?>"
					  							layer.close(index);
					  						}
					  						,cancel: function(){ 
			   									location.href="<?php echo url('index/goods/travelmall'); ?>"
					  							layer.close(index);
			  								}
					                    });
					               	});  
									layer.close(index);
								});
				        	});   
		  				}else{
		  					layer.alert('下单失败', {icon: 2}); 
		  				}
		  			}.bind(this)
		  		});
		  	}
		},
		
		created:function(){
	  		$.ajax({
				type:"get",
				url:"<?php echo url('index/goods/payorderinfo'); ?>",
				dataType:'json',
				success:function(res){
					/*console.log(res.onlineUser);
					console.log(res.goodsArr);*/
					this.onlineUser = res.onlineUser;
					this.goodsArr = res.goodsArr;
					for(var i=0; i<res.goodsArr.length; i++)
					{
						if(res.goodsArr[i]['saleType']=='普购'){
							this.totalprice+=parseInt(res.goodsArr[i]['price'])*parseInt(res.goodsArr[i]['quantity']);
							
						}else{
							this.totalprice+=parseInt(res.goodsArr[i]['saleprice'])*parseInt(res.goodsArr[i]['quantity']);
						}
					}
				}.bind(this)
			});
		}
	})
        
        
        
        
        
        
        
        
        
        
    });
	
	


</script>

</html>