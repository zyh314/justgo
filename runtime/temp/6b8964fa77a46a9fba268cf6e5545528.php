<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:64:"D:\WEB\PHP\JustGo0\public/../application/backend\view\admin.html";i:1526457324;}*/ ?>
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
    <input type="" name="" v-model = 'test'>
<div>
<div class = 'nav'>当前位置：/系统管理/员工管理</div>
<div class = 'btn_line_box'>
    <div class = 'btn_one' id = 'add_admin' href = "<?php echo url('backend/index/add_admin'); ?>" target="ifr">添加</div>
    <div class = 'btn_one' id = 'useAdmin' v-on:click='useAdmin()'>使用</div>
    <div class = 'btn_one' id = 'lockAdmin' v-on:click='lockAdmin()'>锁定</div>
<!--     <span>用户状态</span>
    <select id = 'admin_con_sel'>
        <option value = '0' selected="selected">使用</option>
        <option value = '1'>锁定</option>
    </select> -->
</div>
<table class = 'admin_table table0' border="1" cellpaddiv="0" cellspaciv="0">
    <tr>
        <td colspan="7">用户列表</td>
    </tr>
    <tr>
        <th><input type="checkbox" name="" v-on:click='adminArrAll()' id = 'adminArrAll'></th>
        <th>id</th>
        <th>账号</th>
        <th>用户名称</th>
        <th>用户角色</th>
        <th>用户状态</th>
        <th>操作</th>
    </tr> 
    <tr v-for = 'x in adminArr'>
        <!-- <td><input type="checkbox" class = 'lockChk'  v-on:click="lockClick(x.employeeid)" checked='{{x.chk}}'></td> -->
        <td><input type="checkbox" class = 'lockChk'  v-on:click="lockClick(x.employeeid)"></td>
        <td>{{x.employeeid}}</td>
        <td>{{x.account}}</td>
        <td>{{x.name}}</td>
        <td>{{x.rname}}</td>
        <td>
           <!--  <span v-if = 'x.locking==""'>使用</span>
            <span v-if = 'x.locking==""'>锁定</span>
 -->            
            <span>{{x.locking}}</span>
        </td>
        <td>
            <input type="button" value="修改信息" class = 'editAdmin' name="" v-on:click="editAdmin(x.employeeid,x.roleid)">
            <input type="button" value="修改密码" class = 'editAdmin' name="" v-on:click="editPsw(x.employeeid)">
            <input type="button" value="删除" class = 'delAdmin'  v-on:click="delAdmin(x.employeeid)" name="">
        </td>
    </tr>
</table>
<div id="page">
    <div class = 'page_btn' v-for = 'y in page' v-on:click = 'getAdmin(y)'>{{y}}</div>
</div>
</div>
<iframe src="" id = 'add_admin_iframe'></iframe>
</div>


