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
    public function travelmall()
    {
        return $this->fetch('/travelmall');
    }
    public function user_center()
    {
        $id = Session::get('user_id');
        if($id){
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> parent of 7074158... Revert "Merge branch 'master' of https://github.com/zyh314/justgo"
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
        if($id){
            $res0 = db('t_user_menu')->select();
            $this->assign('user_menu',$res0);
            return $this->fetch('/user_center');
        }else{
            echo json_encode('false');
<<<<<<< HEAD
>>>>>>> parent of 7074158... Revert "Merge branch 'master' of https://github.com/zyh314/justgo"
=======
>>>>>>> parent of 7074158... Revert "Merge branch 'master' of https://github.com/zyh314/justgo"
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
        if($id){
	        $res0 = db('t_user_menu')->select();
	        $this->assign('user_menu',$res0);
	        return $this->fetch('/user_center');
        }else{
        	echo json_encode('false');
            return $this->fetch('/index');
        }
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> parent of 7074158... Revert "Merge branch 'master' of https://github.com/zyh314/justgo"
            $res1 = db('t_user')->where($where)->find();
            if ($res1) {
                $time=3600*24*7;
                Cookie::set('user_id',$res1['userid'],$time);
                Session::set("user_id", $res1['userid']);
                echo json_encode('true');
<<<<<<< HEAD
>>>>>>> parent of 7074158... Revert "Merge branch 'master' of https://github.com/zyh314/justgo"
=======
>>>>>>> parent of 7074158... Revert "Merge branch 'master' of https://github.com/zyh314/justgo"
            $res = db('t_user')->where($where)->find();
            if ($res) {
                $time=3600*24*7;
                cookie('user_id',$res['userid'],$time);
                session("user_id", $res['userid']);
                session("onlineUser", $res);
                echo json_encode('true');
                // return $this->fetch('/index');
            }else{
                echo json_encode('false');
            }
        }
    }
    function loginSessionChk(){
        $id = Session::get('user_id');
        if($id){
            echo json_encode('true');
        }else{
            echo json_encode('false');
        }
    }
<<<<<<< HEAD
    public function login()
    {
        return $this->fetch('/login');
    }
    //发表游记
    public function travels()
    {
        return $this->fetch('/travels');
    }
    //测试
    public function test()
    {
        return $this->fetch('/test');
    }
    //攻略
    public function gonglue()
    {
        return $this->fetch('/gonglue');
    }
    //我的游记
    public function myTravel()
    {
        return $this->fetch('/myTravel');
    }
    //显示游记及评论
    public function showTravels()
    {
        //获取游记ID
        $id = input('?get.id')?input('get.id'):"";

        $where = [
            'travelsid' => $id
        ];
        //$page = $com->render();
        //$this->assign('page', $page);

        //该篇游记的内容
        $travel = db('t_travels')
            ->join('t_user','t_user.userid = t_travels.userid')
            ->field('t_user.uname,t_user.uIcon,t_user.uintegral,t_travels.*')
            ->where($where)
            ->select();
        $this->assign('travel',$travel[0]);

        //从缓存获取这篇游记的点赞数
        $redis = new \Redis();
        //本地连接127.0.0.1 6379是redis的端口
        $con = $redis -> connect('127.0.0.1',6379);
        if ($con){
            $countDing = $redis->hLen($id);
            //$res = $redis->hGet($id,4);
            $this->assign('ding',$countDing);
            return $this->fetch('/showTravels');
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
    public function login_chk(){
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
    public function loginOut(){
        Session::delete('user_id');
        Cookie::delete('user_id');
        //退出后重定向回登录界面
        return $this->fetch('/index');
    }

=======
>>>>>>> parent of bdcb9b2... Merge branch 'master' of https://github.com/zyh314/justgo
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
    public function orders_all()
    {
        return $this->fetch('/orders_all');
    }
    public function orders_unpay()
    {
        return $this->fetch('/orders_unpay');
    }
    public function orders_pay()
    {
        return $this->fetch('/orders_pay');
    }
    public function orders_fin()
    {
        return $this->fetch('/orders_fin');
    }
    public function orders_cancel()
    {
        return $this->fetch('/orders_cancel');
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
        $id = Session::get('user_id');
        $where = [
            'userid' => $id
        ];
        $res = db('t_user')->where($where)->find();
        $this->assign('umoney',$res['umoney']);
        return $this->fetch('/edit_money');
    }
    public function loginOut(){
        cookie(null);
        session(null);
        //退出后重定向回登录界面
        return $this->success('注销成功','index/Index/index');
    }
<<<<<<< HEAD
<<<<<<< HEAD
    //个人中心
    public function myCenter()
    {
        $userid = Session::get('user_id');
        if ($userid){
            return $this->fetch('/myCenter');
        }else{
            $this->error('请先登录',"/justgo/public/index/index/myCenter");
        }

    };
=======
>>>>>>> parent of 7074158... Revert "Merge branch 'master' of https://github.com/zyh314/justgo"
=======
>>>>>>> parent of 7074158... Revert "Merge branch 'master' of https://github.com/zyh314/justgo"
}
