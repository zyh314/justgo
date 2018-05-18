<?php
namespace app\backend\controller;
use \think\Controller;
use \think\Db;
use \think\Config;
use \think\Session;
use \think\Redis;
use \think\Cache;

//引用七牛CDN的命名空间
use Qiniu\Auth; //七牛云上传文件头部
use Qiniu\Storage\UploadManager;

//use \think\Cache; //收索缓存

class Goods extends Controller
{
	protected $beforeActionList = [
	        'checkSession' => ['only'=>'deleteitem,creation,myquestionnaire']
	    ];
	
	/*判断session*/
	public function checkSession(){
		$onlineUser = Session::get('onlineUser');
		if(empty($onlineUser)){
    		$this->error('登录过期，请重新登录','index/index/login');
		}
	}
	
	 /*获取商品列表*/
	public function getgoods(){
		$keyword =  input('?get.keyword')?input('get.keyword'):"";
		$page =  input('?get.page')?input('get.page'):"";
		$limit =  input('?get.limit')?input('get.limit'):"";
		if($keyword!=''){
			$count = db('t_goods')->join('t_location','t_location.locateid = t_goods.locateid')->where(['name'=>['like','%'.$keyword.'%']])->whereOr(['locate'=>['like','%'.$keyword.'%']])->count();
			$result = db('t_goods')->join('t_location','t_location.locateid = t_goods.locateid')->where(['name'=>['like','%'.$keyword.'%']])->whereOr(['locate'=>['like','%'.$keyword.'%']])->limit(($page-1)*$limit,$limit)->select();
		}
		else{
			$count = db('t_goods')->count();
			$result = db('t_goods')->join('t_location','t_location.locateid = t_goods.locateid')->limit(($page-1)*$limit,$limit)->select();
		}
		$feedback = [
			'code'=>0,
			'count'=>$count,
			'data'=>$result
		];
		echo json_encode($feedback);
	}
	
	/*显示商品详情*/
	public function goodsdetails(){
		$goodsid =  input('?get.goodsid')?input('get.goodsid'):"";
		$result = db('t_goods')->join('t_location','t_location.locateid = t_goods.locateid')->where('goodsid',$goodsid)->select();
        $this->assign('thedetails',$result);
		return $this->fetch('/goodsdetails');
	}
	
	/*编辑商品*/
	public function edit(){
		$goodsid =  input('?get.goodsid')?input('get.goodsid'):"";
		
		$result = db('t_goods')->join('t_location','t_location.locateid = t_goods.locateid')->where('goodsid',$goodsid)->find();
		$res = db('t_location')->where('fid',0)->select();
		
        $this->assign('location',$res);
        $this->assign('thedetails',$result);
		
		return $this->fetch('/goodsedit');
	}
	
	/*获取编辑商品详情*/
	public function foredit(){
		$goodsid =  input('?post.goodsid')?input('post.goodsid'):"";
		$result = db('t_goods')->join('t_location','t_location.locateid = t_goods.locateid')->where('goodsid',$goodsid)->find();
		echo json_encode($result);
	}
	
