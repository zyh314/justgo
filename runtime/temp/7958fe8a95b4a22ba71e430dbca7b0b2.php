<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:66:"D:\WEB\PHP\justgo\public/../application/index\view\edit_money.html";i:1526269676;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="__CSS__/iframe.css">
    <link rel="stylesheet" type="text/css" href="__STATIC__/layui/css/layui.css">
	<style type="text/css">
	</style>
</head>
<body ng-app = 'adminApp' ng-controller = 'admin'>
<!-- <div class = 'iframeClose'>×</div> -->
<div>
  <span>余额：</span>
  <span><?php echo $umoney; ?></span>
</div>
<form class="layui-form"> <!-- 提示：如果你不想用form，你可以换成div等任何一个普通元素 -->
  <div class="layui-form-item">
    <label class="layui-form-label">充值金额</label>
    <div class="layui-input-block">
      <input type="number" name="money" placeholder="请输入" autocomplete="off" class="layui-input" lay-verify="required|opsw">
    </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="*" id = 'add_admin_sub'>充值</button>
    </div>
  </div>
  <!-- 更多表单结构排版请移步文档左侧【页面元素-表单】一项阅览 -->
</form>
</body>
<script src="__JS__/jquery-3.2.1.min.js"></script>
<script src="__JS__/vue.js"></script>
<script src="__JS__/md5.js"></script>
<script src="__STATIC__/layui/layui.all.js"></script>
<script type="text/javascript">

layui.use(['form', 'layedit', 'laydate'], function(){  
  var form = layui.form
  ,layer = layui.layer  
  ,layedit = layui.layedit  
  ,laydate = layui.laydate;  
  //自定义验证规则  
  form.verify({  
        money: function(value){   
          if(Number(value) != value){
            return '请输入数字'
          }else if(value < 0){
            return '输入错误'
          }
        }
  });  
    
  //创建一个编辑器  
  layedit.build('LAY_demo_editor');  
    
  //监听提交  
  form.on('change(*)', function(data){  
    layer.alert(JSON.stringify(data.field), {  
      title: '最终的提交信息'  
    })  
    return false;  
  });  

   form.on("submit(*)" , function(data){
    $.ajax({
      url:'<?php echo url("index/User/editUserMoney"); ?>',
      dataType:'json',
      type:'POST',
      data:'money='+data.field.money,
      success:function(res){
        window.location.reload();
      }
    }) 
  })
   
});  

// document.getElementsByClassName('iframeClose')[0].onclick = function(){
// 	window.parent.document.getElementById("add_admin_iframe").style.display="none";
// }
</script>
</html>