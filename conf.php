<?php
set_time_limit(120);
ini_set('default_socket_timeout', 1200);
ini_set('session.gc_maxlifetime',86400);
session_start();

ini_set("display_errors", 1);

//定义常量
define('SOA_SINA_SOAP_WSDL', 'http://scrm.umaman.com/soa/sina/soap?wsdl');

//连接数据库代码
$mongo = new Mongo("mongodb://localhost:27017");
$db    = $mongo->selectDB("timberland_iclub_plus");

//mongodb操作参数
$insertOption = array('safe'=>false,'fsync'=>false,'timeout'=>120000);
$updateOption = array('upsert'=>false,'multiple'=>true,'safe'=>false,'fsync'=>false,'timeout'=>120000);


//省份列表
$provinces = array( "北京市",
					"天津市",
					"上海市",
					"重庆市",
					"香港特别行政区",
					"澳门特别行政区",
					"河北省",
					"山西省",
					"内蒙古自治区",
					"辽宁省",
					"吉林省",
					"黑龙江省",
					"江苏省",
					"浙江省",
					"安徽省",
					"福建省",
					"江西省",
					"山东省",
					"河南省",
					"湖北省",
					"湖南省",
					"广东省",
					"广西壮族自治区",
					"海南省",
					"四川省",
					"贵州省",
					"云南省",
					"西藏自治区",
					"陕西省",
					"甘肃省",
					"青海省",
					"宁夏回族自治区",
					"新疆维吾尔自治区",
					"台湾省");

/**
 * 调用SOAP服务
 * @param  string $wsdl
 * @param  string $refresh
 * @return SoapClient|boolean
 */
function callSoap($wsdl,$refresh=false) {
	try {
		$options = array(
				'soap_version'=>SOAP_1_2,
				'exceptions'=>true,
				'trace'=>true,
				'connection_timeout'=>120
		);
		if($refresh==true) {
			$options['cache_wsdl'] = WSDL_CACHE_NONE;
		}
		else {
			$options['cache_wsdl'] = WSDL_CACHE_MEMORY;
		}
		$client = new SoapClient($wsdl,$options);
		return $client;
	}
	catch (Exception $e) {
		exit($e->getMessage().$e->getFile().$e->getLine().$e->getTraceAsString());
		return false;
	}
}

/**
 *
 * 计算多少分钟前
 * @param int $time
 */
function dealTime($time) {
	if(!is_int($time)) $time = strtotime($time);

	$diff   = time()-$time;
	$minute = floor($diff/60);
	$hour   = floor($diff/3600);

	if($minute < 1) {
		return '1分钟前';
	}
	else if($minute < 60) {
		return $minute.'分钟前';
	}
	else if($hour >= 1 && $hour <24) {
		return $hour.'小时前';
	}
	else {
		return date("Y-m-d H:i:s",$time);
	}

}

/**
 * 获取微博数据
 * @param array $params
 * @param bool $debug
 * @return string
 */
function get_weibo_info($params,$debug=false) {
	$projectId = '50038c017c999d241e000006';
	//$keywordId = '4f7810d77c999d9661000003';//timberland|添柏岚、
	$keywordId = '4f599ac27c999d1c02000034';

	$query = '';
	foreach($params as $key=>$value) {
		if(is_array($value)) {
			$query .= '&'.$key.'='.join(',', $value);
		}
		else {
			$query .= '&'.$key.'='.$value;
		}
	}

	$url = 'http://scrm.umaman.com/soa/weibo/get-keyword-weibo-list?projectId='.$projectId.'&keywordId='.$keywordId.$query;

	$json = file_get_contents($url);
	if($debug) {
		var_dump($params,$query,$url,$json);
	}
	return $json;
}

/**
 *
 * 检测是否为有效的电子邮件地址
 * @param string $email
 * @return bool true/false
 *
 */
function isValidEmail($email,$getmxrr=0) {
	if ((strpos($email, '..') !== false) or (!preg_match('/^(.+)@([^@]+)$/', $email, $matches))) {
		return false;
	}

	$_localPart = $matches[1];
	$_hostname  = $matches[2];

	if ((strlen($_localPart) > 64) || (strlen($_hostname) > 255)) {
		return false;
	}

	$atext = 'a-zA-Z0-9\x21\x23\x24\x25\x26\x27\x2a\x2b\x2d\x2f\x3d\x3f\x5e\x5f\x60\x7b\x7c\x7d\x7e';
	if (!preg_match('/^[' . $atext . ']+(\x2e+[' . $atext . ']+)*$/', $_localPart)) {
		return false;
	}

	if($getmxrr==1) {
		$mxHosts = array();
		$result = getmxrr($_hostname, $mxHosts);
		if(!$result) {
			return false;
		}
	}
	return true;
}

/**
 *
 * 检测是否为有效的手机号码
 * @param string $mobile
 */
function isValidMobile($mobile) {
	if(preg_match("/^1[3,5,8]{1}[0-9]{9}$/", $mobile)) return true;
	return false;
}

/**
 *
 *
 * 转化mongo db的输出结果为纯数组
 *
 * @param array $arr
 */
function convertToPureArray ($arr)
{
	if (! is_array($arr) || count($arr) == 0)
		return array();
	$newArr = array();
	foreach ($arr as $key => $value) {
		if (is_array($value)) {
			$newArr[$key] = convertToPureArray($value);
		} else {
			if ($value instanceof MongoId || $value instanceof MongoInt64 ||
					$value instanceof MongoInt32) {
				$value = $value->__toString();
			} else
				if ($value instanceof MongoDate ||
						$value instanceof MongoTimestamp) {
				$value = date("Y-m-d H:i:s", $value->sec);
			}
			$newArr[$key] = $value;
		}
	}
	return $newArr;
}

/**
 * 过滤返回结果中的需要转移的特殊字符
 * @param array $arr
 * @return array
 */
function filterText($arr) {
	if (! is_array($arr) || count($arr) == 0)
		return array();
	$newArr = array();
	foreach ($arr as $key => $value) {
		if (is_array($value)) {
			$newArr[$key] = filterText($value);
		} else {
			if($key=='text') {
				$newArr[$key] = htmlspecialchars($value,ENT_QUOTES,'UTF-8');
			}
// 			elseif($key=='created_at') {
// 				$newArr[$key] = dealTime($value);
// 			}
			else {
				$newArr[$key] = $value;
			}
		}
	}
	return $newArr;
} 

/**
 * 
 * @param string $file
 * @return boolean
 */
function check_file_mtime($file) {
	$last_modify_time = (int) file_get_contents(dirname(__FILE__).'/cache.log');
	if(filemtime($file) > $last_modify_time) {
		file_put_contents(dirname(__FILE__).'/cache.log', time());
		return true;
	}
	return false;
}

/**
 * 
 * @param string $callback 回调函数名
 * @param string $dir
 */
function dir_walk($callback, $dir) {
	if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			if ($file === '.' || $file === '..') {
				continue;
			}
			if (is_file($dir . $file)) {
				$callback($dir . $file);
			} 
			elseif (is_dir($dir . $file)) {
				dir_walk($callback, $dir . $file . DIRECTORY_SEPARATOR);
			}
		}
		closedir($dh);
	}
}

/**
 * 
 * @param string $path
 * @return string
 */
function get_cache_version() {
	dir_walk("check_file_mtime",dirname(__FILE__).'/');
	return file_get_contents(dirname(__FILE__).'/cache.log');
}
