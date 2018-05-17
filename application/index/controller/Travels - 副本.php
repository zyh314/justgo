<?php
namespace app\index\controller;
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
    public function index()
    {
        $id = Session::get('user_id');
        if($id){
	        $where = [
	            'userid' => $id
	        ];
	        $res = db('t_user')->where($where)->find();
	        $this->assign('username',$res['uname']);
	        $this->assign('userHead',$res['uIcon']);
	        $this->assign('userBtn0','注销');
        }else{
        	$this->assign('username','请登录');
        	$this->assign('userHead','../../../public/static/images/users/default-user-avatar.png');
	        $this->assign('userBtn0','注册');
        }
        return $this->fetch('/index');
    }
    public function login()
    {
        return $this->fetch('/login');
    }
    public function register()
    {
        return $this->fetch('/register');
    }
    public function first()
    {
        return $this->fetch('/first');
    }
    public function travels()
    {
        return $this->fetch('/travels');
    }
    public function user_center()
    {
        $id = Session::get('user_id');
        if($id){
	        $where = [
	            'uname' => $id
	        ];
	        $res = db('t_user')->where($where)->find();
	        $this->assign('username',$res['uname']);
	        $this->assign('userHead',$res['uIcon']);
	        $this->assign('userBtn0','注销');
        }else{
        	$this->assign('username','请登录');
        	$this->assign('userHead','../../../public/static/images/users/default-user-avatar.png');
	        $this->assign('userBtn0','注册');
        }
        if($id){
	        $res0 = db('t_user_menu')->select();
	        $this->assign('user_menu',$res0);
	        return $this->fetch('/user_center');
        }else{
        	echo json_encode('false');
        }
    }


    public function user()
    {
    	$page = input('?get.page')?input('get.page'):'';
    	// echo $page;
    	if($page == ''){
	    	$nowpage = [//数字10为每页显示的总条数，true为去掉中间的页码部分，false为显示分页的页码
	            'page'     => 1,//传入跳转值给当前页
	        ];
    	}else{
    		$nowpage = [//数字10为每页显示的总条数，true为去掉中间的页码部分，false为显示分页的页码
	            'page'     => $page,//传入跳转值给当前页
	        ];
    	};
    	$start = ($page-1)*5;
    	$res0 = db('record')->paginate(5);
    	// $page = db('record')->paginate(5,false,$nowpage);
    	$this->assign('res0',$res0);
    	// $this->assign('page',$page);
        return $this->fetch('/user');
    }
    public function loginChk(){
        $uname = input('?post.uname')?input('post.uname'):'';
        $upassword = input('?post.upassword')?input('post.upassword'):'';
        $code = input('?post.code')?input('post.code'):'';
        $res =  captcha_check($code);//调用check方法进行验证
        $res = true;
        if($res == false){
            echo json_encode('codeErr');
            // return;
        }elseif ($res == true) {
            $where = [
                'uname' => $uname,
                'upassword' => $upassword
            ];
            $res = db('t_user')->where($where)->find();
            if ($res) {
                $time=3600*24*7;
                cookie('user_id',$res['uname'],$time);
                session("user_id", $res['userid']);
                session("onlineUser", $res);
                /*var_dump($res);*/
                echo json_encode('true');
//                 return $this->fetch('/index');
            }else{
                echo json_encode('false');
            }
        }
    }
    function loginSessionChk(){
        $id = Session::get('adm_id');
        if($id){
            echo json_encode('true');
        }else{
            echo json_encode('false');
        }
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
    public function myTravels()
    {
        return $this->fetch('/myTravels');
    }
    public function myZudui()
    {
        return $this->fetch('/myZudui');
    }
    public function server()
    {
        return $this->fetch('/server');
    }
    public function goods_collect()
    {
        return $this->fetch('/goods_collect');
    }
    public function travels_collect()
    {
        return $this->fetch('/travels_collect');
    }
    public function zudui_collect()
    {
        return $this->fetch('/zudui_collect');
    }
    public function all_goods()
    {
        return $this->fetch('/all_goods');
    }
    public function goods_unpay()
    {
        return $this->fetch('/goods_unpay');
    }
    public function goods_pay()
    {
        return $this->fetch('/goods_pay');
    }
    public function goods_fin()
    {
        return $this->fetch('/goods_fin');
    }
    public function goods_cancel()
    {
        return $this->fetch('/goods_cancel');
    }
    public function edit_head()
    {
        return $this->fetch('/edit_head');
    }
    public function edit_info()
    {
        return $this->fetch('/edit_info');
    }
    public function edit_psw()
    {
        return $this->fetch('/edit_psw');
    }
    public function edit_money()
    {
        return $this->fetch('/edit_money');
    }


}
