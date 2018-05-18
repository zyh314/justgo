<?php
namespace app\index\controller;
use \think\Controller;
use \think\Db;
use \think\Config;
use \think\Session;
use \think\Redis;
//引用七牛CDN的命名空间
use Qiniu\Auth; //七牛云上传文件头部
use Qiniu\Storage\UploadManager;
//前端前端管理

class Travels extends Controller
{
	protected $beforeActionList = [
		'checkSession' => ['except' => 'del,user']
	];
	public function checkSession(){
		return '进行验证';
	}


    //接收头图，返回给隐藏的input
    public function uploadHeadPic(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
//        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
//        if($info){
////            $path =  $info->getExtension(); //获取文件后缀
////            $file = $info->getFilename(); //文件名
////            $path1 = $info->getPath(); //D:\\wamp\\www\\justgo\\public\\uploads\\20180508
////            return json(array('state'=>1,'path'=>$path1));
//            // 成功上传后 返回上传信息
//            $path = $info->getSaveName();
//            $uploadPath = "/justgo/public/uploads/".$path;
//            echo json_encode(array('state'=>1,'path'=>$uploadPath));
//        }else{
//            // 上传失败返回错误信息
//            echo json_encode(array('state'=>0,'errmsg'=>$file->getError()));
//            //return json(array('state'=>0,'errmsg'=>'上传失败'));
//        }

        if ($file){
            //上传到本地服务器
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            //上传到远程CDN
            $accessKey = 'P5HPpgD5FN3X69wKqWI39EwPLIpVckU_TafwyQ0U';
            $accessSecret = "MJlWWOCFukUEEaYknsfJWO979H88GV9wTgaz1eJI";
            $bucket = 'justgotravel';

            $authRes = new Auth($accessKey, $accessSecret);
            $token = $authRes->UploadToken($bucket);

            if ($token) {
                $manager = new UploadManager();
                $localFile = "uploads/" . $info->getSaveName();
                $localFileName = $info->getFileName();

                $manager->putfile($token, $localFileName, $localFile); //三个参数：token;上传后的文件名称;上传文件的本地路径
            }
            if ($info) {
                /*获得图片路径*/
                /*$image =$info->getSaveName();*/
                $image = "http://p8int7f8g.bkt.clouddn.com/" . $info->getFilename();
                echo json_encode(array('state'=>1,'path'=>$image));

            }else{
                echo json_encode(array('state'=>0,'errmsg'=>$file->getError()));
            }

        }
    }

    //游记插入数据库
    public function uploadTravels(){
	    $userid = Session::get("user_id");//登录用户ID
        $title = input('?post.title')?input('post.title'):"";//标题
        $content = input('?post.content')?input('post.content'):"";//内容
        $path = input('?post.path')?input('post.path'):"";//头图
        $time = date("Y-m-d H:i:s");//发表游记时间
        $startTime = input('?post.startTime')?input('post.startTime'):"";//出发时间
        $destination = input('?post.destination')?input('post.destination'):"";//目的地
        $days = input('?post.days')&&input('post.days')!=""?input('post.days'):0;//天数
        $cost = input('?post.cost')&&input('post.cost')!=""?input('post.cost'):0;//人均花费

        //$data = ['title'=>$title,'image'=>$path,'userid'=>$userid,'content'=>$content,'time'=>$time,'state'=>'下架','departure'=>$startTime,'character'=>$member];
        //$res = db('t_travels')->insert($data);
        if ($startTime==""){
            $res = db('t_travels')->data(['title'=>$title,'image'=>$path,'userid'=>$userid,'content'=>$content,'time'=>$time,'state'=>'下架','ding'=>0,'days'=>$days,'destination'=>$destination,'percapita'=>$cost])->insert();
        }else{
            $res = db('t_travels')->data(['title'=>$title,'image'=>$path,'userid'=>$userid,'content'=>$content,'time'=>$time,'state'=>'下架','ding'=>0,'departure'=>$startTime,'days'=>$days,'destination'=>$destination,'percapita'=>$cost])->insert();
        }

        if ($res){
            $response = [
                'code' => 204,
                'message'=>Config::get('Message')['UPLOAD_SUCCESSED'],
                'data'=>[]
            ];
            echo json_encode($response);
        }else{
            $response = [
                'code' => 404,
                'message'=>Config::get('Message')['UPLOAD_FAILED'],
                'data'=>[]
            ];
            echo json_encode($response);
        }

        //echo json_encode($startTime);
    }


    //富文本框插入图片
    public function uploadContent()
    {
        //获取上传图片
        $file = request()->file('yourFileName');
        //上传到本地服务器
//        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
//        $path = $info->getSaveName();
//        $uploadPath = "/justgo/public/uploads/".$path;
        if ($file){
            //上传到本地服务器
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            //上传到远程CDN
            $accessKey = 'P5HPpgD5FN3X69wKqWI39EwPLIpVckU_TafwyQ0U';
            $accessSecret = "MJlWWOCFukUEEaYknsfJWO979H88GV9wTgaz1eJI";
            $bucket = 'justgotravel';

            $authRes = new Auth($accessKey, $accessSecret);
            $token = $authRes->UploadToken($bucket);

            if ($token) {
                $manager = new UploadManager();
                $localFile = "uploads/" . $info->getSaveName();
                $localFileName = $info->getFileName();

                $manager->putfile($token, $localFileName, $localFile); //三个参数：token;上传后的文件名称;上传文件的本地路径
            }
            if ($info) {
                /*获得图片路径*/
                /*$image =$info->getSaveName();*/
                $image = "http://p8int7f8g.bkt.clouddn.com/" . $info->getFilename();
                $response = [
                    'errno' => 0,
                    'message'=>Config::get('Message')['UPLOAD_SUCCESSED'],
                    'data'=>['path'=>$image]
                ];
                echo json_encode($response);

            }else{
                $response = [
                    'errno' => 1,
                    'message'=>Config::get('Message')['UPLOAD_FAILED'],

                ];
                 echo json_encode($response);
            }

        }

    }


