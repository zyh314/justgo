<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:61:"D:\WEB\PHP\justgo\public/../application/index\view\login.html";i:1526288308;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>注册</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="__STATIC__/layui/css/layui.css">
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
<style type="text/css">
#code img{
  width: 140px;
  height: 38px;
  float: right;
}
</style>
</head>
<body>
              
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
  <legend>登录</legend>
</fieldset>
 
<form class="layui-form" action="">
  <div class="layui-form-item">
    <label class="layui-form-label">用户名</label>
    <div class="layui-input-block">
      <input type="text" name="uname" lay-verify="required" autocomplete="off" placeholder="用户名" value = 'a123' class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">密码</label>
    <div class="layui-input-block">
      <input type="password" name="upassword" lay-verify="required" autocomplete="off" placeholder="密码" value = '000000' class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">验证码</label>
    <div class="layui-input-block">
      <input type="text" name="code" lay-verify="required" autocomplete="off" placeholder="验证码" class="layui-input">
      <div id = 'code'><?php echo captcha_img(); ?></div>
    </div>
  </div>
  
  
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit="" lay-filter="demo1" type="button">登录</button>
      <!-- <button id = 'register' class="layui-btn layui-btn-primary">注册</button> -->
    </div>
  </div>
</form>
 
          
<script src="__JS__/jquery-3.2.1.min.js"></script>
<script src="__STATIC__/layui/layui.js"></script>
<script src="__JS__/md5.js"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
layui.use(['form', 'layedit', 'laydate'], function(){
  var form = layui.form
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
  
  //日期
  laydate.render({
    elem: '#date'
  });
  laydate.render({
    elem: '#date1'
  });
  
  //创建一个编辑器
  var editIndex = layedit.build('LAY_demo_editor');
 
  //自定义验证规则
  form.verify({
    title: function(value){
      if(value.length < 5){
        return '标题至少得5个字符啊';
      }
    }
    ,pass: [/(.+){6,12}$/, '密码必须6到12位']
    ,content: function(value){
      layedit.sync(editIndex);
    }
  });
  
  //监听指定开关
  form.on('switch(switchTest)', function(data){
    layer.msg('开关checked：'+ (this.checked ? 'true' : 'false'), {
      offset: '6px'
    });
    layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)
  });
  
  //监听提交
  form.on('submit(demo1)', function(data){
    console.log(data.field)
    data.field.upassword = hex_md5(data.field.upassword);
    $.ajax({
      url:'<?php echo url("index/index/loginChk"); ?>',
      dataType:'json',
      type:'POST',
      data:data.field,
      success:function(res){
        if(res == 'true'){
          window.parent.location.reload();
        }else{
          alert('登录失败')
        }
      }
    })
  });

  
});


//注册
// document.getElementById('register').onclick = function(){
//   window.location.reload();
//     layui.use(['layer','table'], function(){ 
//     var layer = layui.layer;
//         layer.open({
//             type: 2,
//             title: '注册',
//             shadeClose: true,
//             shade: 0.8,
//             area: ['380px', '90%'],
//             content: '../index/register' //iframe的url
//         });
//       //触发事件
//     });
// }
</script>

</body>
</html>