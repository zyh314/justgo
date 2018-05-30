<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:63:"D:\WEB\PHP\JustGo0\public/../application/backend\view\user.html";i:1526439335;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="__CSS__/iframe.css">
    <link rel="stylesheet" type="text/css" href="__STATIC__/layui/css/layui.css">
    <style type="text/css">
        .page_btn{
            margin:5px;
            float: left;
            padding: 10px;
            border: 1px solid #555;
            border-radius: 3px;
            cursor: pointer;
        }
        .img-box{  
            padding-bottom:100%;  
        }  
        .img-box img{  
            position:absolute;  
            top:0;  
            bottom:0;  
            left:0;  
            right:0;  
            height:100%;  
            margin:auto;  
        }  
    </style>
</head>
<body>
<div id = 'app'>
<div>
<div class = 'nav'>当前位置：/系统管理/用户管理</div>
<div class = 'btn_line_box'>
    <div class="layui-btn" id = 'add_user'>添加用户</div>
</div>

<div id = 'user_table' lay-filter = 'user_table0'>
</div>
</div>
</body>
<script src="__JS__/jquery-3.2.1.min.js"></script>
<script src="__STATIC__/layui/layui.js"></script>
<!-- <script type="text/javascript" src = '__JS__/vue.js'></script> -->
<script type="text" id = 'img'>
    <div class="img-box">  
        <img src="{{d.uIcon}}"/>  
    </div>
</script>
<script type="text/javascript">



//iframe窗