	/*提交编辑商品*/
	public function editcomplete(){
		$goodsid = input('?post.goodsid')?input('post.goodsid'):"";
		$origin = db('t_goods')->where('goodsid',$goodsid)->find();
		
		$name =  input('?post.title')?input('post.title'):"";
		$price =  input('?post.price')?input('post.price'):"";
		$quantity =  input('?post.quantity')?input('post.quantity'):"";
		$cities =  input('?post.city')?input('post.city'):"";
		$saleway =  input('?post.saleway')?input('post.saleway'):"";
		$saleprice =  input('?post.saleprice')?input('post.saleprice'):null;
		$limit =  input('?post.limit')?input('post.limit'):null;
		$period =  input('?post.period')?input('post.period'):null;
		$intro =  input('?post.intro')?input('post.intro'):"";
		
		if($cities==""){
			$feedback = [
	    		'code'=>407,
	    		'message'=>Config::get('Message')['LOCATION_ERROR'], 
	    		'data'=>[]
	    	];
		}
		else if($saleway=="秒杀"&&$period==""){
			$feedback = [
	    		'code'=>406,
	    		'message'=>Config::get('Message')['PERIODTIME_ERROR'], 
	    		'data'=>[]
	    	];
		}
		else{
			$res = db('t_goods')->where('goodsid',$goodsid)->update(['name' => $name,'price' => $price,'quantity' => $quantity,'locateid' => $cities,'saleType' =>$saleway,'saleprice' => $saleprice,'salelimit' => $limit,'salePeriod' => $period,'intro' => $intro]);
			if($res){
				$feedback = [
		    		'code'=>203,
		    		'message'=>Config::get('Message')['UPDATE_SUCCESSED'], 
		    		'data'=>$res
		    	];
			}else{
				$feedback = [
		    		'code'=>403,
		    		'message'=>Config::get('Message')['UPDATE_FAILED'], 
		    		'data'=>$res
		    	];
			}
		}
		echo json_encode($feedback);
	}
	
	/*删除商品*/
	public function delete(){
   		$goodsid =  input('?post.id')?input('post.id'):"";
   		$res = db('t_goods')->where('goodsid',$goodsid)->delete();
   		if($res){
   			$feedback = [
	    		'code'=>201,
	    		'message'=>Config::get('Message')['DELETE_SUCCESSED'], 
	    		'data'=>[]
	    	];
   		}else{
   			$feedback = [
	    		'code'=>401,
	    		'message'=>Config::get('Message')['DELETE_FAILED'], 
	    		'data'=>[]
	    	];
   		}
   		echo json_encode($feedback);
   	}
   	
   	/*上下架*/
   	public function shelf(){
   		$goodids = input('?post.data')?input('post.data'):"";
   		$goodids = json_decode($goodids);
   		foreach($goodids as $value){
			if($value->goodstatus=='在售'){
				$res = db('t_goods')->where('goodsid',$value->goodsid)->setField('goodstatus', '未上架');
   			}else{
   				$res = db('t_goods')->where('goodsid',$value->goodsid)->setField('goodstatus', '在售');
   			}
   		}
		/*反馈*/
   		if($res){
   			$feedback = [
	    		'code'=>202,
	    		'message'=>Config::get('Message')['SHELF_SUCCESSED'], 
	    		'data'=>[]
	    	];
   		}else{
   			$feedback = [
	    		'code'=>402,
	    		'message'=>Config::get('Message')['SHELF_FAILED'], 
	    		'data'=>[]
	    	];
   		}
   		echo json_encode($feedback);
   	}
   	
   	/*获取归属地*/
   	public function getcities(){
   		$fid = input('?post.fid')?input('post.fid'):"";
   		$res = db('t_location')->where('fid',$fid)->select();
   		echo json_encode($res);
   	}
   	
