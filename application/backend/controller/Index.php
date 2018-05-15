<?php
namespace app\backend\controller;
use \think\Controller;
use \think\Db;
use \think\Config;
use \think\Session;
use \think\Redis;

class Index extends Controller
{
    //登录
    
    function login_chk(){                                                                                            
        $eid = input('?post.eid')?input('post.eid'):'';
        $epassword = input('?post.epassword')?input('post.epassword'):'';
        $code = input('?post.code')?input('post.code'):'';
        $res =  captcha_check($code);//调用check方法进行验证
        $res = true;
        if($res == false){
            echo json_encode('codeErr');
            // return;
        }elseif ($res == true) {
            $where = [
                'eid' => $eid,
                'epassword' => $epassword
            ];
            $res = db('t_employee')->where($where)->find();
            if ($res) {
                $time=3600*24*7;
                cookie('adm_id',$res['eid'],$time);
                session("adm_id", $res['eid']);
                echo json_encode('true');
                // return $this->fetch('/index');
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
    public function loginOut(){
        cookie(null);
        session(null);
        //退出后重定向回登录界面
        return $this->success('/login');
    }

    //登录结束
	protected $beforeActionList = [
		'checkSession' => ['except' => 'del,user']
	];
	function checkSession(){
		return '进行验证';
	}
    public function index()
    {
        $id = Session::get('adm_id');
        $where = [
            'eid' => $id
        ];
        $res = db('t_employee')->where($where)->find();
        $this->assign('username',$res['ename']);
        // $this->assign('uname',$res);
        $where = [
            'rid' => $res['rid']
        ];
        $res0 = db('t_refpurview a')->join('t_menu b','a.pid = b.pid')->where($where)->select();
        $this->assign('menu',$res0);
        // echo json_encode($res0);
        return $this->fetch('/index');
    }
    public function login()
    {
        return $this->fetch('/login');
    }
    public function backend()
    {
        return $this->fetch('/backend');
    }
    public function add_admin()
    {
        return $this->fetch('/add_admin');
    }
    public function search(){
    	$word = input('?post.word')?input('post.word'):'';
    	$where = [
    		'info' => ['like','%'.$word.'%']
    	];
    	$res = db('record')->where($where)->paginate(5);
    	$this->assign('res0',$res);
        return $this->fetch('/user');
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
        return $this->fetch('/boughtPage');
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
    public function register()
    {
        return $this->fetch('/register');
    }
}

