<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:94:"C:\AppServ\www\hf171029-stage4\hf1710-justgo\public/../application/backend\view\goodsInfo.html";i:1526003626;}*/ ?>
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
	  <legend>商品列表</legend>
	</fieldset>
	
	<div class="layui-btn-group demoTable">
		<button class="layui-btn" data-type="getCheckData">上下架</button>
	</div>
	
  <div class="layui-inline" style="float: right;">
    	<div class="demoTable">
    		搜索商品名或者城市名：
    		<div class="layui-inline">
    			<input class="layui-input" name="keyword" id="demoReload" autocomplete="off">
    		</div>
    		<button id="search" class="layui-btn" data-type="reload">搜索</button>
    	</div>
  </div>
 
	<!--<table class="layui-table" lay-data="{width: 'full', height:'full', url:'../goods/getgoods', page:true, id:'idTest'}" lay-filter="demo">
	  <thead>
	    <tr>
	      <th lay-data="{type:'checkbox', fixed: 'left'}"></th>
	      <th lay-data="{field:'goodsid', width:50, sort: true, fixed: true}">ID</th>
	      <th lay-data="{field:'image', width:80, templet:'#goodsImage'}">图片</th>
	      <th lay-data="{field:'name', width:120}">景点名</th>
	      <th lay-data="{field:'price', width:80, sort: true}">价格</th>
	      <th lay-data="{field:'locate', width:80}">城市</th>
	      <th lay-data="{field:'quantity', width:80, sort: true}">余量</th>
	      <th lay-data="{field:'goodstatus', width:120, sort: true}">商品状态</th>
	      <th lay-data="{field:'saleType', width:120, sort: true}">促销方式</th>
	      <th lay-data="{field:'cpubtime', width:175, sort: true}">发布时间</th>
	      <th lay-data="{fixed: 'right', width:178, align:'center', toolbar: '#barDemo'}"></th>
	    </tr>
	  </thead>
	</table>-->
	
	<table id="idTest" lay-filter="demo"></table>
 
<script type="text/html" id="barDemo">
  <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看</a>
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>

<script type="text/html" id="goodsImage">
	<div>
		<img src="{{d.image}}" />
	</div>
</script>
               
          
<script src="__STATIC__/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
layui.use(['table','jquery'], function(){
  var table = layui.table
  ,$ = layui.jquery;
  //执行渲染
	var tableIns = table.render({
	  elem: '#idTest' //指定原始表格元素选择器（推荐id选择器）
	  ,height: 'full' //容器高度
	  ,width:'full'
	  , url:'../goods/getgoods'
	  ,page: true
	  ,cols: [[
	  	{type:'checkbox', fixed: 'left'}
	  	,{field: 'goodsid', title: 'ID', width:50, sort: true, fixed: 'left'}
      ,{field: 'image', title: '主图', width:80, templet:'#goodsImage'}
      ,{field: 'name', title: '品名', width:120}
      ,{field: 'price', title: '价格', width:80, sort: true} 
      ,{field: 'locate', title: '城市', width: 80}
      ,{field: 'quantity', title: '余量', width: 80, sort: true}
      ,{field: 'goodstatus', title: '商品状态', width: 120, sort: true}
      ,{field: 'saleType', title: '促销方式', width: 120}
      ,{field: 'cpubtime', title: '发布时间', width: 175, sort: true}
      ,{fixed: 'right', width:178, align:'center', toolbar: '#barDemo'}
	  ]] //设置表头
	});
	
	$('#search').click(function(){
		tableIns.reload({
			where: { //设定异步数据接口的额外参数，任意设
		    keyword: $('#demoReload').val()
		  }
		  ,page: {
		    curr: 1 //重新从第 1 页开始
		  }
		})
	})
  
  //监听表格复选框选择
  table.on('checkbox(demo)', function(obj){
    console.log(obj)
  });
  //监听工具条
  table.on('tool(demo)', function(obj){
    var data = obj.data;
  	/*localStorage.goodsid = obj.data.goodsid;*/
    if(obj.event === 'detail'){
			layer.open({
				type: 2,
		    shift: 2,
		    area: ['300px', '500px'],
		    title: '商品详情',
		    content: '../goods/goodsdetails?goodsid='+(obj.data.goodsid),
			});
    }else if(obj.event === 'del'){
      layer.confirm('是否确认删除', function(index){
      	$.ajax({ 
      		url: "../goods/delete", 
      		type: "POST", 
      		data:{"id":data.goodsid},
      		dataType: "json", 
      		success: function(data){ 
      			console.log(data); 
      			if(data.code==201){ 
      				layer.msg(data.message, {icon: 6}); 
      			}else{ 
      				layer.msg(data.message, {icon: 5}); 
      			} 
      		} 
      	});
        obj.del();
        layer.close(index);
      });
    } else if(obj.event === 'edit'){
      layer.open({
				type: 2,
		    shift: 2,
		    area: ['800px', '500px'],
		    title: '商品详情',
		    content: '../goods/edit?goodsid='+(obj.data.goodsid),
		    success:function(data){
		    	
		    }
			});
    }
  });
  
  var $ = layui.$, active = {
    getCheckData: function(){ //获取选中数据
      	var checkStatus = table.checkStatus('idTest'),data = checkStatus.data;
      	if(data.length>0){
      		for(var i=0; i<data.length; i++){
      			if(data.goodstatus=='售罄'|| data.goodstatus=='过期'){
      				layer.msg('过期或售罄商品，不可执行此操作', {icon: 5});
      				break;
      			}
      		}
      		if(i==data.length){
      			$.ajax({ 
		    		url: "shelf", 
		    		type: "POST", 
		    		data:{"data":JSON.stringify(data)},
		    		dataType: "json", 
		    		success: function(data){ 
		    			console.log(data);
		    			if(data.code==202){ 
		    				location.reload(true);
		    				layer.msg(data.message, {icon: 6});
		    			}else{ 
		    				layer.msg(data.message, {icon: 5}); 
		    			} 
		    		} 
		    	});
      		}
    	   	
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