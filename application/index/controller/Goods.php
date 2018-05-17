<?php
namespace app\index\controller;
use \think\Controller;
use \think\Db;
use \think\Config;
use \think\Session;
use \think\Redis;

class Goods extends Controller
{
	protected $beforeActionList = [
		'checkSession' => ['except' => 'del,user']
	];
	function checkSession(){
		return '进行验证';
	}
    public function index()
    {
        return $this->fetch('/index');
    }
    public function backend()
    {
        return $this->fetch('/backend');
    }
    public function login()
    {
        return $this->fetch('/login');
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
    
    /*旅行商城*/
    public function travelmall(){
    	$province = db('t_location')->where('locateid','IN',function($query){
    	    $query->table('t_goods')->field('locateid')->group('locateid');
    	})->select();
    	
    	/*热销*/
    	$sellgoods = db('t_goods')->where(['goodstatus'=>'在售','saleType'=>'普购'])->order('soldqty desc')->limit(0,4)->select();
    	
    	/*新品*/
    	$newgoods = db('t_goods')->where(['goodstatus'=>'在售','saleType'=>'普购'])->order('cpubtime desc')->limit(0,4)->select();
    	/*人气*/
    	$popular = db('t_goods')->where('goodsid','IN',function($query){
    		$query->table('t_goodsMark')->field('goodsid')->group('goodsid')->order('count(goodsid) desc');
    	})->limit(0,4)->select();
    	
    	$this->assign('sellgoods',$sellgoods);
    	$this->assign('province',$province);
    	$this->assign('newgoods',$newgoods);
    	$this->assign('popular',$popular);
    	
    	return $this->fetch('/travelmall');
    }
    
    /*商品详情*/
    public function traveldetails(){
    	$goodsid = input('?get.goodsid')?input('get.goodsid'):'';
    	$goodsdetail = db('t_goods')->join('t_location b','t_goods.locateid=b.locateid')->where('goodsid',$goodsid)->find();
    	
    	$this->assign('goodsdetail',$goodsdetail);
    	return $this->fetch('/traveldetails');
    }
    
    /*获取评论分页总条数*/
	public function getcounts(){
 		$goodsid = input('?get.goodsid')?input('get.goodsid'):'';
   		$count = db('t_goodscomments')->where('goodsid',$goodsid)->count();
   		echo json_encode($count);
	}
   
   /*评论翻页*/
	public function pageTurning(){
	  	$goodsid = input('?post.goodsid')?input('post.goodsid'):'';
	  	$nowpage = input('?post.nowpage')?input('post.nowpage'):'';
	  	$limit = input('?post.limit')?input('post.limit'):'';
  	
  		$goodscomments = db('t_goodscomments')->join('t_user','t_user.userid = t_goodscomments.userid')->where('goodsid',$goodsid)->limit(($nowpage-1)*$limit,$limit)->select();
  		echo json_encode($goodscomments);
	}
    
    /*商品选择*/
    public function travelgoods(){
    	$keyword = input('?get.keyword')?input('get.keyword'):'';
    	$key = input('?get.key')?input('get.key'):'';
    	
    	if($keyword || $key){
    		if($keyword){
    			
    			
    		}else{
    			if($key=='moreSell'){
    				$travelgoods = db('t_goods')->where(['goodstatus'=>'在售','saleType'=>'普购'])->order('soldqty desc')->paginate(10,false,['query' => ['key' => $key]]);
    			}
    			else if($key == 'moreNew'){
    				$travelgoods = db('t_goods')->where(['goodstatus'=>'在售','saleType'=>'普购'])->order('cpubtime desc')->paginate(10,false,['query' => ['key' => $key]]);
    			}
    			else{
    				$travelgoods = db('t_goods')->where('goodsid','IN',function($query){
			    		$query->table('t_goodsMark')->field('goodsid')->group('goodsid')->order('count(goodsid) desc');
			    	})->paginate(10,false,['query' => ['key' => $key]]);
    			}
    		}
    	}else{
    		$travelgoods = db('t_goods')->where(['goodstatus'=>'在售','saleType'=>'普购'])->paginate(10);
    	}
    	$page = $travelgoods->render();
    	$bestSold = db('t_goods')->where(['goodstatus'=>'在售','saleType'=>'普购'])->order('soldqty desc')->limit(0,5)->select();
    	
    	$this->assign('page',$page);
    	$this->assign('travelgoods',$travelgoods);
    	$this->assign('bestSold',$bestSold);
    	return $this->fetch('/travelgoods');
    }
    
    
    /*跳转支付页面*/
    public function travelpay(){
    	return $this->fetch('/travelpay');
    }
    
    /*加入购物车*/
    public function add2cart(){
    	$goodsid = input('?post.goodsid')?input('post.goodsid'):'';
    	$quantity = input('?post.quantity')?input('post.quantity'):'';
    	$userid = Session::get('onlineUser')['userid'];
		
		/*查询购物车是否已有此商品*/
		$result = db('t_shoppingcart')->where(['userid'=>$userid,'goodsid'=>$goodsid])->find();
		if($result){
			/*更新数据库数量*/
			$response = db('t_shoppingcart')->where(['userid'=>$userid,'goodsid'=>$goodsid])->setInc('quantity',$quantity);
		}else{
			/*上传到数据库*/
			$response = db('t_shoppingcart')->data(['scarid'=>"default",'userid'=>$userid,'goodsid'=>$goodsid,'quantity'=>$quantity])->insert();
		}
    	
    	/*发送回馈*/
		if($response){
			$feedback = [
	    		'code'=>205,
	    		'message'=>Config::get('Message')['ADD_SUCCESSED'], 
	    		'data'=>[]
	    	];
		}else{
			$feedback = [
	    		'code'=>405,
	    		'message'=>Config::get('Message')['ADD_FAILED'], 
	    		'data'=>[]
	    	];
		}
		echo json_encode($feedback);
    }
    
    
    /*存储订单信息*/
    public function orderInfoConfirm(){
    	$dataArr = input('?post.data')?input('post.data'):'';
    	$dataArr = json_decode($dataArr);
    	session("cartArr", $dataArr);
    	if(Session::get('cartArr')){
    		echo json_encode(true);
    	}else{
    		echo json_encode(false);
    	}
    }
    
    /*跳转订单确认页*/
   public function travelconfirm(){
   	return $this->fetch('/travelconfirm');
   }
    
    /*获取订单信息*/
    public function payorderinfo(){
    	$cartArr = Session::get('cartArr'); //购物车内容数组
    	$goodsArr = array();
    	for($i=0;$i<count($cartArr);$i++){
    		$goodsArr[$i] = db('t_goods')->where('goodsid',$cartArr[$i]->goodsid)->find();
    		$goodsArr[$i]['quantity'] = $cartArr[$i]->quantity;
    	};
    	$onlineUser = Session::get('onlineUser');
    	$temp = [
    		'goodsArr'=>$goodsArr,
    		'onlineUser'=>$onlineUser
    	];
    	echo json_encode($temp);
    }
    
    /*生成订单*/
   public function placeorder(){
   		$userid = Session::get('onlineUser')['userid'];
   		$ordernote = input('?post.ordernote')?input('post.ordernote'):'';
   		$goodsArr = json_decode(input('?post.goodsArr')?input('post.goodsArr'):'',true);
   		$totalprice=0;
   		$pendingorders = [];
   		
   		foreach($goodsArr as $value){
   			//生成订单
   			$orderid= intval(db('t_orders')->insertGetId(['orderid'=>"default",'goodsid'=>$value['goodsid'],'userid'=>$userid,'orderprice'=>$value['price'],'buytime'=>date("Y-m-d H:i:s",time()),'orderStatus'=>1,'orderqty'=>$value['quantity'],'orderComment'=>'未评论','ordernote'=>$ordernote]));
   			//减库存
   			db('t_goods')->where('goodsid',$value['goodsid'])->setDec('quantity',$value['quantity']);
   			//加销量
   			db('t_goods')->where('goodsid',$value['goodsid'])->setInc('soldqty',$value['quantity']);
   			//获取总金额
   			if($value['saleType']=='普购'){
   				$totalprice +=  floatval($value['price']) * intval($value['quantity']);
   			}else{
   				$totalprice +=  floatval($value['saleprice']) * intval($value['quantity']);
   			}
   			//删除订单信息session
   			session('cartArr',null);
   			 
   			//获取到生成的订单对象
   			$pendingorders[] = db('t_orders')->where(['orderid'=>$orderid])->find();
   		};
   		
   		if(count($pendingorders)>0){
   			$feedback = [
	    		'code'=>211,
	    		'message'=>Config::get('Message')['PLACEORDER_SUCCESSED'], 
	    		'data'=>[$pendingorders,$totalprice]
	    	];
   		}else{
   			$feedback = [
	    		'code'=>411,
	    		'message'=>Config::get('Message')['PLACEORDER_FAILED'], 
	    		'data'=>[$pendingorders,$totalprice]
	    	];
   		}
   		echo json_encode($feedback);
   }
   
   /*立即付款*/
  public function pay(){
  	$totalprice = input('?post.totalprice')?input('post.totalprice'):'';
  	$pendingorders = json_decode(input('?post.pendingorders')?input('post.pendingorders'):'',true);
  	$password = md5(input('?post.password')?input('post.password'):'');
  	
  	if(strcasecmp($password,Session::get('onlineUser')['upassword'])==0){
  		if(Session::get('onlineUser')['umoney']>$totalprice){
  			//启动事务		
  			//扣钱
			$charge = db('t_user')->where('userid', Session::get('onlineUser')['userid'])->setDec('umoney',$totalprice);
//			$charge = true;
  			if($charge){
  				foreach($pendingorders as $value){
  					//改状态
					db('t_orders')->where('orderid', intval($value['orderid']))->update(['orderStatus'=>2]);
  				}
  				$feedback = [
		    		'code'=>2000,
		    		'message'=>Config::get('Message')['PAID_SUCCESS'], //付款成功
		    		'data'=>[]
		    	];
  			}
  		}else{
  			$feedback = [
	    		'code'=>412,
	    		'message'=>Config::get('Message')['INSUFFICIENT_BALANCE'], //余额不足
	    		'data'=>[]
	    	];
  		}
  	}else{
  		$feedback = [
    		'code'=>0000,
    		'message'=>Config::get('Message')['FILL_IN_ERROR'], //填写密码输入错误
    		'data'=>[]
    	];
  	}
  	
  	echo json_encode($feedback);
  	
  }
}