layui.use(['layer','table','form'], function(){ 
    var layer = layui.layer;
    var table = layui.table; 
    var form = layui.form; 

    form.on('radio(sex)',function(data){
        console.log(data);
        layer.editUserInfo(data.elem.name,'ugender',data.value)
    })
    form.on('checkbox(lock)',function(data){
        console.log(data);
        if(data.value == '使用'){
            layer.editUserInfo(data.elem.name,'locking','锁定')
        }else{
            layer.editUserInfo(data.elem.name,'locking','使用')
        }
        layer.tableRender();
    })
    layer.tableRender = function(){
        table.render({
            elem: '#user_table'
            ,page:true
            ,url:"../user/getUser"
            ,cols: [[{field:'uname',title:'用户账号',edit:'text'}
                ,{field:'nickname',title:'用户昵称',edit:'text'}
                ,{field:'uphoneNo',title:'用户电话',edit:'text'}
                ,{field:'uemail',title:'用户邮箱',edit:'text'}
                ,{field:'uintegral',title:'用户积分',edit:'text'}
                ,{title:'用户性别',toolbar:'#sex',width:130}
                ,{field:'uIcon',title:'用户头像',templet:'#img'}
                ,{field:'umoney',title:'用户余额',edit:'text'}
                // ,{field:'hsid',title:'使用/锁定',edit:'text'}
                ,{field:'uregisterTime',title:'注册时间'}
                ,{fixed:'right',title:'操作',toolbar:'#tableBar'}
            ]] 
        });
    } 
    layer.tableRender();
  //触发事件
  //
  //
    //监听工具条
    table.on('tool(user_table0)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
        var data = obj.data; //获得当前行数据
        var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
        var tr = obj.tr; //获得当前行 tr 的DOM对象

        if(layEvent === 'edit_user_power'){ //查看
            localStorage.edit_user_power_userid=data.rid;

            layui.use(['layer','table'], function(){ 
            var layer = layui.layer;
                layer.open({
                    type: 2,
                    title: '修改权限',
                    shadeClose: true,
                    shade: 0.8,
                    area: ['380px', '90%'],
                    content: '../user/edit_user_power' //iframe的url
                });
              //触发事件
            });
        }
        else if(layEvent === 'Lock')
        {
            if(data.hsid == 1){
                layer.lockUser(data,2);
            }else{
                layer.lockUser(data,1);
            }
            
        } else if(layEvent === 'edit'){ //编辑
            //do something

            //同步更新缓存对应的值
            obj.update({
              username: '123'
              ,title: 'xxx'
            });
        }
    });
    //更新数据
    layer.editUserInfo = function(id,key,value){
        $.ajax({
            url:'<?php echo url("backend/User/editUserInfo"); ?>',
            dataType:'json',
            type:'POST',
            data:'userid='+id+'&key='+key+'&value='+value,
            success:function(res){
                console.log(res);
                if(res == false){
                    layer.msg('编辑失败');
                    layer.tableRender();
                }
            }
        }) ; 

    }
    table.on('edit(user_table0)', function(obj){ //注：edit是固定事件名，test是table原始容器的属性 lay-filter="对应的值"
        console.log(obj.value); //得到修改后的值
        console.log(obj.field); //当前编辑的字段名
        console.log(obj.data); //所在行的所有相关数据
        //用户名验证 
        if(obj.field == 'uname'){
            $.ajax({
                url:'<?php echo url("backend/User/userNameSame"); ?>',
                dataType:'json',
                type:'POST',
                data:'uname='+obj.value,
                success:function(res){
                    if(res == 'true'){
                        layer.msg('用户名重名');
                        layer.tableRender()
                        return;
                    }else{
                        layer.editUserInfo(obj.data.userid,obj.field,obj.value)
                    }
                }
            }) ;
            //手机验证
        }else if(obj.field == 'uphoneNo'){
            if(Number(obj.value) != obj.value){
                layer.msg('电话必须为纯数字');
                layer.tableRender();
            }else{
                layer.editUserInfo(obj.data.userid,obj.field,obj.value);
            }
            //积分验证
        }else if(obj.field == 'uintegral'){
            if(Number(obj.value) != obj.value){
                layer.msg('积分必须为纯数字');
                layer.tableRender();
            }else if(obj.value<0){
                layer.msg('积分必须为正数');
                layer.tableRender();
            }else{
                layer.editUserInfo(obj.data.userid,obj.field,obj.value);
            }
            //余额验证
        }else if(obj.field == 'umoney'){
            if(Number(obj.value) != obj.value){
                layer.msg('余额必须为纯数字');
                layer.tableRender();
            }else if(obj.value<0){
                layer.msg('余额必须为正数');
                layer.tableRender();
            }else{
                layer.editUserInfo(obj.data.userid,obj.field,obj.value);
            }
            //邮箱验证
        }else if(obj.field == 'uemail'){
            var regEmail = /^[a-z0-9._%-]+@([a-z0-9-]+\.)+[a-z]{2,4}$|^1[3|4|5|7|8]\d{9}$/;
            //输出 true
            var ans = regEmail.test(obj.value);
            if(ans == false){
                layer.msg('邮箱格式错误');
                layer.tableRender();
            }else{
                layer.editUserInfo(obj.data.userid,obj.field,obj.value);
            }
        }else{
            layer.editUserInfo(obj.data.userid,obj.field,obj.value);

        }
    });


    layer.lockUser = function(data,index){
        console.log(data.rid);

        $.ajax({
            url:'<?php echo url("backend/User/lockUser"); ?>',
            dataType:'json',
            type:'POST',
            data:'id='+data.uid+'&index='+index,
            success:function(res){
                // window.location.reload();
                // console.log(res);
                table.render();
            }.bind(this)
        }) ;
        table.reload('user_table', {
          url: '../User/getuser'
        });
    }
  
    
});
document.getElementById('add_user').onclick = function(){
    layui.use(['layer','table'], function(){ 
    var layer = layui.layer;
        layer.open({
            type: 2,
            title: '添加用户',
            shadeClose: true,
            shade: 0.8,
            area: ['380px', '90%'],
            content: '../index/register' //iframe的url
        });
      //触发事件
    });
}

</script>

<script type="text/html" id="tableBar">
  <!-- <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="Lock">锁定/解锁</a> -->
  <!-- <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="edit_user_power">修改权限</a> -->
  <input type="checkbox" name="{{d.userid}}" value="{{d.locking}}" title="锁定" lay-filter="lock"  {{ d.locking == '锁定' ? 'checked' : '' }}>
</script>
<script type="text/html" id="sex">
    <!-- <div class="layui-input-block"> -->
      <input type="radio" name="{{d.userid}}" value="男" title="男" value="{{d.ugender}}" lay-filter="sex" {{ d.ugender == '男' ? 'checked' : '' }}>
      <input type="radio" name="{{d.userid}}" value="女" title="女" value="{{d.ugender}}" lay-filter="sex" {{ d.ugender == '女' ? 'checked' : '' }}>
    <!-- </div> -->
</script>

</html>


