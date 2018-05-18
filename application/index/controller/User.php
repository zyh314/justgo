<?php
namespace app\index\controller;
use \think\Controller;
use \think\Db;
use \think\Config;
use \think\Session;
use \think\Redis;

class User extends Controller
{
	protected $beforeActionList = [
		'checkSession' => ['except' => 'del,user']
	];
	public function checkSession(){
		return '进行验证';
	}
    public function index()
    {
        return $this->fetch('/travels');
    }
    function register(){
    	$uname = input('?post.uname')?input('post.uname'):'';
    	$upassword = input('?post.upassword')?input('post.upassword'):'';
    	$uemail = input('?post.uemail')?input('post.uemail'):'';
    	$ugender = input('?post.ugender')?input('post.ugender'):'';
    	$uphoneNo = input('?post.uphoneNo')?input('post.uphoneNo'):'';
       	$where = [
    		'uname' => $uname,
    		'uemail' => $uemail,
    		'upassword' => $upassword,
    		'ugender' => $ugender,
    		'uphoneNo' => $uphoneNo
    	];
    	$res = db('t_user')->insert($where);
    	echo $res;
    }
    function getUserOne(){
<<<<<<< HEAD
<<<<<<< HEAD
=======
        $uid = Session::get('user_id');
       	$where = [
    		'uname' => $uid
>>>>>>> parent of 7074158... Revert "Merge branch 'master' of https://github.com/zyh314/justgo"
=======
        $uid = Session::get('user_id');
       	$where = [
    		'uname' => $uid
>>>>>>> parent of 7074158... Revert "Merge branch 'master' of https://github.com/zyh314/justgo"
        $userid = Session::get('user_id');
       	$where = [
    		'userid' => $userid
    	];
    	$res = db('t_user')->where($where)->find();
    	// $this->assign('res0',$res);
    	$res = json_encode($res);
    	echo $res;
        // return $this->fetch('/user');
    }
    function editUser(){
        $userid = Session::get('user_id');
    	// $userid = input('?post.userid')?input('post.userid'):'';
    	$nickname = input('?post.nickname')?input('post.nickname'):'';
    	$uphoneNo = input('?post.uphoneNo')?input('post.uphoneNo'):'';
    	$uemail = input('?post.uemail')?input('post.uemail'):'';
       	$where = [
    		'userid' => $userid
    	];
       	$data = [
    		'nickname' => $nickname,
    		'uphoneNo' => $uphoneNo,
    		'uemail' => $uemail
    	];
    	$res = db('t_user')->where($where)->update($data);
    	echo $res;
    }
    function editUserPsw(){
        $userid = Session::get('user_id');
    	// $userid = input('?post.userid')?input('post.userid'):'';
    	$upassword = input('?post.upassword')?input('post.upassword'):'';
       	$where = [
    		'userid' => $userid
    	];
       	$data = [
    		'upassword' => $upassword
    	];
    	$res = db('t_user')->where($where)->update($data);
    	echo $res;
    }
    function editUserMoney(){
        $userid = Session::get('user_id');
    	$money = input('?post.money')?input('post.money'):'';
       	$where = [
    		'userid' => $userid
    	];
       	$data = [
    		'umoney' => $money
    	];
    	$res = db('t_user')->where($where)->setInc('umoney',$money);
    	echo $res;
    }
}
