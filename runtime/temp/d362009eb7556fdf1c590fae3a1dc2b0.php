<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:63:"D:\WEB\PHP\JustGo0\public/../application/backend\view\role.html";i:1526352060;}*/ ?>
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
    </style>
</head>
<body>
<div id = 'app'>
<div>
<div class = 'nav'>当前位置：/系统管理/角色管理</div>
<div class = 'btn_line_box'>
    <div class="layui-btn" id = 'add_role' href = "<?php echo url('backend/User/add_role'); ?>" target="ifr">添加</div>
</div>

<div id = 'role_table' lay-filter = 'role_table0'>
</div>
</div>
</body>
<script src="__JS__/jquery-3.2.1.min.js"></script>
<script src="__STATIC__/layui/layui.js"></script>
<!-- <script type="text/javascript" src = '__JS__/vue.js'></script> -->
<script type="text/javascript">



//iframe窗



layui.use(['layer','table'], function(){ 
    var layer = layui.layer;
    var table = layui.table; 
    table.render({
        elem: '#role_table'
        ,page:true
        ,url:"../user/getRole"
        ,cols: [[{field:'roleid',title:'角色ID'}
            ,{field:'rname',title:'角色名称',edit:'text'}
            ,{field:'rintro',title:'角色简介',edit:'text'}
            ,{fixed:'right',title:'操作',toolbar:'#tableBar'}
        ]] 
    }); 
  //触发事件
  //
  //
    //监听工具条
    table.on('tool(role_table0)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
        var data = obj.data; //获得当前行数据
        var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
        var tr = obj.tr; //获得当前行 tr 的DOM对象

        if(layEvent === 'edit_role_power'){ //查看
            localStorage.edit_role_power_roleid=data.roleid;

            layui.use(['layer','table'], function(){ 
            var layer = layui.layer;
                layer.open({
                    type: 2,
                    title: '修改权限',
                    shadeClose: true,
                    shade: 0.8,
                    area: ['380px', '90%'],
                    content: '../user/edit_role_power' //iframe的url
                });
              //触发事件
            });

            // $.ajax({
            //     url:'<?php echo url("backend/User/edit_role_power"); ?>',
            //     dataType:'json',
            //     type:'GET',
            //     success:function(res){
            //         console.log(res);
            //     }.bind(this)
            // }) ;
        }
        else if(layEvent === 'del')
        { //删除
            layer.confirm('真的删除行么', function(index){
                obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                // console.log(index);
                if(index == 1){
                    layer.roleDel(data);
                    // window.location.reload();
                }
                layer.close(index);
                
                // table.render();
                //向服务端发送删除指令
            });
        } else if(layEvent === 'edit'){ //编辑
            //do something

            //同步更新缓存对应的值
            obj.update({
              username: '123'
              ,title: 'xxx'
            });
        }
    });
    table.on('edit(role_table0)', function(obj){ //注：edit是固定事件名，test是table原始容器的属性 lay-filter="对应的值"
      console.log(obj.value); //得到修改后的值
      console.log(obj.field); //当前编辑的字段名
      console.log(obj.data); //所在行的所有相关数据  
    });



    layer.roleDel = function(data){
        console.log(data.roleid);

        $.ajax({
            url:'<?php echo url("backend/User/delRole"); ?>',
            dataType:'json',
            type:'POST',
            data:'id='+data.roleid,
            success:function(res){
                console.log(res);
                // table.render();
            }.bind(this)
        }) ;
        table.reload('role_table', {
          url: '../User/getRole'
        });
    }
  
    
});
document.getElementById('add_role').onclick = function(){
    layui.use(['layer','table'], function(){ 
    var layer = layui.layer;
        layer.open({
            type: 2,
            title: '添加角色',
            shadeClose: true,
            shade: 0.8,
            area: ['380px', '90%'],
            content: '../user/add_role' //iframe的url
        });
      //触发事件
    });
}

</script>

<script type="text/html" id="tableBar">
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="edit_role_power">修改权限</a>
</script>

</html>