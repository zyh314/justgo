<?php
namespace app\backend\controller;
use \think\Controller;
use \think\Db;
use \think\Config;
use \think\Session;
use \think\Redis;
// use \think\captcha;

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
    public function add_role()
    {
        return $this->fetch('/add_role');
    }
    public function add_admin_page()
    {
        return $this->fetch('/add_admin');
    }
    public function edit_admin()
    {
        return $this->fetch('/edit_admin');
    }
    public function edit_admin_psw()
    {
        return $this->fetch('/edit_admin_psw');
    }
    public function edit_role_power()
    {
        return $this->fetch('/edit_role_power');
    }
    function getAdmin(){
    	$page = input('?post.page')?input('post.page'):'';
    	$count = ($page-1)*5;
    	$res = db('t_employee a')->join('t_role b','a.rid = b.rid')->limit(5,$count)->select();
    	// $this->assign('res0',$res);
    	$res = json_encode($res);
    	echo $res;
        // return $this->fetch('/user');
    }
    function chkPsw(){
    	$eid = input('?post.eid')?input('post.eid'):'';
    	$epassword = input('?post.epassword')?input('post.epassword'):'';
       	$where = [
    		'eid' => $eid,
    		'epassword' => $epassword
    	];
    	$res = db('t_employee')->where($where)->find();
    	// $this->assign('res0',$res);
    	$res = json_encode($res);
    	echo $res;
        // return $this->fetch('/user');
    }
    public function username_login_chk(){
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
    function getAdminOne(){
    	$eid = input('?post.eid')?input('post.eid'):'';
       	$where = [
    		'eid' => $eid
    	];
    	$res = db('t_employee a')->join('t_role b','a.rid = b.rid')->where($where)->find();
    	// $this->assign('res0',$res);
    	$res = json_encode($res);
    	echo $res;
        // return $this->fetch('/user');
    }
    function getRole(){
    	$page = input('?get.page')?input('get.page'):'';
    	$limit = input('?get.limit')?input('get.limit'):'';
    	$count = ($page-1)*$limit;
    	$res = db('t_role')->limit($limit,$count)->select();
    	$num = db('t_role')->count();
    	$res1 = [
		  'code'=> 0,
		  'msg'=> "",
		  'count'=> $num,
		  'data'=> $res
		] ;
    	$res1 = json_encode($res1);
    	echo $res1;
    }
    function getUser(){
    	$page = input('?get.page')?input('get.page'):'';
    	$limit = input('?get.limit')?input('get.limit'):'';
    	$count = ($page-1)*$limit;
    	$res = db('t_user')->limit($limit,$count)->select();
    	$num = db('t_user')->count();
    	$res1 = [
		  'code'=> 0,
		  'msg'=> "",
		  'count'=> $num,
		  'data'=> $res
		] ;
    	$res1 = json_encode($res1);
    	echo $res1;
    }
    function getPower(){
        $res = db('t_menu')->select();
    	$res = json_encode($res);
    	echo $res;
    }
    //删除角色
    function delRole(){
    	$id = input('?post.id')?input('post.id'):'';
       	$where = [
    		'rid' => $id
    	];
    	$res = db('t_role')->where($where)->delete();
  //   	$res = db('t_role')->limit(10,0)->select();
  //   	$num = db('t_role')->count();
  //   	$res1 = [
		//   'code'=> 0,
		//   'msg'=> "",
		//   'count'=> $num,
		//   'data'=> $res
		// ] ;
  //   	$res1 = json_encode($res1);
    	echo $res;
    }
    //锁定用户
    function lockUser(){
    	$id = input('?post.id')?input('post.id'):'';
    	$index = input('?post.index')?input('post.index'):'';
       	$where = [
    		'uid' => $id
    	];
       	$data = [
    		'hsid' => $index
    	];
    	$res = db('t_user')->where($where)->update($data);
    	echo $res;
    }
    //获取单角色权限
    function getOnePower(){
    	$id = input('?post.id')?input('post.id'):'';
       	$where = [
    		'rid' => $id
    	];
    	$res = db('t_refpurview')->where($where)->select();
    	$res = json_encode($res);
    	echo $res;
    }
    function delAdmin(){
    	$eid = input('?post.eid')?input('post.eid'):'';
       	$where = [
    		'eid' => $eid
    	];
    	$res = db('t_employee')->where($where)->delete();
    	echo $res;
    }
    function roleSame(){
    	$name = input('?post.name')?input('post.name'):'';
       	$where = [
    		'rname' => $name
    	];
    	$res = db('t_role')->where($where)->select();
    	if(count($res)>0){
    		$res = 1;
    	}else{
    		$res = 0;
    	}
    	echo $res;
    }
    function addRole(){
    	$rname = input('?post.rname')?input('post.rname'):'';
    	$rintro = input('?post.rintro')?input('post.rintro'):'';
       	$where = [
    		'rname' => $rname,
    		'rintro' => $rintro
    	];
    	$res = db('t_role')->insert($where);
    	echo $res;
    }
    function addUser(){
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
    function addAdmin(){
    	$ename = input('?post.ename')?input('post.ename'):'';
    	$epassword = input('?post.epassword')?input('post.epassword'):'';
    	$rid = input('?post.rid')?input('post.rid'):'';
       	$where = [
    		'ename' => $ename,
    		'epassword' => $epassword,
    		'rid' => $rid
    	];
    	$res = db('t_employee')->insert($where);
    	echo $res;
    }
    function storePower(){
    	$data = input('?post.data')?input('post.data'):'';
    	$data = json_decode($data);
    	//删除原先权限关联
       	$where = [
    		'rid' => $data[0]->rid
    	];
    	$res = db('t_refpurview')->where($where)->delete();
    	//插入新的权限关联
    	$data1 = [];
        for($i = 0; $i < count($data); $i++){
            array_push($data1, [
                'pid' => $data[$i]->pid,
                'rid' => $data[$i]->rid
            ]);
        }
        $result   =  db('t_refpurview')->insertAll($data1);
    	echo $res;
    }
    function editAdmin(){
    	$eid = input('?post.eid')?input('post.eid'):'';
    	$ename = input('?post.ename')?input('post.ename'):'';
    	$rid = input('?post.rid')?input('post.rid'):'';
       	$where = [
    		'eid' => $eid
    	];
       	$data = [
    		'ename' => $ename,
    		'rid' => $rid
    	];
    	$res = db('t_employee')->where($where)->update($data);
    	echo $res;
    }
    function editAdminPsw(){
    	$eid = input('?post.eid')?input('post.eid'):'';
    	$epassword = input('?post.epassword')?input('post.epassword'):'';
       	$where = [
    		'eid' => $eid
    	];
       	$data = [
    		'epassword' => $epassword
    	];
    	$res = db('t_employee')->where($where)->update($data);
    	echo $res;
    }
    function getAdminCount(){
    	$res = db('t_employee')->count();
    	// $res = json_encode($res);
    	echo $res;
    }
}
