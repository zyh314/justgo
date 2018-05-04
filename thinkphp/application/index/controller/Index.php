<?php
namespace app\index\controller;
use \think\Controller;
use \think\config;
use \think\Session;
use \think\Cache;
class Index extends Controller
{
	protected $beforeActionList = [
		'checkSession' => ['only'=>'center,delete,addWenjuan'],
	];
	public function _initialize(){
		
	}
//	显示问卷星首页
    public function index()
    {
//  	phpinfo();
    	//require 'xxx.xxx';
        return $this->fetch('/layui');
    }
//	显示问卷星登录页
	public function login(){
		return $this->fetch('/login');
	}
	public function checkSession(){
		$userInfo = Session::get('userInfo');
		if(empty($userInfo)){
			$this->error('您还尚未登录，请先登录','index/index/login');
		}
	}
	public function center(){
		$keyword = input('?get.keyword')?input('get.keyword'):'';
		$p = input('?get.page')?input('get.page'):'';
		if(!empty($keyword)){
			$where = [
				'title' => ['like','%'.$keyword.'%']
			];
		}else{
			$where = [];
		}
		
//		读取问卷数据，我都优先从文件中读取，文件中不存在的话才去查询数据库，降低数据库的查询频率
//		$handle=fopen('wjlist.txt', 'a+');
//		$wjList=fgets($handle);
		$wjList = Cache::get('wjlist'.$keyword);
		$pageHtml = Cache::get('page'.$p);
		if(!$wjList || !$pageHtml){
			$wjList = db('wenjuan')->where($where)->order('id desc')->paginate(3,false,[
				'query' => [
					'keyword'=>$keyword
				]
			]);
			$pageHtml=$wjList->render();
			Cache::set('wjlist'.$keyword,json_encode($wjList));
			Cache::set('page'.$p,$pageHtml);
//			fwrite($handle, json_encode($wjList));
		}else{
			$wjList = json_decode($wjList,true)['data'];
		}
		$title = '问卷星个人页面';
		$this->assign('title',$title);
		$this->assign('page',$pageHtml);
		$this->assign('wjList',$wjList);
		return $this->fetch('/center');
	}
	public function questionnaire(){
		return $this->fetch('/questionnaire');
	}
	public function dologin(){
		$returnJson = [
			'code' => 10001,
			'msg' => Config::get('Message')['LOGIN_FAIL'],
			'data' => []
		];
		$username = input('?post.username')?input('post.username'):'';
		$password = input('?post.password')?input('post.password'):'';
		$code = input('?post.code')?input('post.code'):'';
		
//		验证第一步-验证码是否正确？
		
		if(!captcha_check($code)){
			$returnJson = [
				'code' => 10002,
				'msg' => Config::get('Message')['CODE_ERROR'],
				'data' => []
			];
			echo json_encode($returnJson);
			exit();
		}
//		去数据库查询
		$where = [
			'username' => $username,
			'password' => $password
		];
		$result=db('user')->where($where)->find();
		if(empty($result)){
			$returnJson = [
				'code' => 10003,
				'msg' => Config::get('Message')['ACCOUNT_ERROR'],
				'data' => []
			];
		}else{
			$returnJson = [
				'code' => 10000,
				'msg' => Config::get('Message')['SUCCESS'],
				'data' => []
			];
			Session::set('userInfo',$result);
		}
		echo json_encode($returnJson);
		exit();
	}
	public function delete(){
		$id=input('?get.id')?input('get.id'):'';
		if(!empty($id)){
			$where = [
				'id' => $id
			];
			$result = db('wenjuan')->where($where)->delete();
			if($result){
				$this->success('删除成功！','index/index/center');
			}else{
				$this->error('删除失败！','index/index/center');
			}
		}
	}
	public function addWenjuan(){
		$title=input('?post.title')?input('post.title'):'';
		$insertData = [
			'title' => $title
		];
		$result = db('wenjuan')->insert($insertData);
		echo $result;
	}
	public function logout(){
		Session::delete('userInfo');
		$this->success('注销成功！','index/index/index');
	}
	public function miaosha(){
//		1、查询数据库，查询一下秒杀表中的商品库存还剩几件
//		2、判断库存，若干库存大于等于1件，提示秒杀成功，减少库存
//		利用apache的bin目录下，有自带一个压测工具（并发测试），它的名字叫做ab.exe
//		ab -c [int] -n [int] [要测试的路径]
//		ab -c [10] -n [10] [要测试的路径]
//		同时发送十次请求，每次请求都带了10个并发过去
		$redis = new \Redis();
		$con = $redis->connect('127.0.0.1',6379);
//		$data = db('miaosha')->where('id',1)->find();
		if($con){
			$stock = $redis->lpop('stock');
			if($stock){
				file_put_contents('miaosha.txt', '有一个幸运儿秒杀成功了',FILE_APPEND);
				db('miaosha')->where('id',1)->setDec('stock');
			}
		}
//		if($data['stock']>=1){
//			file_put_contents('miaosha.txt', '有一个幸运儿秒杀成功了',FILE_APPEND);
//			db('miaosha')->where('id',1)->setDec('stock');
//		}
	} 
//	将商品库存数据先写入redis
	public function addRedis(){
		$redis = new \Redis();
		$con = $redis->connect('127.0.0.1',6379);
		if($con){
			$redis->lpush('stock',1);
		}
		var_dump($redis->lsize('stock'));
	}
	public function haxi(){
		$good = [
			'title' => '短衬衫',
			'price' => 99,
			'stock' => 100,
			'color' => 'color'
		];
		$redis = new \Redis();
		$con = $redis->connect('127.0.0.1',6379);
		if($con){
//			$redis->delete('good');
			foreach ($good as $key => $value){
				$redis->hSet('good',$key,$value);
			}
			$result = $redis->hGetAll('good');
			var_dump($result);
		}
	}
	public function wjRank(){
		$redis = new \Redis();
		$con = $redis->connect('127.0.0.1',6379);
		$result = db('wenjuan')->select();
		foreach ($result as $key => $value){
			foreach($value as $k=>$v){}
			$redis->hSet('wjRank',$key,$v);
		}
		$res = $redis->hGetAll('wjRank');
		var_dump($res);
	}
}
