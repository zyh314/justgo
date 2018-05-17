<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:89:"C:\AppServ\www\hf171029-stage4\hf1710-justgo\public/../application/backend\view\paid.html";i:1526284964;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>layui</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="__STATIC__/layui/css/layui.css"  media="all">
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>
	<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	  <legend>已支付订单</legend>
	</fieldset>
	
	 
	<div class="layui-tab layui-tab-card">
	  <ul class="layui-tab-title">
	    <li>全部订单（完成付款）</li>
	    <li class="layui-this">已付款订单（待发货）</li>
	  </ul>
	  <div class="layui-tab-content" style="height: 100px;">
	    <!--全部订单-->
	    <div class="layui-tab-item">
	    	<table class="layui-table" lay-data="{width: 'full', height:'full', url:'../goods/getallpaid', page:true, id:'allpaid'}" lay-filter="demo">
	    		<thead>
	    			<tr>
	    				<th lay-data="{type:'checkbox', fixed: 'left'}"></th>
	    				<th lay-data="{field:'orderid', width:80, sort: true, fixed: true}">订单ID</th>
	    				<th lay-data="{field:'uname', width:80}">用户名</th>
	    				<th lay-data="{field:'image', width:120, templet:'#goodsImage'}">图片</th>
	    				<th lay-data="{field:'name', width:100}">景点名</th>
	    				<th lay-data="{field:'price', width:80}">单价</th>
	    				<th lay-data="{field:'orderqty', width:100, sort: true}">购买数量</th>
	    				<th lay-data="{field:'orderprice', width:80, sort: true}">总价</th>
	    				<th lay-data="{field:'osname', width:90}">订单状态</th>
	    				<th lay-data="{field:'ordernote', width:120}">订单备注</th>
	    				<th lay-data="{fixed: 'right', width:178, align:'center', toolbar: '#barDemo'}"></th>
	    			</tr>
	    		</thead>
	    	</table>
	    </div>
	    
	    	
	    <!--已付款订单-->
	    <div class="layui-tab-item  layui-show">
	    	<div class="layui-btn-group demoTable">
	    		<button class="layui-btn" data-type="getCheckData">批量关闭交易</button>
	    	</div>
	    	<table class="layui-table" lay-data="{width: 'full', height:'full', url:'../goods/getpaid', page:true, id:'idTest'}" lay-filter="demo">
	    		<thead>
	    			<tr>
	    				<th lay-data="{type:'checkbox', fixed: 'left'}"></th>
	    				<th lay-data="{field:'orderid', width:80, sort: true, fixed: true}">订单ID</th>
	    				<th lay-data="{field:'uname', width:80}">用户名</th>
	    				<th lay-data="{field:'image', width:120, templet:'#goodsImage'}">图片</th>
	    				<th lay-data="{field:'name', width:100}">景点名</th>
	    				<th lay-data="{field:'price', width:80}">单价</th>
	    				<th lay-data="{field:'orderqty', width:100, sort: true}">购买数量</th>
	    				<th lay-data="{field:'orderprice', width:80, sort: true}">总价</th>
	    				<th lay-data="{field:'osname', width:90, fixed: 'right'}">订单状态</th>
	    				<th lay-data="{field:'ordernote', width:120}">订单备注</th>
	    				<th lay-data="{fixed: 'right', width:178, align:'center', toolbar: '#barDemo'}"></th>
	    			</tr>
	    		</thead>
	    	</table>
	    </div>
	  </div>
	</div>
	
	<script type="text/html" id="goodsImage">
		<div>
			<img src="{{d.image}}" />
		</div>
	</script>
	
 
	<script type="text/html" id="barDemo">
	  <!--<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看</a>-->
		{{#  if(d.osname === '已付款'){ }}
		<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="sendgoods">发货</a>
		<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">取消交易</a>
		{{#  } else if(d.osname === '已发货') { }}
		<span>等待确认收货</span>
		{{#  } else if(d.osname === '交易成功') { }}
		<a class="layui-btn layui-btn-danger layui-btn-xs layui-disabled" lay-event="role_power">删除</a>
		{{#  } }}
	</script>          
          
<script src="__STATIC__/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
layui.use(['table','element'], function(){
  var table = layui.table
  ,$ = layui.jquery
  ,element = layui.element;
  //监听表格复选框选择
  table.on('checkbox(demo)', function(obj){});
  
  //监听工具条
  table.on('tool(demo)', function(obj){
    var data = obj.data;
    if(obj.event === 'detail'){} 
    else if(obj.event === 'del'){
      layer.confirm('真的要取消这笔交易吗？', function(index){
        $.ajax({ 
	    		url: "../goods/ordercancel", 
	    		type: "POST", 
	    		data:{"orderid":data.orderid},
	    		dataType: "json", 
	    		success: function(data){ 
	    			console.log(data);
	    			if(data.code==209){ 
	    				layer.msg(data.message, {icon: 6});
	    				location.reload();
	    			}else{ 
	    				layer.msg(data.message, {icon: 5}); 
	    			}
	    		}
      	});
      });
    }
    else if(obj.event === 'sendgoods'){
    	$.ajax({ 
	    		url: "../goods/sendgoods", 
	    		type: "POST", 
	    		data:{"orderid":data.orderid},
	    		dataType: "json", 
	    		success: function(data){ 
	    			console.log(data);
	    			if(data.code==208){ 
	    				layer.msg(data.message, {icon: 6});
	    				location.reload();
	    			}else{ 
	    				layer.msg(data.message, {icon: 5}); 
	    			}
	    		}
      	});
    }
  });
  
  var $ = layui.$, active = {
    getCheckData: function(){ //获取选中数据
    	var checkStatus = table.checkStatus('idTest')
    	,data = checkStatus.data;
    	console.log(data);
    	if(data.length>0){
    		layer.confirm('是否确认取消选中交易？', function(index){
		        $.ajax({ 
		    		url: "../goods/plentyclose", 
		    		type: "POST", 
		    		data:{"data":JSON.stringify(data)},
		    		dataType: "json", 
		    		success: function(data){ 
		    			console.log(data);
		    			if(data.code==209){ 
		    				layer.msg(data.message, {icon: 6});
		    				location.reload();
		    			}else{ 
		    				layer.msg(data.message, {icon: 5}); 
		    			}
		    		} 
		    	});
		        layer.close(index);
		    });
			
      	}else{
      		layer.alert('请至少选择一项');
      	}
    }
  };
  
  $('.demoTable .layui-btn').on('click', function(){
    var type = $(this).data('type');
    active[type] ? active[type].call(this) : '';
  });
});
</script>

</body>
</html>