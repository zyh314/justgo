<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\WEB\PHP\justgo\public/../application/backend\view\edit_role_power.html";i:1525921007;}*/ ?>
<!DOCTYPE html>
<HTML>
<HEAD>
  <TITLE> ZTREE DEMO - checkbox</TITLE>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" href="__CSS__/zTreeStyle/zTreeStyle.css" type="text/css">
  <script type="text/javascript" src="__JS__/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="__JS__/jquery.ztree.core.js"></script>
  <script type="text/javascript" src="__JS__/jquery.ztree.excheck.js"></script>
  <!--
  <script type="text/javascript" src="__JS__/jquery.ztree.exedit.js"></script>
  -->

</HEAD>

<BODY>
    <ul id="treeDemo" class="ztree"></ul>
    <button id = 'submit'>提交</button>
</BODY>


  <SCRIPT type="text/javascript">
    function getAdminOnePower(){
      $.ajax({
        url:'<?php echo url("backend/User/getPower"); ?>',
        dataType:'json',
        type:'GET',
        success:function(res){
          console.log(res);
        }
      })
    }
    var setting = {
      check: {
        enable: true
      },
      data: {
        simpleData: {
          enable: true
        }
      }
    };
    $.ajax({
      url:'<?php echo url("backend/User/getPower"); ?>',
      dataType:'json',
      type:'GET',
      success:function(res){
        console.log('all',res);
        $.fn.zTree.init($("#treeDemo"), setting, res);
        initialCheck();
      }
    })
    
    var code;
    function initialCheck(){
      $.ajax({
        url:'<?php echo url("backend/User/getOnePower"); ?>',
        dataType:'json',
        type:'POST',
        data:'id='+Number(localStorage.edit_role_power_roleid),
        success:function(res){
          var zTree = $.fn.zTree.getZTreeObj("treeDemo");
          console.log(res);
          for(var i = 0;i < res.length;i++){
            var nodes = zTree.getNodesByParam("pid", res[i].pid, null);
            console.log(nodes);
            if (nodes.length > 0&&nodes[0].pid>5){
              zTree.checkNode(nodes[0], true, true);
            }
          }
        }
      })
    }
    
    function storePower() {
      var zTree = $.fn.zTree.getZTreeObj("treeDemo");
      var rid = Number(localStorage.edit_role_power_roleid);
      var res =  zTree.getChangeCheckedNodes();
      console.log(res);
      var temp = [];
      for(var i = 0;i < res.length;i++){
        if(res[i].checked == true){
          temp.push({pid:res[i].pid,rid:rid})
        }
      }
      console.log(temp);
      temp = JSON.stringify(temp);
      $.ajax({
        url:'<?php echo url("backend/User/storePower"); ?>',
        dataType:'json',
        type:'POST',
        data:'data='+temp,
        success:function(res){
          console.log(res);
          window.parent.location.reload();
        }
      })
    }
    $('#submit').on('click',function(){
      storePower()
    })
    
    //-->
  </SCRIPT>
</HTML>