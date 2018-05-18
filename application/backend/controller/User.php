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
        $res = db('t_employee a')->join('t_role b','a.roleid = b.roleid')->limit($count,5)->select();
        // $this->assign('res0',$res);
        $res = json_encode($res);
        echo $res;
        // return $this->fetch('/user');
    }
    function chkPsw(){
        $employeeid = input('?post.employeeid')?input('post.employeeid'):'';
        $password = input('?post.password')?input('post.password'):'';
        $where = [
            'employeeid' => $employeeid,
            'password' => $password
        ];
        $res = db('t_employee')->where($where)->find();
        // $this->assign('res0',$res);
        $res = json_encode($res);
        echo $res;
        // return $this->fetch('/user');
    }
    function getAdminOne(){
        $employeeid = input('?post.employeeid')?input('post.employeeid'):'';
        $where = [
            'employeeid' => $employeeid
        ];
        $res = db('t_employee a')->join('t_role b','a.roleid = b.roleid')->where($where)->find();
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
            'roleid' => $id
        ];
        $res = db('t_role')->where($where)->delete();
        echo $res;
    }
    //锁定用户
    function lockUser(){
        $id = input('?post.id')?input('post.id'):'';
        $index = input('?post.index')?input('post.index'):'';
        $where = [
            'userid' => $id
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
            'roleid' => $id
        ];
        $res = db('t_refpower')->where($where)->select();
        $res = json_encode($res);
        echo $res;
    }
    function delAdmin(){
        $employeeid = input('?post.employeeid')?input('post.employeeid'):'';
        $where = [
            'employeeid' => $employeeid
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
            'nickname' => $uname,
            'uemail' => $uemail,
            'upassword' => $upassword,
            'ugender' => $ugender,
            'uphoneNo' => $uphoneNo
        ];
        $res = db('t_user')->insert($where);
        echo $res;
    }
    function addAdmin(){
        $account = input('?post.account')?input('post.account'):'';
        $name = input('?post.name')?input('post.name'):'';
        $password = input('?post.password')?input('post.password'):'';
        $roleid = input('?post.roleid')?input('post.roleid'):'';
        $locking = input('?post.locking')?input('post.locking'):'';
        $where0 = [
            'account' => $account
        ];
        $res0 = db('t_employee')->where($where0)->select();
        if(count($res0)>0){
            echo json_encode('accountSame');
            return;
        }
        $where = [
            'account' => $account,
            'name' => $name,
            'password' => $password,
            'roleid' => $roleid,
            'locking' => $locking
        ];
        $res = db('t_employee')->insert($where);
        echo json_encode($res);
    }
    function userNameSame(){
        $uname = input('?post.uname')?input('post.uname'):'';
        $where0 = [
            'uname' => $uname
        ];
        $res0 = db('t_user')->where($where0)->select();
        if(count($res0)>0){
            echo json_encode('true');
        }else{
            echo json_encode('false');
        }
    }
    function storePower(){
        $data = input('?post.data')?input('post.data'):'';
        $data = json_decode($data);
        //删除原先权限关联
        $where = [
            'roleid' => $data[0]->roleid
        ];
        $res = db('t_refpower')->where($where)->delete();
        //插入新的权限关联
        $data1 = [];
        for($i = 0; $i < count($data); $i++){
            array_push($data1, [
                'pid' => $data[$i]->pid,
                'roleid' => $data[$i]->roleid
            ]);
        }
        $result   =  db('t_refpower')->insertAll($data1);
        echo $res;
    }
    function editAdmin(){
        $employeeid = input('?post.employeeid')?input('post.employeeid'):'';
        $name = input('?post.name')?input('post.name'):'';
        $roleid = input('?post.roleid')?input('post.roleid'):'';
        $where = [
            'employeeid' => $employeeid
        ];
        $data = [
            'name' => $name,
            'roleid' => $roleid
        ];
        $res = db('t_employee')->where($where)->update($data);
        echo $res;
    }
    //修改用户信息
    function editUserInfo(){
        $userid = input('?post.userid')?input('post.userid'):'';
        $key = input('?post.key')?input('post.key'):'';
        $value = input('?post.value')?input('post.value'):'';
        $where = [
            'userid' => $userid
        ];
        $data = [
            $key => $value
        ];
        $res = db('t_user')->where($where)->update($data);
        echo $res;
    }
    function useAdmin(){
        $data = input('?post.data')?input('post.data'):'';
        $data = json_decode($data);
        foreach ($data as $key => $value) {
            echo json_encode($value->chk);
            if($value->chk == 'true'){
                $where = [
                    'employeeid' => $value->employeeid
                ];
                $data0 = [
                    'locking' => '使用'
                ];
                $res = db('t_employee')->where($where)->update($data0);
            }
        }
    }
    function lockAdmin(){
        $data = input('?post.data')?input('post.data'):'';
        $data = json_decode($data);
        foreach ($data as $key => $value) {
            echo json_encode($value->chk);
            if($value->chk == 'true'){
                $where = [
                    'employeeid' => $value->employeeid
                ];
                $data0 = [
                    'locking' => '锁定'
                ];
                $res = db('t_employee')->where($where)->update($data0);
            }
        }
    }
    function editAdminPsw(){
        $eid = input('?post.eid')?input('post.eid'):'';
        $epassword = input('?post.epassword')?input('post.epassword'):'';
        $where = [
            'employeeid' => $eid
        ];
        $data = [
            'password' => $epassword
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
