<?php
include 'conf.php';

$token_error = array(21314,21315,21316,21317,21327,21332);

/**
 * 推荐
 */
if($_POST['action']=='best') {
	$params = array();
	$params['original'] = 1;
	$params['hasPic']   = 1;
	$params['search']   = '';
	
	if($_POST['type']=='hot') {
		$params['order'] = 'commentTimes';
		//$params['order'] = 'createTime';
		//$params['tag'] = array('型秀');
		$params['tag'] = array('王牌');
	}
	else if($_POST['type']=='new') {
		$params['order'] = 'createTime';
	}
	else {
		$params['order'] = 'createTime';
		$params['tag'] = array('新品');
	}
	
	$params['start']    = $_POST['start'];
	$params['limit']    = 10;
	exit(get_weibo_info($params));
}

/**
 * 
 */
if($_POST['action']=='top') {
	$params             = array();
	$params['original'] = '';
	$params['hasPic']   = '';
	$params['search']   = '';
	if($_POST['type']=='hot') {
		$params['order'] = 'createTime';
		//$params['tag'] = '热门';
		$params['tag'] = array('热门');
	}
	else if($_POST['type']=='new') {
		$params['order'] = 'createTime';
		$params['tag'] = array('王牌');
	}
	else {
		$params['order'] = '';
// 		$params['tag'] = '晒单';
	}
	$params['start']    = $_POST['start'];
	$params['limit']    = 10;
	exit(get_weibo_info($params));
}



/**
 * 获取微博信息
 * 
 */
if($_POST['action']=='getStatus') {
	$client = callSoap(SOA_SINA_SOAP_WSDL);
	if($client!=false) {
		$tokenList = $client->getAccessTokenList(100);
		try {
			while(true) {
				$token = array_shift($tokenList);
				if(!is_numeric($_POST['mid'])) {
					$rst = $client->get($token['_id'],'statuses/queryid',array('mid'=>$_POST['mid'],'type'=>1,'isBase62'=>1));
					$id = $rst['id'];
				}
				else {
					$id = $_POST['mid'];
				}
				
				$statusInfo = $client->get($token['_id'],'statuses/show',array('id'=>$id,'umaCacheExpireTime'=>0));
				if(isset($statusInfo['error_code']) && !in_array($statusInfo['error_code'],$token_error)) {
					break;
				}
				else if(isset($statusInfo['error']) && !isset($statusInfo['error_code'])) {
					break;
				}
				else if(!isset($statusInfo['error'])) {
					break;
				}
			}
		}
		catch (Exception $e) {
			exit(json_encode($e));
		}
		exit(json_encode(filterText($statusInfo)));

	}
	else {
		exit("SOAP Error");
	}
}

/**
 * 获取评论信息
 * 
 */
if($_POST['action']=='getComments') {
	$id = $_POST['weiboId']; //微博ID
	$client = callSoap(SOA_SINA_SOAP_WSDL);
	if($client!=false) {
		$tokenList = $client->getAccessTokenList(100);
		$token = array_shift($tokenList);
		$commentList = array();
		while(true) {
			$rst = $client->get($token['_id'],'comments/show',array('id'=>$id,'umaCacheExpireTime'=>0));
			$commentList = $rst['comments'];
			
			if(isset($rst['error_code']) && !in_array($rst['error_code'],$token_error)) {
				break;
			}
			else if(isset($rst['error']) && !isset($rst['error_code'])) {
				break;
			}
			else if(!isset($rst['error'])) {
				break;
			}
		}
		exit(json_encode(filterText($commentList)));
	}
	else {
		exit("SOAP Error");
	}
}


/**
 * 发表微博评论或者转发
 * 
 */
if($_POST['action']=='sendMsg') {
	if(!isset($_SESSION['umaId'])) {
		exit(json_encode(array('error'=>403)));
	}
	
	$type     = $_POST['type'];
	$topic_id = $_POST['topic_id'];
	$content  = $_POST['content'];
	
	$type = strtolower($type);
	if(!in_array($type,array('comment','post','repost','ilike'))) {
		exit(json_encode(array('error'=>500)));
	}

	$client   = callSoap(SOA_SINA_SOAP_WSDL);

	if(!is_numeric($topic_id)) {
		$rst      = $client->get($_SESSION['umaId'],'statuses/queryid',array('mid'=>$topic_id,'type'=>1,'isBase62'=>1));
		$topic_id = $rst['id'];
	}
	
	if($type=='ilike') {
		//获取我喜欢的微博
		$rst = $client->get($_SESSION['umaId'],'statuses/show',array('id'=>$topic_id));
	}
	elseif($type=='post') {
		//发表微博
		$rst = $client->post($_SESSION['umaId'],'statuses/update',array('status'=>$content));
	}
	elseif($type=='repost') {
		//转发微博
		$rst = $client->post($_SESSION['umaId'],'statuses/repost',array('status'=>$content,'id'=>$topic_id));
	}
	else {
		//评论某个微博回复
		if((int) $_POST['cid'] > 0) {
			$rst = $client->post($_SESSION['umaId'],'comments/reply',array('comment'=>$content,'id'=>$topic_id,'cid'=>$_POST['cid']));
		}
		else {
			//评论某条微博
			$rst = $client->post($_SESSION['umaId'],'comments/create',array('comment'=>$content,'id'=>$topic_id));
		}
	}
	
	//记录我发表的微博
	if(!isset($rst['error'])) {
		$post = new MongoCollection($db,'post');
		
		$check = $post->findOne(array('uid'=>(int) $_SESSION['uid'],'datas.id'=>$rst['id']));
		if($check==null) {
			$data = array();
			$data['uid']         = (int) $_SESSION['uid'];
			$data['type']        = $type;
			$data['datas']       = $rst;
			$data['create_time'] = new MongoDate();
			$post->insert($data);
		
			//发表成功增加1个积分
			$userCollection = new MongoCollection($db,'users');
			$userCollection->update(array('id'=>(int) $_SESSION['uid']),array('$inc'=>array('timberland.points'=>1)),$updateOption);
		}
	}
	
// 	if(isset($rst['created_at'])) {
// 		$rst['created_at'] = dealTime(strtotime($rst['created_at']));
// 	}
	
	exit(json_encode(filterText($rst)));
}