   	/*商品上传*/
   	public function uploadgoods(){
   		$file = request()->file('file'); //获取上传文件
		if($file){
			//上传到本地服务器
			$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
			//上传到远程CDN
			$accessKey = 'P5HPpgD5FN3X69wKqWI39EwPLIpVckU_TafwyQ0U';
			$accessSecret = "MJlWWOCFukUEEaYknsfJWO979H88GV9wTgaz1eJI";
			$bucket = 'justgotravel';
			
			$authRes = new Auth($accessKey,$accessSecret);
			$token = $authRes->UploadToken($bucket);
			
			if($token){
				$manager = new UploadManager();
				$localFile = "uploads/".$info->getSaveName();
				$localFileName = $info->getFileName();
				
				$manager->putfile($token,$localFileName,$localFile); //三个参数：token;上传后的文件名称;上传文件的本地路径
			}
			
			if($info){
				/*获得图片路径*/
				/*$image =$info->getSaveName();*/
				$image = "http://p8int7f8g.bkt.clouddn.com/".$info->getFilename();
	            //获取表单数据
	            $saleType = input('?post.sale')?input('post.sale'):"";
		   		$name = input('?post.title')?input('post.title'):"";
		   		$price = input('?post.price')?input('post.price'):"";
		   		$quantity = input('?post.quantity')?input('post.quantity'):"";
		   		$file = input('?post.file')?input('post.file'):"";
		   		$locateid = input('?post.locateid')?input('post.locateid'):"";
		   		$intro = input('?post.intro')?input('post.intro'):"";
		   		$saleprice = input('?post.saleprice')?input('post.saleprice'):'';
		   		$salelimit = input('?post.qtylimit')?input('post.qtylimit'):'';
		   		$salePeriod = input('?post.modules')?input('post.modules'):'';
		   		$goodstatus = input('?post.shelf')?input('post.shelf'):"";
		   		if($goodstatus=="on"){
		   			$goodstatus = "在售";
		   			$cshelftime = date("Y-m-d H:i:s",time());
		   		}else{
		   			$goodstatus = "未上架";
		   			$cshelftime = 'default';
		   		}
		   		/*上传到数据库*/
		   		$res = db('t_goods')->data(['goodsid'=>"default",'quantity'=>$quantity,'soldqty'=>'default','markqty'=>'default','price'=>$price,'goodstatus'=>$goodstatus,'saleType'=>$saleType,'cpubtime'=>date("Y-m-d H:i:s",time()),'cshelftime'=>$cshelftime,'salelimit'=>$salelimit,'saleprice'=>$saleprice,'salePeriod'=>$salePeriod,'name'=>$name,'locateid'=>$locateid,'image'=>$image,'intro'=>$intro])->insert();
		   		/*页面显示*/
		   		if($res){
		   			$this->success('上传成功', 'backend/index/fabu');
		   		}else{
		   			$this->error('上传失败', 'backend/index/fabu');
		   		}
			}
			else{
	            // 上传失败获取错误信息
	            /*echo $file->getError();*/
	            $this->error('上传失败', 'backend/index/fabu');
        	}
		}
   	}
   	
   	/*获取未支付订单列表*/
	public function getpending(){
		$page =  input('?get.page')?input('get.page'):"";
		$limit =  input('?get.limit')?input('get.limit'):"";
		$count = db('t_orders')->where('orderStatus',2)->count();
		$result = db('t_orders')->join('t_orderStatus','t_orderStatus.orderStatus = t_orders.orderStatus')->join('t_goods','t_goods.goodsid = t_orders.goodsid')->join('t_user','t_user.userid = t_orders.userid')->where('t_orderStatus.orderStatus',1)->limit(($page-1)*$limit,$limit)->select();
		$feedback = [
			  'code'=>0,
			  'msg'=>"",
			  'count'=>$count,
			  'data'=>$result
			];
		echo json_encode($feedback);
	}
	
	/*获取全部未付款订单列表*/
	public function allunpaid(){
		$page =  input('?get.page')?input('get.page'):"";
		$limit =  input('?get.limit')?input('get.limit'):"";
		$count = db('t_orders')->where('orderStatus=1 OR orderStatus=5')->count();
		$result = db('t_orders')->join('t_orderStatus','t_orderStatus.orderStatus = t_orders.orderStatus')->join('t_goods','t_goods.goodsid = t_orders.goodsid')->join('t_user','t_user.userid = t_orders.userid')->where('t_orderStatus.orderStatus=1 OR t_orderStatus.orderStatus=5')->limit(($page-1)*$limit,$limit)->select();
		$feedback = [
			  'code'=>0,
			  'msg'=>"",
			  'count'=>$count,
			  'data'=>$result
			];
		echo json_encode($feedback);
	}
	
