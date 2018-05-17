<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:94:"C:\AppServ\www\hf171029-stage4\hf1710-justgo\public/../application/backend\view\goodsedit.html";i:1526284696;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="stylesheet" href="__STATIC__/layui/css/layui.css" media="all">
	</head>
	<body>
		<form class="layui-form" action="">
			<div class="layui-form-item">
				<label class="layui-form-label"></label>
				<div class="layui-input-block">
					<input type="hidden" name="goodsid" value="<?php echo $thedetails['goodsid']; ?>" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">商品名称</label>
				<div class="layui-input-block">
					<input type="text" name="title" value="<?php echo $thedetails['name']; ?>" required lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">价格</label>
					<div class="layui-input-inline">
						<input type="tel" name="price" value="<?php echo $thedetails['price']; ?>" lay-verify="required|number|decimal" autocomplete="off" class="layui-input">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">数量</label>
					<div class="layui-input-inline">
						<input type="text" name="quantity" lay-verify="required|number|positiveint" autocomplete="off" value="<?php echo $thedetails['quantity']; ?>"  class="layui-input">
					</div>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">归属地</label>
				<div class="layui-input-inline">
					<select id="province" name="province" lay-filter="province" lay-verify="required">
						<option value="" selected="">请选择省</option>
						<?php foreach($location as $value): ?>
						<option value="<?php echo $value['locateid']; ?>"><?php echo $value['locate']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="layui-input-inline">
					<select id="cities" name="city" lay-verify="required">
						<option value="" selected="">请选择市</option>
					</select>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">促销方式</label>
				<div class="layui-input-block">
					<input  lay-filter="salesway" id="secKill" type="radio" name="saleway" value="秒杀" title="秒杀">
					<input  lay-filter="salesway" id="normal" type="radio" name="saleway" value="普购" title="普购"  checked>
				</div>
			</div>
			
			<div style="display: block;" id="salediv">
				<!--促销价/限量-->
				<div class="layui-form-item">
					<div class="layui-inline">
						<label class="layui-form-label">促销价：</label>
						<div class="layui-input-inline">
							<input id="saleprice" value="<?php echo $thedetails['saleprice']; ?>" type="tel" name="saleprice" autocomplete="off" class="layui-input">
						</div>
					</div>
					<div class="layui-inline">
						<label class="layui-form-label">每单限量：</label>
						<div class="layui-input-inline">
							<input type="text" id="qtylimit" value="<?php echo $thedetails['salelimit']; ?>" name="limit" autocomplete="off" class="layui-input">
						</div>
					</div>
				</div>
			
				<!--时段选择-->
				<div class="layui-form-item">
					<div class="layui-inline">
						<label class="layui-form-label">促销时段</label>
						<div class="layui-input-inline">
							<select id="period" name="period" lay-search="" value="<?php echo $thedetails['salePeriod']; ?>">
								<option value="">点击选择任意字段</option>
								<option value="8">08：00 - 10：00</option>
								<option value="10">10：00 - 12：00</option>
								<option value="12">12：00 - 14：00</option>
								<option value="14">14：00 - 16：00</option>
								<option value="16">16：00 - 18：00</option>
								<option value="18">18：00 - 20：00</option>
								<option value="20">20：00 - 22：00</option>
								<option value="22">22：00 - 24：00</option>
								<option value="24">24：00 - 02：00</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			
			<div class="layui-form-item layui-form-text">
				<label class="layui-form-label">商品简介</label>
				<div class="layui-input-block">
					<textarea name="intro" placeholder="请输入内容" class="layui-textarea"><?php echo $thedetails['intro']; ?></textarea>
				</div>
			</div>
			<div class="layui-form-item">
				<div class="layui-input-block">
					<button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
					<!--<button type="reset" class="layui-btn layui-btn-primary">重置</button>-->
				</div>
			</div>
		</form>
	</body>
	<script src="__STATIC__/layui/layui.js" charset="utf-8"></script>
	<script>
		//Demo
		layui.use(['form','jquery'], function() {
			var form = layui.form
			,layer = layui.layer
			,$ = layui.jquery;
			
			layer.ready(function(){
				$.ajax({
					type:"post",
					url:"<?php echo url('backend/goods/foredit'); ?>",
					data:{'goodsid':"<?php echo $thedetails['goodsid']; ?>"},
					dataType:'json',
					success:function(res){
						if(res.saleType=='秒杀'){
							$('#normal').removeAttr('checked');
							$("#secKill").attr('checked',"checked");
							$('#salediv').css('display','block');
							$('#saleprice').attr("lay-verify","required|number|decimal");
							$('#qtylimit').attr("lay-verify","required|number|positiveint");
							$('#period').attr("lay-verify","required");
						}else{
							$('#secKill').removeAttr('checked');
							$("#normal").attr('checked',"checked");
							$('#salediv').css('display','none');
							$('#saleprice').attr("lay-verify","");
							$('#qtylimit').attr("lay-verify","");
							$('#period').attr("lay-verify","");
						}
						$('#period').val(res.salePeriod);
						$('#province').val(res.fid);
						localStorage.city = res.locateid;
						form.render('select');
						
						$.ajax({
							type:"post",
							url:"<?php echo url('backend/goods/getcities'); ?>",
							data:{'fid':res.fid},
							dataType:'json',
							success:function(data){
								$("#cities option:not(:first)").empty();
								for(var i=0; i<data.length; i++){
									$('#cities').append($('<option value='+data[i].locateid+'>'+data[i].locate+'</option>'))
								}
								$('#cities').val(localStorage.city);
								form.render();
							}
						})
					}
				})
			})
			
			//省份切换显示不同城市
			form.on('select(province)', function(data){
				console.log(data.value); //得到被选中的值
				$.ajax({
				  	type:"post",
				  	url:"../goods/getcities",
				  	data:{fid:data.value},
				  	dataType: "json", 
			  		success: function(data){ 
			  			$("#cities option:not(:first)").empty();
						for(var i=0; i<data.length; i++){
							$('#cities').append($('<option value='+data[i].locateid+'>'+data[i].locate+'</option>'))
						}
						form.render('select');
			  		} 
				});
			}); 
			
			//自定义验证规则
		  	form.verify({
		    content: function(value){
		      layedit.sync(editIndex);
		    }
		    ,decimal:[
		    	/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/
		    	,'金额输入格式不正确,请确认!'
		    ]
		    ,positiveint:[
		    	/^[+]{0,1}(\d+)$/
		    	,'数量格式不正确，请重输！'
		    ]
		  });
				
			/*监听单选框*/
			form.on('radio(salesway)', function(data){
				console.log(data);
				if(data.value=="秒杀"){
					$('#salediv').css('display','block');
					$('#saleprice').attr("lay-verify","required|number|decimal");
					$('#qtylimit').attr("lay-verify","required|number|positiveint");
					$('#period').attr("lay-verify","required");
				}else{
					$('#salediv').css('display','none');
					$('#saleprice').attr("lay-verify","");
					$('#qtylimit').attr("lay-verify","");
					$('#period').attr("lay-verify","");
				}
			});
			
			//监听提交
			form.on('submit(formDemo)', function(data) {
				/*layer.msg(JSON.stringify(data.field));*/
				$.ajax({
					type:"post",
					url:"<?php echo url('backend/goods/editcomplete'); ?>",
					data:data.field,
					dataType:'json',
					success:function(data){
						if(data.code==203){ 
		    				var index = parent.layer.getFrameIndex(window.name);
		    				parent.layer.close(index);
		    				parent.layer.msg(data.message, {icon: 6});
		    			}else{ 
		    				layer.msg(data.message, {icon: 5});
		    			}
					}
				});
				return false;
			});
		});
	</script>
</html>