/**
 * 完善个人信息
 * 
 */
if($_POST['action']=='completion') {
	if(!isset($_SESSION['uid'])) {
		exit(json_encode(array('error'=>1,'msg'=>'未登录用户无法完善个人信息')));
	}
	
	if(!in_array($_POST['province'],$provinces)) {
		exit(json_encode(array('error'=>2,'msg'=>'无效的省份信息')));
	}
	
	if($_POST['name']=='') {
		exit(json_encode(array('error'=>3,'msg'=>'请填写您的真实姓名')));
	}
	
	if($_POST['mobile']=='' || !isValidMobile($_POST['mobile'])) {
		exit(json_encode(array('error'=>4,'msg'=>'请填写您的有效的手机号码')));
	}
	
	if($_POST['address']=='' ) {
		//exit(json_encode(array('error'=>1,'msg'=>'请填写您的地址')));
	}
	
	unset($_POST['action']);
	
	try {
		$userCollection = new MongoCollection($db,'users');
		$update = array();
		$update['timberland.province'] = $_POST['province'];
		$update['timberland.name']     = $_POST['name'];
		$update['timberland.mobile']   = $_POST['mobile'];
		$update['timberland.address']  = $_POST['address'];
		$userCollection->update(array('id'=>(int) $_SESSION['uid']),array('$set'=>$update),$updateOption);
		exit(json_encode(array('error'=>0,'msg'=>'感谢您完善个人信息')));
	}
	catch(Exception $e) {
		exit(json_encode(array('error'=>5,'msg'=>$e->getFile().$e->getLine().$e->getMessage())));
	}
	
}

if($_POST['action']=='getMyDatas') {
	$type = strtolower($_POST['type']);

	if(!in_array($type,array('comment','post','repost','ilike'))) {
		exit(json_encode(array('error'=>500)));
	}
	
	try {
		$postCollection = new MongoCollection($db,'post');
		$cursor = $postCollection->find(array('uid'=>(int) $_SESSION['uid'],'type'=>$type),array('datas'));
		$cursor->sort(array('create_time'=>-1));
		$cursor->skip($_POST['start'])->limit($_POST['limit']);
		if($cursor->count()==0) {
			var_dump($_SESSION);
		}
		exit(json_encode(filterText(convertToPureArray(iterator_to_array($cursor,false)))));
	}
	catch(Exception $e) {
		exit($e->getFile().$e->getLine().$e->getMessage());
	}
}

if($_POST['action']=='join') {
	
}

if($_POST['action']=='getMyInfo') {
	$uid = isset($_COOKIE['uid']) ? $_COOKIE['uid'] : $_SESSION['uid'];
	$userCollection = new MongoCollection($db,'users');
	$userInfo = $userCollection->findOne(array("id"=>(int) $uid));
	if($userInfo==null) {
		exit(json_encode(array('error'=>1,'msg'=>'登录已过期，请重新登录01')));
	}
	exit(json_encode($userInfo));
}

/**
 * 检测cookie是否依然有效，有效则保持登录
 */
if($_POST['action']=='check') {
	$umaId  = $_COOKIE['umaId'];
	$uid    = (int) $_COOKIE['uid'];
	$client = callSoap(SOA_SINA_SOAP_WSDL);
	$token  = $client->getToken($umaId);
	$expireTime = $token['expireTime']->sec;
	if($expireTime-time() > 0) {
		$_SESSION['umaId'] = $umaId;
		$_SESSION['uid']   = $uid;
		exit(json_encode(array('error'=>0,'msg'=>'')));
	}
	else {
		setcookie('umaId','',time()-1);
		setcookie('uid','',time()-1);
		session_destroy();
		exit(json_encode(array('error'=>1,'msg'=>'登录已过期，请重新登录02')));
	}
}

/**
 * 注销登录
 */
if($_GET['action']=='logout') {
	setcookie('umaId','',time()-1);
	setcookie('uid','',time()-1);
	session_destroy();
	header("location:./");
	exit();
}



