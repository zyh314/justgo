<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:92:"C:\AppServ\www\hf171029-stage4\hf1710-justgo\public/../application/index\view\travelpay.html";i:1526304517;}*/ ?>
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

<!--主体内容-->
<div id="vueApp">
	<div class="layui-container">
		<div class="layui-row layui-col-space1">
			<div class="layui-col-md4">
				<img v-bind:src="orderinfo.image" />
			</div>
			<div class="layui-col-5 layui-col-md-offset1">
				<p>{{orderinfo.name}}</p>
				<p>{{orderinfo.intro}}</p>
				<p>单价：￥
					<span class="forprice">{{orderinfo.price}}</span>
				</p>
				<p>
					<span>{{quantity}}</span>
				</p>
				<div style="display: flex;justify-content: space-between;">
					<span>收货人：</span>
					<span>{<?php echo $onlineUser['uname']; ?>}</span>
				</div>
			</div>
		</div>
		<div class="layui-row" style="display: flex;justify-content: space-between;">
			<span>购买数量</span>
			<div>
				<img src="http://p8int7f8g.bkt.clouddn.com/%E5%87%8F.png" />
				<input id="qty2cart" style="width: 52px; height: 25px; text-align: center;" value="1">
				<img src="http://p8int7f8g.bkt.clouddn.com/%E5%8A%A0.png" />
			</div>
		</div>
		<div class="layui-row" style="display: flex;justify-content: space-between;">
			<span>收货人：</span>
			<span></span>
		</div>
	
	</div>
</div>








</body>

<script>
    layui.use(['element','jquery','laytpl'], function(){
        var element = layui.element
        ,$ = layui.jquery
        ,laytpl = layui.laytpl;

        
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
	
	var app = new Vue({
	  el: '#vueApp',
	  data: {
	    orderinfo: [],
	    userinfo:[],
	    quantity:localStorage.buy_quantity
	  },
	  created:function(){
	  	$.ajax({
			type:"post",
			url:"<?php echo url('index/goods/travelpayinfo'); ?>",
			data:{"goodsid":localStorage.buy_goodsid},
			dataType:'json',
			success:function(res){
				console.log(res);
				this.orderinfo = res[0];
				this.userinfo = res[1];
			}.bind(this)
		});
	  }
	})
    

</script>

</html>