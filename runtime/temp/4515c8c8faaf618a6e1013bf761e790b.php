<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"D:\WEB\PHP\JustGo0\public/../application/index\view\orders_all.html";i:1526476681;}*/ ?>
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

<div id = 'order_table' lay-filter = 'order_table0'>
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
    $.ajax({ 
      url: "../goods/allOrders", 
      type: "GET", 
      dataType: "json", 
      success: function(data){ 
        console.log(data);
        var res = data;
        for(var i = 0;i<res.data.length;i++){
          res.data[i].allPrice = res.data[i].orderprice*res.data[i].orderqty;
          console.log(res.data[i].allPrice);
        }
        table.render({
          elem: '#order_table'
          ,page:true
          // ,url:"../Goods/allOrders"
          ,data:res.data
          ,cols: [[{type:'checkbox'}
            ,{field:'orderid',title:'订单ID'}
            // ,{field:'userid',title:'用户id'}
            ,{field:'image', templet:'#goodsImage',title:'图片'}
            ,{field:'name',title:'景点名'}
            ,{field:'orderprice',title:'单价'}
            ,{field:'orderqty',title:'购买数量'}
            ,{field:'allPrice',title:'总价'}
            ,{field:'osname',title:'订单状态'}
            ,{fixed:'right',title:'操作',toolbar:'#barDemo'}
          ]] 
        })
      }
    }); 
    //监听工具条
    table.on('tool(order_table0)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
        var data = obj.data; //获得当前行数据
        var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
        var tr = obj.tr; //获得当前行 tr 的DOM对象

        if(layEvent === 'orderDetail'){ //查看
            // localStorage.detail=data.orderid;

            layui.use(['layer','table'], function(){ 
            var layer = layui.layer;
                layer.open({
                    type: 2,
                    shift: 2,
                    area: ['300px', '500px'],
                    title: '商品详情',
                    content: '../goods/orderdetails?orderid='+(obj.data.orderid),
                  });
            });
        }
        if(layEvent === 'commentOrder'){ //评论订单
            // localStorage.detail=data.orderid;

            layui.use(['layer','table'], function(){ 
            var layer = layui.layer;
                layer.open({
                    type: 2,
                    shift: 2,
                    area: ['300px', '500px'],
                    title: '评论订单',
                    content: '../goods/orderdetails?orderid='+(obj.data.orderid),
                  });
            });
        }
        else if(layEvent === 'orderFakeDel')
        { //删除
            layer.confirm('真的要取消订单行么', function(index){
                obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                // console.log(index);
                if(index == 1){
                    layer.orderFakeDel(data);
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
    table.on('edit(order_table0)', function(obj){ //注：edit是固定事件名，test是table原始容器的属性 lay-filter="对应的值"
      console.log(obj.value); //得到修改后的值
      console.log(obj.field); //当前编辑的字段名
      console.log(obj.data); //所在行的所有相关数据  
    });



    layer.orderFakeDel = function(data){
        console.log(data.rid);

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
    }
  
    
});

</script>

<script type="text/html" id="barDemo">
  <a class="layui-btn layui-btn-xs" lay-event="orderDetail">查看</a>
  {{# if(d.orderComment == '未评论'){ }}
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="commentOrder">评论</a>
  {{#  } }}
  {{#  if(d.orderStatus == '1'){ }}
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="orderFakeDel">取消订单</a>
  {{#  }else if(d.orderStatus == '5') { }}
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="orderDel">删除</a>
  {{#  } }}
</script> 
<script type="text/html" id="goodsImage">
  <div>
    <img src="{{d.image}}" />
  </div>
</script>
<script type="text/html" id="allPrice">
  {{d.orderprice}}*{{d.orderqty}}
</script>
</html>