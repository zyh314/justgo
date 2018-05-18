<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"D:\WEB\PHP\JustGo0\public/../application/index\view\orders_pay.html";i:1526455872;}*/ ?>
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
<div class = 'nav'>全部订单</div>
<div class = 'btn_line_box'>
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
        ,url:"../Goods/allOrders"
        ,cols: [[{type:'checkbox'}
            ,{field:'orderid',title:'订单ID'}
            ,{field:'userid',title:'用户id'}
            ,{field:'image', templet:'#goodsImage',title:'图片'}
            ,{field:'name',title:'景点名'}
            ,{field:'price',title:'单价'}
            ,{field:'orderqty',title:'购买数量'}
            ,{field:'orderprice',title:'总价'}
            ,{field:'osname',title:'订单状态'}
            ,{fixed:'right',title:'操作',toolbar:'#barDemo'}
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

        if(layEvent === 'detail'){ //查看
            localStorage.detail=data.orderid;

            layui.use(['layer','table'], function(){ 
            var layer = layui.layer;
                layer.open({
                    type: 2,
                    shift: 2,
                    area: ['300px', '500px'],
                    title: '商品详情',
                    content: '../goods/orderdetails?orderid='+(obj.data.orderid),
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
        console.log(data.rid);

        $.ajax({
            url:'<?php echo url("backend/User/delRole"); ?>',
            dataType:'json',
            type:'POST',
            data:'id='+data.rid,
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

</script>

<script type="text/html" id="barDemo">
  <a class="layui-btn layui-btn-xs" lay-event="detail">查看</a>
  {{#  if(d.osname == '待支付'){ }}
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">取消订单</a>
  {{#  } else if(d.osname === '交易关闭') { }}
  <a class="layui-btn layui-btn-danger layui-btn-xs layui-disabled" lay-event="role_power">删除</a>
  {{#  } }}
</script>  

</html>