<?php
namespace app\xcx\controller;
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
    //微信登录成功后，储存用户
    function wxUserAdd(){
        $data = input('?post.data')?input('post.data'):'';
        $data = json_decode($data);
        $wxopenid = $data->openId;
        $nickName = $data->nickName;
        $msg = [
            'result' => 'unexist',
            'data' => ''
        ];
        //判断用户是否已存在
        $where = [
            'wxopenid' => $wxopenid
        ];
        $res = db('t_user')->where($where)->find();
        if($res){
            $data = [
                'result' => 'exist',
                'data' => $res
            ];
            echo json_encode($data);
            return;
        }
        //如果不存在，insert新用户，并返回新用户数据
        if($data->gender == 1){
            $gender = '男';
        }else{
            $gender = '女';
        }
       	$where = [
    		'wxopenid' => $wxopenid,
    		'nickname' => $nickName,
    		'ugender' => $gender
    	];
    	$id = db('t_user')->insertGetId($where);
        $where = [
            'userid' => $id
        ];
        $res = db('t_user')->where($where)->find();
        session("user_id", $res['userid']);
        session("onlineUser", $res);
        unset($res['upassword']);
        $msg['data']=$res;
    	echo json_encode($msg);
    }
//正常登陆

    function login(){
        $account =  input('?post.account')?input('post.account'):"";
        $password =  input('?post.password')?input('post.password'):"";
        $where = [
            'uname' => $account,
            'upassword' => $password
        ];
        $msg = [
            'result' => false,
            'data' => null
        ];
        $res = db('t_user')->where($where)->find();
        unset($res['upassword']);
        if ($res) {
            $time=3600*24*7;
            // cookie('user_id',$res['userid'],$time);
            session("user_id", $res['userid']);
            session("onlineUser", $res);
            $msg['result'] = true;
            $msg['data'] = $res;
            echo json_encode($msg);
            // return $this->fetch('/index');
        }else{
            $msg->result = false;
            echo json_encode($msg);
        }
    }
    function loginNormal(){
        return 'loginNormal';
    }
    //微信登录
    function wxLogin(){
        include "WXBizDataCrypt.php";
        $code =  input('?post.code')?input('post.code'):"";
        $iv =  input('?post.iv')?input('post.iv'):"";
        $encryptedData =  input('?post.encryptedData')?input('post.encryptedData'):"";
        $post=file_get_contents('php://input');
        $post=json_decode($post,true);
        $appid = 'wx1ffa0882ceeccc57';
        $secret='1874f844ae8ef8b92d3ade490371bcbb';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_URL, 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.
            '&js_code='.$code.'&grant_type=authorization_code');
        $data = curl_exec($curl);
        curl_close($curl);
        $response_data = '';
        $session_key = json_decode($data)->session_key;
        $wxBizDataCrypt = new WXBizDataCrypt($appid, $session_key);
        $errCode=$wxBizDataCrypt->decryptData($encryptedData, $iv, $response_data);
        echo json_encode($response_data);
    }


    function getUserOne(){
        $userid = Session::get('user_id');
       	$where = [
    		'userid' => $userid
    	];
    	$res = db('t_user')->where($where)->find();
    	// $this->assign('res0',$res);
    	$res = json_encode($res);
    	echo $res;
        // return $this->fetch('/user');
    }
    function editUser(){
        $userid = Session::get('user_id');
    	// $userid = input('?post.userid')?input('post.userid'):'';
    	$nickname = input('?post.nickname')?input('post.nickname'):'';
    	$uphoneNo = input('?post.uphoneNo')?input('post.uphoneNo'):'';
    	$uemail = input('?post.uemail')?input('post.uemail'):'';
       	$where = [
    		'userid' => $userid
    	];
       	$data = [
    		'nickname' => $nickname,
    		'uphoneNo' => $uphoneNo,
    		'uemail' => $uemail
    	];
    	$res = db('t_user')->where($where)->update($data);
    	echo $res;
    }
    function editUserPsw(){
        $userid = Session::get('user_id');
    	// $userid = input('?post.userid')?input('post.userid'):'';
    	$upassword = input('?post.upassword')?input('post.upassword'):'';
       	$where = [
    		'userid' => $userid
    	];
       	$data = [
    		'upassword' => $upassword
    	];
    	$res = db('t_user')->where($where)->update($data);
    	echo $res;
    }
    function editUserMoney(){
        $userid = Session::get('user_id');
    	$money = input('?post.money')?input('post.money'):'';
       	$where = [
    		'userid' => $userid
    	];
       	$data = [
    		'umoney' => $money
    	];
    	$res = db('t_user')->where($where)->setInc('umoney',$money);
    	echo $res;
    }

    //重名检测
    function unameSame(){
        $uname = input('?post.uname')?input('post.uname'):'';
        $where = [
            'uname' => $uname
        ];
        $res = db('t_user')->where($where)->select();
        $ret = 'false';
        if(count($res)>0){
            $ret = 'true';
        }
        echo $ret;
    }
    //完善信息
    function addInfo(){
        $userid = input('?post.userid')?input('post.userid'):'';
        $uname = input('?post.uname')?input('post.uname'):'';
        $upassword = input('?post.upassword')?input('post.upassword'):'';
        $ugender = input('?post.ugender')?input('post.ugender'):'';
        $uemail = input('?post.uemail')?input('post.uemail'):'';
        $uphoneNo = input('?post.uphoneNo')?input('post.uphoneNo'):'';
        $where = [
            'userid' => $userid
        ];
        $data = [
            'uname' => $uname,
            'uemail' => $uemail,
            'upassword' => $upassword,
            'ugender' => $ugender,
            'uphoneNo' => $uphoneNo
        ];
        $res = db('t_user')->where($where)->update($data);
        echo json_encode($res);
    }
}
