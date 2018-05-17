<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:97:"C:\AppServ\www\hf171029-stage4\hf1710-justgo\public/../application/backend\view\orderdetails.html";i:1526276955;}*/ ?>
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
<ul class="layui-timeline">
	<?php if(is_array($orderdetails) || $orderdetails instanceof \think\Collection || $orderdetails instanceof \think\Paginator): $key = 0; $__LIST__ = $orderdetails;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value0): $mod = ($key % 2 );++$key;?>
		<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">订单id</h3>
		    <p>
		      <?php echo $value0['orderid']; ?>
		    </p>
    	</div>
  	</li>
  	
  	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">顾客id</h3>
		    <p>
		      <?php echo $value0['uid']; ?>
		    </p>
    	</div>
  	</li>
  	
  	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">订单内容</h3>
		    <p>
		      <?php echo $value0['name']; ?>
		    </p>
    	</div>
  	</li>
	
	
	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">订单数量</h3>
		    <p>
		      <?php echo $value0['orderqty']; ?>
		    </p>
    	</div>
  	</li>
	
	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">订单价格</h3>
		    <p>
		      <?php echo $value0['orderprice']; ?>
		    </p>
    	</div>
  	</li>
	
	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">订单状态</h3>
		    <p>
		      <?php echo $value0['osname']; ?>
		    </p>
    	</div>
  	</li>
	
	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">购买时间</h3>
		    <p>
		      <?php echo $value0['buytime']; ?>
		    </p>
    	</div>
  </li>

  	<?php endforeach; endif; else: echo "" ;endif; ?>
</ul>              
          
<script src="__STATIC__/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
	
</script>

</body>
</html>