    //游记-顶 redis
    public function ding()
    {
        $userid = Session::get('user_id');
        $travelsid = input('?post.travelsid')?input('post.travelsid'):"";
        $redis = new \Redis();
        //本地连接127.0.0.1 6379是redis的端口
        $con = $redis -> connect('127.0.0.1',6379);
        if ($con){
            //$redis->delete($travelsid);
            //查看redis是否有记录 hash结构get返回true和false
            $res = $redis->hGet($travelsid,$userid);
            if($res==false){
                //key=>游记id ,hashKey=>用户ID ,value=>用户ID
                $redis->hSet($travelsid,$userid,$userid);
                $countDing = $redis->hLen($travelsid);
                $this->assign('ding',$countDing);
                $response = [
                    'code' => 205,
                    'message'=>Config::get('Message')['DING_SUCCESSED'],
                    'data'=>['countDing'=>$countDing]
                ];
                echo json_encode($response);
            }else{
                $response = [
                    'code' => 405,
                    'message'=>Config::get('Message')['DING_FAILED'],
                    'data'=>[]
                ];
                echo json_encode($response);
            }

        }

    }

    //linux服务器隔多长时间将redis的顶数据全部写入数据库
    public function saveDing()
    {

    }

    //获取评论分页数据
    public function comPage(){
        $curr = input('?post.curr')?input('post.curr'):"";
        $travelsid = input('?post.travelsid')?input('post.travelsid'):"";
        $limit = input('?post.limit')?input('post.limit'):"";

        $where = [
            'travelsid' => $travelsid
        ];
        //TP分页不支持异步，paginate(2,false,['query' => ['id' => $id]])
        //该篇游记的评论
        $com = db('t_travelcomments')
            ->join('t_user','t_user.userid = t_travelcomments.userid')
            ->field('t_user.uname,t_user.uIcon,t_user.uintegral,t_travelcomments.*')
            ->order('commentsid desc')
            ->where($where)
            ->limit($curr-1,$limit)
            ->select();

        //$this->assign('com',$com);
        echo json_encode($com);
       // return $this->fetch('/showTravels');
    }

    //获取游记评论总数
    public function getCountPage()
    {
        $travelsid = input('?post.travelsid')?input('post.travelsid'):"";

        $where = [
            'travelsid' => $travelsid
        ];
        //游记评论数量
        $countCom = db('t_travelcomments')->where($where)->count();
        echo json_encode($countCom);
    }

    //添加评论
    public function addCom(){
	    $userid = Session::get("user_id");
	    if ($userid){
            $travelsid = input('?post.travelsid')?input('post.travelsid'):"";//游记ID
            $content = input('?post.content')?input('post.content'):"";//内容
            $time = date("Y-m-d H:i:s");//发表评论时间
            $res = db('t_travelcomments')->data(['userid'=>$userid,'content'=>$content,'travelsid'=>$travelsid,'time'=>$time])->insert();
            if ($res){
                $response = [
                    'code' => 207,
                    'message' => Config::get('Message')['PINGLUN_SUCCESSED']
                ];
                echo json_encode($response);
            }else{
                $response = [
                    'code' => 407,
                    'message' => Config::get('Message')['PINGLUN_FAILED']
                ];
                echo json_encode($response);
            }
        }else{
	        $response = [
	            'code' => 406,
                'message' => Config::get('Message')['NO_LOGIN']
            ];
	        echo json_encode($response);
        }

    }

    public function countTravel(){
        $limit = input('?post.limit')?input('post.limit'):"";//一页几条
        $curPage = input('?post.page')?input('post.page'):"";//当前页
	    $count = db("t_travels")->count();//总共有几篇游记
	    $pages = ceil($count/$limit);//总共有几页
        $data = db('t_travels')->limit(($curPage-1)*$limit,$limit)->select();//查询游记数据
        //定义空数组装游记点赞数量
        $dingArr = array();
        //点赞数量根据travelsid从redis获取
        foreach ($data as $key=>$value){
            $travelsid = $value['travelsid'];
            $redis = new \Redis();
            //本地连接127.0.0.1 6379是redis的端口
            $con = $redis -> connect('127.0.0.1',6379);
            if ($con){
                $countDing = $redis->hLen($travelsid);
                array_push($dingArr,$countDing);
            }
        }

        $response = ['pages'=>$pages,'data'=>$data,'dingArr'=>$dingArr];
	    echo json_encode($response);
    }




    public function index()
    {
        return $this->fetch('/travels');
    }
}
