<?php
namespace app\xcx\controller;
use \think\Controller;
use \think\Db;
use \think\Config;
use \think\Session;
use \think\Redis;

class Index extends Controller
{
	protected $beforeActionList = [
		'checkSession' => ['except' => 'del,user']
	];
    function checkSession(){
        return '进行验证';
    }
    function login(){
        $account =  input('?post.account')?input('post.account'):"";
        $password =  input('?post.password')?input('post.password'):"";
        $where = [
            'uname' => $account,
            'upassword' => $password
        ];
        $res = db('t_user')->where($where)->find();
        if ($res) {
            $time=3600*24*7;
            // cookie('user_id',$res['userid'],$time);
            // session("user_id", $res['userid']);
            // session("onlineUser", $res);
            echo json_encode('true');
            // return $this->fetch('/index');
        }else{
            echo json_encode('false');
        }
    }
    function loginNormal(){
        return 'loginNormal';
    }


}




