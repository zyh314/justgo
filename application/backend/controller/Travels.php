<?php
namespace app\backend\controller;
use \think\Controller;
use \think\Db;
use \think\Config;
use \think\Session;
use \think\Redis;

class Travels extends Controller
{
	protected $beforeActionList = [
		'checkSession' => ['except' => 'del,user']
	];
	public function checkSession(){
		return '进行验证';
	}
}