	/*获取已支付订单列表*/
	public function getpaid(){
		$page =  input('?get.page')?input('get.page'):"";
		$limit =  input('?get.limit')?input('get.limit'):"";
		$count = db('t_orders')->where('orderStatus',2)->count();
		$result = db('t_orders')->join('t_orderStatus','t_orderStatus.orderStatus = t_orders.orderStatus')->join('t_user','t_user.userid = t_orders.userid')->join('t_goods','t_goods.goodsid = t_orders.goodsid')->where('t_orderStatus.orderStatus',2)->limit(($page-1)*$limit,$limit)->select();
		$feedback = [
			  'code'=>0,
			  'msg'=>"",
			  'count'=>$count,
			  'data'=>$result
			];
		echo json_encode($feedback);
	}
	
	/*全部已支付订单*/
	public function getallpaid(){
		$page =  input('?get.page')?input('get.page'):"";
		$limit =  input('?get.limit')?input('get.limit'):"";
		$count = db('t_orders')->where('orderStatus=2 OR orderStatus=3 OR orderStatus=4')->count();
		$result = db('t_orders')->join('t_orderStatus','t_orderStatus.orderStatus = t_orders.orderStatus')->join('t_user','t_user.userid = t_orders.userid')->join('t_goods','t_goods.goodsid = t_orders.goodsid')->where('t_orderStatus.orderStatus=2 OR t_orderStatus.orderStatus=3 OR t_orderStatus.orderStatus=4')->limit(($page-1)*$limit,$limit)->select();
		$feedback = [
			  'code'=>0,
			  'msg'=>"",
			  'count'=>$count,
			  'data'=>$result
			];
		echo json_encode($feedback);
	}
	
	/*取消订单*/
	public function ordercancel(){
   		$orderid = input('?post.orderid')?input('post.orderid'):"";
		$res = db('t_orders')->where('orderid',$orderid)->setField('orderStatus', 5);
		/*反馈*/
   		if($res){
   			$feedback = [
	    		'code'=>209,
	    		'message'=>Config::get('Message')['CANCEL_SUCCESSED'], 
	    		'data'=>[]
	    	];
   		}else{
   			$feedback = [
	    		'code'=>409,
	    		'message'=>Config::get('Message')['CANCEL_FAILED'], 
	    		'data'=>[]
	    	];
   		}
   		echo json_encode($feedback);
   	}
   	
	/*批量关闭交易*/
	public function plentyclose(){
   		$orders = input('?post.data')?input('post.data'):"";
   		$orders = json_decode($orders);
   		foreach($orders as $value){
			$res = db('t_orders')->where('orderid',$value->orderid)->setField('orderStatus', 5);
   		}
		/*反馈*/
   		if($res){
   			$feedback = [
	    		'code'=>209,
	    		'message'=>Config::get('Message')['CANCEL_SUCCESSED'], 
	    		'data'=>[]
	    	];
   		}else{
   			$feedback = [
	    		'code'=>409,
	    		'message'=>Config::get('Message')['CANCEL_FAILED'], 
	    		'data'=>[]
	    	];
   		}
   		echo json_encode($feedback);
   	}
	
	/*显示订单详情*/
	public function orderdetails(){
		$orderid =  input('?get.orderid')?input('get.orderid'):"";
		$result = db('t_orders')->join('t_user','t_user.userid = t_orders.userid')->join('t_goods','t_goods.goodsid = t_orders.goodsid')->join('t_orderStatus','t_orderStatus.orderStatus = t_orders.orderStatus')->where('t_orders.orderid',$orderid)->select();
        $this->assign('orderdetails',$result);
		return $this->fetch('/orderdetails');
	}
	
	/*发货*/
	public function sendgoods(){
   		$orderid = input('?post.orderid')?input('post.orderid'):"";
		$res = db('t_orders')->where('orderid',$orderid)->setField('orderStatus', 3);
		/*反馈*/
   		if($res){
   			$feedback = [
	    		'code'=>208,
	    		'message'=>Config::get('Message')['SENTGOODS_SUCCESSED'], 
	    		'data'=>[]
	    	];
   		}else{
   			$feedback = [
	    		'code'=>408,
	    		'message'=>Config::get('Message')['SENTGOODS_FAILED'], 
	    		'data'=>[]
	    	];
   		}
   		echo json_encode($feedback);
   	}
	
	
	
}

