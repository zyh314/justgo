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
        return 'test00';
    }
    function loginNormal(){
        return 'loginNormal';
    }


}