</body>
<script src="__JS__/jquery-3.2.1.min.js"></script>
<script src="__STATIC__/layui/layui.js"></script>
<script type="text/javascript" src = '__JS__/vue.js'></script>
<script type="text/javascript">
var myVue = new Vue({          
    el: "#app",          
    data: {
        test:0,
        adminArr:[] ,
        page:[] 
    },         
    methods:{
        useAdmin:function(){
            // console.log('haha');
            console.log(this.adminArr);
            $.ajax({
                url:'<?php echo url("backend/User/useAdmin"); ?>',
                dataType:'json',
                type:'POST',
                data:'data='+JSON.stringify(this.adminArr),
                success:function(res){
                    window.location.reload();
                }
            }) ;
            
        },
        lockAdmin:function(){
            console.log(this.adminArr);
            $.ajax({
                url:'<?php echo url("backend/User/lockAdmin"); ?>',
                dataType:'json',
                type:'POST',
                data:'data='+JSON.stringify(this.adminArr),
                success:function(res){
                    window.location.reload();
                }
            }) ;
        },
        getAdmin:function(index){
            $.ajax({
                url:'<?php echo url("backend/User/getAdmin"); ?>',
                dataType:'json',
                type:'POST',
                data:'page='+index,
                success:function(res){
                for(var i = 0;i < res.length;i++){
                    res[i].chk='false'; 
                }
                $('.lockChk').prop('checked',false);
                $('#adminArrAll').prop('checked',false);
                this.adminArr = res;
                }.bind(this)
            }) ;
        },
        delAdmin:function(index){
            $.ajax({
                url:'<?php echo url("backend/User/delAdmin"); ?>',
                dataType:'json',
                type:'POST',
                data:'employeeid='+index,
                success:function(res){
                    console.log(res);
                    window.location.reload();
                }
            }) ;
        },
        editAdmin:function(id,role){
            localStorage.editAdminId = id;
            localStorage.editAdminRole = role;
            layui.use(['layer','table'], function(){ 
            var layer = layui.layer;
                layer.open({
                    type: 2,
                    title: '编辑成员',
                    shadeClose: true,
                    shade: 0.8,
                    area: ['380px', '90%'],
                    content: '../user/edit_admin' //iframe的url
                });
              //触发事件
            });
        },
        editPsw:function(id){
            localStorage.editAdminPsw = id;
            layui.use(['layer','table'], function(){ 
            var layer = layui.layer;
                layer.open({
                    type: 2,
                    title: '修改密码',
                    shadeClose: true,
                    shade: 0.8,
                    area: ['380px', '90%'],
                    content: '../user/edit_admin_psw' //iframe的url
                });
              //触发事件
            });
        },
        //勾选事件
        lockClick:function(id){
            for(var i = 0;i<this.adminArr.length;i++){
                if(this.adminArr[i].employeeid == id){
                    // console.log(this.adminArr[i].chk);
                    if(this.adminArr[i].chk == 'false'){
                        this.adminArr[i].chk = true
                    }else{
                        this.adminArr[i].chk = false
                    }
                    // console.log(this.adminArr[i].chk);
                }
            }
            // console.log(this.adminArr);
        },
        //全选事件
        adminArrAll:function(){
            var temp = false;
            var count = 0;
            for(var i = 0;i<this.adminArr.length;i++){
                if(this.adminArr[i].chk == true){
                    count++;
                }
            }
            if(count == 0){
                temp = true
            }else if(count == this.adminArr.length){
                temp = false;
            }else{
                temp = true
            }
            for(var i = 0;i<this.adminArr.length;i++){
                this.adminArr[i].chk = temp;
            }
            $('.lockChk').prop('checked',temp)
            // console.log(this.adminArr);
        }
    },

        

     created: function() {
    console.log("创建之后");            
    console.log(this.a)            
    console.log(this.$el)          

    },         

     beforeMount: function() {            
    console.log("mount之前")            
    console.log(this.a)            
    console.log(this.$el)          
    }, 
    mounted: function() {            
        $.ajax({
            url:'<?php echo url("backend/User/getAdmin"); ?>',
            dataType:'json',
            type:'POST',
            data:'page=1',
            success:function(res){
                console.log(res);
                for(var i = 0;i < res.length;i++){
                    res[i].chk='false'; 
                }
                this.adminArr = res;
            }.bind(this)
        }) ;
        $.ajax({
            url:'<?php echo url("backend/User/getAdminCount"); ?>',
            dataType:'json',
            type:'GET',
            success:function(res){
                console.log(res);
                var temp = [];
                res = Math.ceil(res/5);
                for(var i =1;i<=res;i++){
                    temp.push(i)
                }
                this.page = temp;
            }.bind(this)
        })
    },          

    beforeUpdate: function() {            

    console.log("更新前");            

    console.log(this.a)            

    console.log(this.$el)          

    },          

    updated: function() {            

    console.log("更新完成");            

    console.log(this.a);            

    console.log(this.$el)          

    },          

    beforeDestroy: function() {            

    console.log("销毁前");            

    console.log(this.a)            

    console.log(this.$el)            

    console.log(this.$el)          

    },          

    destroyed: function() {           

    console.log("已销毁");          

    console.log(this.a)          

    console.log(this.$el)          

    }   

});  


myVue.$watch('test', function (newValue, oldValue) {
 console.log(newValue, oldValue) // 输出 2 1
 console.log(this.test) // 输出 2
})
layui.use('layer', function(){ //独立版的layer无需执行这一句
  var $ = layui.jquery, layer = layui.layer; //独立版的layer无需执行这一句
  //触发事件
});
// document.getElementById('add_admin').onclick = function(){
//     document.getElementById('add_admin_iframe').src = 'add_admin.html';
//     document.getElementById('add_admin_iframe').style.display = 'block';
// }
document.getElementById('add_admin').onclick = function(){
    layui.use(['layer','table'], function(){ 
    var layer = layui.layer;
        layer.open({
            type: 2,
            title: '添加成员',
            shadeClose: true,
            shade: 0.8,
            area: ['380px', '90%'],
            content: '../user/add_admin_page' //iframe的url
        });
      //触发事件
    });
}



</script>
</html>