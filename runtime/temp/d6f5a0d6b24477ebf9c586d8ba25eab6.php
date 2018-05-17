<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:97:"C:\AppServ\www\hf171029-stage4\hf1710-justgo\public/../application/backend\view\goodsdetails.html";i:1525766161;}*/ ?>
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
	<?php if(is_array($thedetails) || $thedetails instanceof \think\Collection || $thedetails instanceof \think\Paginator): $key = 0; $__LIST__ = $thedetails;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value0): $mod = ($key % 2 );++$key;?>
	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">商品id</h3>
		    <p>
		      <?php echo $value0['goodsid']; ?>
		    </p>
    	</div>
  	</li>
  	
  	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">商品图片</h3>
		    <div>
		      <img style="height: 90px;" src="<?php echo $value0['image']; ?>" />
		    </div>
    	</div>
  	</li>
  	
  	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">商品名称</h3>
		    <p>
		      <?php echo $value0['name']; ?>
		    </p>
    	</div>
  	</li>
	
	
	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">商品余量</h3>
		    <p>
		      <?php echo $value0['quantity']; ?>
		    </p>
    	</div>
  	</li>
	
	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">商品价格</h3>
		    <p>
		      <?php echo $value0['price']; ?>
		    </p>
    	</div>
  	</li>
	
	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">所属城市</h3>
		    <p>
		      <?php echo $value0['locate']; ?>
		    </p>
    	</div>
  	</li>
	
	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">促销方式</h3>
		    <p>
		      <?php echo $value0['saleType']; ?>
		    </p>
    	</div>
  	</li>
	
	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">发布时间</h3>
		    <p>
		      <?php echo $value0['cpubtime']; ?>
		    </p>
    	</div>
  	</li>
	
	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">上架时间</h3>
		    <p>
		      <?php echo $value0['cshelftime']; ?>
		    </p>
    	</div>
  	</li>
  
  	<?php if($value0['saleType']!='普购'): ?>
  	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">秒杀时段</h3>
		    <p>
		      <?php echo $value0['salePeriod']; ?>
		    </p>
    	</div>
  	</li>
	
	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">促销价</h3>
		    <p>
		      <?php echo $value0['saleprice']; ?>
		    </p>
    	</div>
  	</li>
	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">限购数量</h3>
		    <p>
		      <?php echo $value0['salelimit']; ?>
		    </p>
    	</div>
  	</li>
  	<?php endif; ?>
	
	
	<li class="layui-timeline-item">
    	<i class="layui-icon layui-timeline-axis"></i>
    	<div class="layui-timeline-content layui-text">
      		<h3 class="layui-timeline-title">简单介绍</h3>
		    <p>
		      <?php echo $value0['intro']; ?>
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