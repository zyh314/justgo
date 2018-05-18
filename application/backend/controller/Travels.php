<?php
namespace app\backend\controller;
use \think\Controller;
use \think\Db;
use \think\Config;
use \think\Session;
use \think\Redis;
<<<<<<< HEAD
//后端游记管理
=======

>>>>>>> 7295d01f57da9a80ec538b34fc09136edce62711
class Travels extends Controller
{
	protected $beforeActionList = [
		'checkSession' => ['except' => 'del,user']
	];
	public function checkSession(){
		return '进行验证';
	}
<<<<<<< HEAD
    //后台显示评论
    public function showComment()
    {
        $page = input('?get.page')?input('get.page'):"";
        $limit = input('?get.limit')?input('get.limit'):"";
        $count = db('t_travelcomments')->count();
        $res = db('t_travelcomments')
            ->join('t_travels','t_travels.travelsid =t_travelcomments.travelsid ')
            ->field('t_travelcomments.*,t_travels.title')
            ->order('commentsid desc')
            ->limit(($page-1)*$limit,$limit)
            ->select();
        $response = [
            'code'=>0,
            'count'=>$count,
            'msg'=>"",
            'data'=>$res
        ];
        echo json_encode($response);
    }

    //后台删除评论
    public function delComment()
    {
        $commentsid = input('?post.commentsid')?input('post.commentsid'):"";
        $where = [
            'commentsid' => $commentsid
        ];
        $res = db('t_travelcomments')->where($where)->delete();
        if ($res){
            $response = [
                'code' => 201,
                'message'=>Config::get('Message')['DELETE_SUCCESSED'],
                'data'=>[]
            ];
            echo json_encode($response);
        }else{
            $response = [
                'code' => 401,
                'message'=>Config::get('Message')['DELETE_FAILED'],
                'data'=>[]
            ];
            echo json_encode($response);
        }
    }
    //批量删除评论
    public function delCommentMore(){
	    $delMore = json_decode(input('?post.delMore')?input('post.delMore'):"");
	    foreach ($delMore as $value){
            $commentsid = $value->commentsid;
            $where = [
                'commentsid' => $commentsid
            ];
            $res = db('t_travelcomments')->where($where)->delete();
        }
        if ($res){
            $response = [
                'code' => 201,
                'message'=>Config::get('Message')['DELETE_SUCCESSED'],
                'data'=>[]
            ];
            echo json_encode($response);
        }else{
            $response = [
                'code' => 401,
                'message'=>Config::get('Message')['DELETE_FAILED'],
                'data'=>[]
            ];
            echo json_encode($response);
        }
    }
    //后台显示游记
    public function showTravel()
    {
        $page = input('?get.page')?input('get.page'):"";
        $limit = input('?get.limit')?input('get.limit'):"";
        $count = db('t_travels')->count();
        $value=input('?get.value')?input('get.value'):'';
        if($value=='')
        {
            $where=[];
        }
        else{
            $where = [
                'travelsid|title|username' => ['like','%'.$value.'%']
            ];
        }

        $res = db('t_travels')->join('t_user','t_user.userid = t_travels.userid')->field('t_user.uname,t_travels.*')->order('travelsid desc')->where($where)->limit(($page-1)*$limit,$limit)->select();
        $response = [
            'code'=>0,
            'count'=>$count,
            'msg'=>"",
            'data'=>$res
        ];
        echo json_encode($response);
    }
    //后台删除游记
    public function delTravel()
    {
        $travelsid = input('?post.travelsid')?input('post.travelsid'):"";
        $where = [
            'travelsid' => $travelsid
        ];
        $res = db('t_travels')->where($where)->delete();
        if ($res){
            $response = [
                'code' => 201,
                'message'=>Config::get('Message')['DELETE_SUCCESSED'],
                'data'=>[]
            ];
            echo json_encode($response);
        }else{
            $response = [
                'code' => 401,
                'message'=>Config::get('Message')['DELETE_FAILED'],
                'data'=>[]
            ];
            echo json_encode($response);
        }
    }
    //批量删除游记
    public function delTravelMore(){
        $delMore = json_decode(input('?post.delMore')?input('post.delMore'):"");
        foreach ($delMore as $value){
            $travelsid = $value->travelsid;
            $where = [
                'travelsid' => $travelsid
            ];
            $res = db('t_travels')->where($where)->delete();
        }
        if ($res){
            $response = [
                'code' => 201,
                'message'=>Config::get('Message')['DELETE_SUCCESSED'],
                'data'=>[]
            ];
            echo json_encode($response);
        }else{
            $response = [
                'code' => 401,
                'message'=>Config::get('Message')['DELETE_FAILED'],
                'data'=>[]
            ];
            echo json_encode($response);
        }
    }
    //批量更改游记状态
    public function changeTravelState(){
        $changeState = json_decode(input('?post.changeState')?input('post.changeState'):"");
        foreach ($changeState as $value){
            $state = $value->state;
            $travelsid = $value->travelsid;
            $where = [
                'travelsid' => $travelsid
            ];
            if ($state=='上架'){
                $res = db('t_travels')->where($where)->update(['state' => '下架']);
            }else{
                $res = db('t_travels')->where($where)->update(['state' => '上架']);
            }

        }
        if ($res){
            $response = [
                'code' => 203,
                'message'=>Config::get('Message')['STATE_SUCCESSED'],
                'data'=>[]
            ];
            echo json_encode($response);
        }else{
            $response = [
                'code' => 403,
                'message'=>Config::get('Message')['STATE_FAILED'],
                'data'=>[]
            ];
            echo json_encode($response);
        }
    }




=======
>>>>>>> 7295d01f57da9a80ec538b34fc09136edce62711
}
