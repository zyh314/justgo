<?php
namespace app\xcx\controller;
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
    public function index()
    {
        return $this->fetch('/travels');
    }
}
