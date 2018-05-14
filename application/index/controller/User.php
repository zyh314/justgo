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
        $uid = Session::get('user_id');
       	$where = [
    		'uname' => $uid
    	];
    	$res = db('t_user')->where($where)->find();
    	// $this->assign('res0',$res);
    	$res = json_encode($res);
    	echo $res;
        // return $this->fetch('/user');
    }
}
