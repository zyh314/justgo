<?php
namespace app\backend\controller;
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
		'checkSession' => ['only' => 'del,user']
	];
	function checkSession(){
		return '进行验证';
//		$onlineUser = Session::get('onlineUser');
//		if(empty($onlineUser)){
//  		$this->error('登录过期，请重新登录','index/index/login');
//		}
	}
    public function index()
    {
        $res = db('t_menu')->select();
        $this->assign('menu',$res);
        return $this->fetch('/index');
    }
    public function backend()
    {
        return $this->fetch('/backend');
    }
    public function login()
    {
        return $this->fetch('/login');
    }
    public function show_menu()
    {
    	$res = db('t_menu')->select();
        // var_dump($res);
        $res = json_encode($res);
        // $res = 'hello';
        // $this->assign('menu','hello');
        // return $this->fetch('/index');
        // echo $res;
    }



    public function login_chk(){
  //   	$username = isset($_POST['username']);
    	// $psw = isset($_POST['psw']);
		// $username = isset($_POST['username'])?$_POST['username']:"";
		// $psw = isset($_POST['psw'])?$_POST['psw']:"";
    	$username = input('?post.username')?input('post.username'):'';
    	$psw = input('?post.psw')?input('post.psw'):'';
    	$where = [
    		'Id' => $username,
    		'psw' => $psw
    	];
    	$res = db('admin')->where($where)->find();
    	// echo Db::table('admin')->getLastSql();
    	var_dump($res);
    }
    public function search(){
    	$word = input('?post.word')?input('post.word'):'';
    	$where = [
    		'info' => ['like','%'.$word.'%']
    	];
    	$res = db('record')->where($where)->paginate(5);
    	$this->assign('res0',$res);
        return $this->fetch('/user');
    	// echo Db::table('admin')->getLastSql();
    	// var_dump($res);
    }
    public function del(){
    	$userInfo = Session::get('userInfo');
    	if(!$userInfo){
    		return;
    	}
    	$id = input('?post.id')?input('post.id'):'';
    	$where = [
    		'record_id' => $id
    	];
    	$res = db('record')->where($where)->delete();
    	// $this->assign('res0',$res);
        return $this->fetch('/user');
    	// echo Db::table('admin')->getLastSql();
    	// var_dump($res);
    }

    public function travels()
    {
        return $this->fetch('/travels');
    }
    public function comment()
    {
        return $this->fetch('/comment');
    }
    public function zudui()
    {
        return $this->fetch('/zudui');
    }
    public function chengyuan()
    {
        return $this->fetch('/chengyuan');
    }
    public function fabu()
    {
    	$res = db('t_location')->where('fid',0)->select();
        $this->assign('location',$res);
        return $this->fetch('/fabu');
    }
    public function goodsInfo()
    {
        return $this->fetch('/goodsInfo');
    }
    public function pendingPage()
    {
        return $this->fetch('/pendingPage');
    }
    public function boughtPage()
    {
        return $this->fetch('/pending');
    }
    public function boughtPage()
    {
        return $this->fetch('/paid');
    }
    public function admin()
    {
        return $this->fetch('/admin');
    }
    public function role()
    {
        return $this->fetch('/role');
    }
    public function user()
    {
        return $this->fetch('/user');
    }
    public function yongHuTongJi()
    {
        return $this->fetch('/yongHuTongJi');
    }
    public function yinXiao()
    {
        return $this->fetch('/yinXiao');
    }
}

