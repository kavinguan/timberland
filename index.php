<?php 
include("header.php");
//授权记录cookie
if(isset($_GET['umaId']) && isset($_GET['uid'])) {
	$_SESSION['umaId'] = $_GET['umaId'];
	$_SESSION['uid']   = intval($_GET['uid']);
	
	setcookie('umaId',$_GET['umaId'],time()+24*3600);
	setcookie('uid',$_GET['uid'],time()+24*3600);
	
	try {
		$client = callSoap(SOA_SINA_SOAP_WSDL);
		$rst = $client->get($_SESSION['umaId'],'users/show',array('uid'=>$_SESSION['uid']));
		if(!isset($rst['error'])) {
			$_SESSION['userInfo'] = $rst;
			//检查是否完善信息
			$collection = new MongoCollection($db,'users');
			$userInfo = $collection->findOne(array('id'=>$rst['id']));
			if($userInfo==null) {
				$timberland = array();
				$timberland['province'] = '';
				$timberland['name']     = '';
				$timberland['mobile']   = '';
				$timberland['address']  = '';
				$timberland['points']   = 0;
				$rst['timberland']      = $timberland;
				$rst['create_time']     = new MongoDate();
				$collection->insert($rst,$insertOption);
				header("location:index.php#myziliao");
				exit();
			}
			else {
				if($userInfo['timberland']['province'] == '' ||
				   $userInfo['timberland']['name'] == '' ||
				   $userInfo['timberland']['mobile'] == '' ||
				   $userInfo['timberland']['address'] == '') 
				{
					header("location:index.php#myziliao");
					exit();
				}
			}
		}
	}
	catch (Exception $e) {
		exit($e->getFile().$e->getLine().$e->getMessage());
	}
	
	header("location:index.php");
	exit();
}
?>
<div class="top"><img src="images/top.gif" alt="" class="block"></div>
<div class="cont">
	<div id="index_cont" class="panel" selectgkf="true">
		<div class="banners banners1">
			<ul>
				<li><img src="images/banner.jpg" alt=""></li>
				<li><img src="images/banner_1.jpg" alt=""></li>
				<li><img src="images/banner_2.jpg" alt=""></li>
				<li><img src="images/banner_3.jpg" alt=""></li>
			</ul>
		</div>
		<div class="index_btn">
			<ul>
				<a href="#xingxiu" onclick="javascript:ga('timberland.umaman.com','首页_最佳推荐');"><li><img src="images/index_btn1.gif" alt="" class="block"></li></a>
				<a href="#redian" onclick="javascript:ga('timberland.umaman.com','首页_最新排行');"><li><img src="images/index_btn2.gif" alt="" class="block"></li></a>
				<a href="#huodong" onclick="javascript:ga('timberland.umaman.com','首页_店铺查询');"><li><img src="images/index_btn3.gif" alt="" class="block"></li></a>
				<a href="#dipan" onclick="javascript:ga('timberland.umaman.com','首页_我的地盘');" class="indexdipan"><li><img src="images/index_btn4.gif" alt="" class="block"></li></a>
			</ul>
		</div>
		<img src="images/index_btn3on.gif" alt="" class="none">
	</div>

    <div class="nav none">
        <ul>
            <li><a href="#index" onclick="javascript:ga('timberland.umaman.com','导航_首页');"><img src="images/nav1.png" alt=""><img src="images/nav1on.png" alt="" class="none"></a></li>
            <li><a href="#xingxiu" onclick="javascript:ga('timberland.umaman.com','导航_最佳推荐');"><img src="images/nav2.png" alt="" class="none"><img src="images/nav2on.png" alt=""></a></li>
            <li><a href="#redian" onclick="javascript:ga('timberland.umaman.com','导航_最新排行');"><img src="images/nav3.png" alt=""><img src="images/nav3on.png" alt="" class="none"></a></li>
            <li><a href="#huodong" onclick="javascript:ga('timberland.umaman.com','导航_店铺查询');"><img src="images/nav4.png" alt=""><img src="images/nav4on.png" alt="" class="none"></a></li>
            <!--<li><a href="#dipan" onclick="check_login()"><img src="images/nav5.png" alt=""><img src="images/nav5on.png" alt="" class="none"></a></li>-->
            <li><a href="#dipan" onclick="javascript:ga('timberland.umaman.com','导航_我的地盘');" class="navdipan"><img src="images/nav5.png" alt=""><img src="images/nav5on.png" alt="" class="none"></a></li>
        </ul>
        <span class="nav_on"></span>
    </div>
    
    <div id="xingxiu_cont" class="panel">
        <div class="banners banners2">
            <ul>
                <li><img src="images/banner1_3.jpg" alt=""></li>
            </ul>
        </div>
        
        <div id="tuijian_nav" class="subnav">
            <ul>
                <li id="xingxiu_all" onclick="javascript:ga('timberland.umaman.com','最佳推荐_新品');" class="active">新　品</li>
                <li id="xingxiu_hot" onclick="javascript:ga('timberland.umaman.com','最佳推荐_王牌');">王　牌</li>
               <!-- <li id="xingxiu_new">推　荐</li> -->
            </ul>
            <span class="subnav_on"></span>
        </div>
        
        <div id="xingxiu_all_content" class="pubu none">
            <ul id="container">
                
            </ul>
			<ul>
				
			</ul>
        </div>
        <div id="xingxiu_hot_content" class="pubu">
            <ul id="container">
                
            </ul>
			<ul>
				
			</ul>
        </div>
        <div id="xingxiu_new_content" class="pubu none">
            <ul id="container">
                 
            </ul>
			<ul>
				
			</ul>
        </div>
        
        <a href="javascript:void(0);" onclick="get_xingxiu_more(xingxiu_click_type);ga('timberland.umaman.com','最佳推荐_查看更多');" class="a_more">查看更多</a>
        
    </div>
    
    <div id="xingxiuc_cont" class="panel">
        <div class="pictie">
            <img src="" alt="" class="peitu">
            <div class="pictie_c">
                <div class="louzhu">
                    <span class="plnum"><img src="images/heart.png" alt=""> Loading……</span>
                    <img src="images/02.jpg" class="face">Loding…… <img src="images/v.gif" alt="">
                </div>
                <div class="louzhu_txt"></div>
            </div>
            <div class="pictie_nav">
                <ul>
                    <li class="active" id="weibo_comments_number">Loading……</li>
                    <!-- <li>热评</li>  -->
                </ul>
            </div>
            <div class="pictie_hf">
                <ul id="weibo_comments">
                </ul>
            </div>
        </div>
    </div>
    
    <div id="redian_cont" class="panel">
        <div class="fabiao" onclick="show_repost_or_comment(0,'post',0,'');">
            <img src="images/02.jpg" class="face">
            <div class="fayan">聊聊你的添柏岚，说说你最想去的地方</div>
        </div>
        
        <div id="redian_nav" class="subnav">
            <ul>
                <li id="top_all" onclick="javascript:ga('timberland.umaman.com','最新排行_最新');" class="active">最　新</li>
                <li id="top_hot" onclick="javascript:ga('timberland.umaman.com','最新排行_热门');">热　门</li>
                <!--<li id="top_new">王　牌</li>-->
            </ul>
            <span class="subnav_on"></span>
        </div>
        
        <div class="hots none" id="top_all_content">
            <ul>
            </ul>
        </div>
        
        <div class="hots" id="top_hot_content">
            <ul>
            </ul>
        </div>
        
        <div class="hots none" id="top_new_content">
            <ul>
            </ul>
        </div>
        
        <a href="javascript:;" onclick="get_top_more(top_click_type);ga('timberland.umaman.com','最新排行_查看更多');" class="a_more1">查看更多</a>
    </div>
    
    <div id="huodong_cont" class="panel">
		<div class="address_search"><input type="text" value="搜索" /></div>
		<div class="address_list">
			<dl>
				<dt><span class="icon"></span>品牌自营店</dt>
				<dd>
					<ul>
						<li><strong>上海梅龙镇广场店</strong><br/>上海南京西路1038号梅龙镇广场501-502室</li>
						<li><strong>海宁百联奥特莱斯广场店</strong><br/>海宁长安镇农发区启潮路199号百联奥特莱斯广场C区-103室</li>
						<li><strong>宁波杉井奥特莱斯广场店</strong><br/>宁波市鄞州区秋实路555号杉井奥特莱斯广场14900室</li>
					</ul>
				</dd>
				<dt><span class="icon"></span>鞍山</dt><dd><ul>
					<li><strong>鞍山天兴百盛购物中心</strong><br/>鞍山市二道街88号天兴百盛购物中心4楼</li>
				</ul></dd>
				<dt><span class="icon"></span>包头</dt><dd><ul>
					<li><strong>包头王府井百货</strong><br/>包头市昆区钢铁大街69号王府井百货3楼</li>
					<li><strong>包头维多利商厦</strong><br/>包头市钢铁大街维多利商厦4楼</li>
				</ul></dd>
				<dt><span class="icon"></span>保定</dt><dd><ul>
					<li><strong>保定百货购物广场</strong><br/>保定市朝阳北大街916号2楼</li>
				</ul></dd>
				<dt><span class="icon"></span>北京</dt><dd><ul>
					<li><strong>北京SOGO</strong><br/>北京市宣武门外大街8号庄胜崇光百货商场SOGO新馆4层</li>
					<li><strong>北京北辰购物中心</strong><br/>北京市安定门外安立路8号北辰购物中心4楼</li>
					<li><strong>北京朝北大悦城</strong><br/>北京市朝阳区朝阳北路青年路口大悦城1楼  </li>
					<li><strong>北京翠微大厦</strong><br/>北京市海淀区复兴路33号翠微大厦3楼</li>
					<li><strong>北京当代商城</strong><br/>北京市海淀区中关村大街40号当代商城3楼</li>
					<li><strong>北京东方广场</strong><br/>北京市东城区东长安街1号东方广场地下一层BB25号店</li>
					<li><strong>北京东四环百盛购物中心</strong><br/>北京市朝阳区东四环中路189号百盛购物中心3楼</li>
					<li><strong>北京复兴门百盛购物中心</strong><br/>北京市复兴门内大街101号百盛购物中心3楼</li>
					<li><strong>北京火车南站店</strong><br/>北京市崇文区永定门外火车南站出发层</li>
					<li><strong>北京机场专柜1</strong><br/>北京市首都机场1号航站楼</li>
					<li><strong>北京机场专柜2</strong><br/>北京市首都机场2号航站楼</li>
					<li><strong>北京机场专柜3</strong><br/>北京市首都机场3号航站楼</li>
					<li><strong>北京建国门赛特</strong><br/>北京市建国门外大街22号4楼</li>
					<li><strong>北京金源MALL</strong><br/>北京市海淀区远大路1号金源新燕莎MALL 2层2050号商铺</li>
					<li><strong>北京金源燕莎友谊商城</strong><br/>北京市海淀区远大路1号燕莎友谊商城地下一层</li>
					<li><strong>北京来福士购物中心</strong><br/>北京市东城区东直门南大街1号来福士购物中心2楼</li>
					<li><strong>北京牡丹园翠微百货</strong><br/>北京市海淀区花园路2号翠微百货2楼</li>
					<li><strong>北京赛特奥莱</strong><br/>北京市朝阳区香江北路28号1座-094</li>
					<li><strong>北京双安商场</strong><br/>北京市海淀区北三环西路38号双安商场4楼</li>
					<li><strong>北京太阳宫百盛购物中心</strong><br/>北京市朝阳区东北三环七圣中街太阳宫百盛购物中心4楼</li>
					<li><strong>北京王府井百货大楼</strong><br/>北京市王府井大街255号4楼</li>
					<li><strong>北京新光三月</strong><br/>北京市朝阳区建国路87号新光天地4楼</li>
					<li><strong>北京新世界商场</strong><br/>北京市崇文门外大街3号新世界商场一期3层   </li>
					<li><strong>北京燕莎奥莱</strong><br/>北京市朝阳区东四环南路9号燕莎奥特莱斯C座1055-1061</li>
					<li><strong>北京燕莎友谊商城</strong><br/>北京市朝阳区亮马桥路52号燕莎友谊商城4楼</li>
					<li><strong>北京长安商场</strong><br/>北京市复兴门外大街15号长安商场3楼</li>
					<li><strong>北京中友百货</strong><br/>北京市西城区西单北大街176号中友百货2楼</li>
				</ul></dd>
				<dt><span class="icon"></span>常州</dt><dd><ul>
					<li><strong>常州购物中心</strong><br/>常州市延龄西路1-7号常州购物中心4楼</li>
				</ul></dd>
				<dt><span class="icon"></span>承德</dt><dd><ul>
					<li><strong>承德双百</strong><br/>承德市新华路1号双百购物广场2楼</li>
				</ul></dd>
				<dt><span class="icon"></span>大连</dt><dd><ul>
					<li><strong>大连百年城</strong><br/>大连市中山区解放路19号百年城307店铺</li>
					<li><strong>大连新玛特商场</strong><br/>大连市中山区青三街1号新玛特商场4楼</li>
					<li><strong>大连友谊商城</strong><br/>大连市中山区人民路8号友谊商城2楼</li>
				</ul></dd>
				<dt><span class="icon"></span>大同</dt><dd><ul>
					<li><strong>大同华林新天地购物中心</strong><br/>大同市红旗广场A区华林新天地购物中心2楼</li>
				</ul></dd>
				<dt><span class="icon"></span>东莞</dt><dd><ul>
					<li><strong>东莞东城海雅百货</strong><br/>东莞市东城中路世博广场海雅百货四楼</li>
					<li><strong>东莞东纵天虹商场</strong><br/>东莞市莞城区东纵大道愉景威尼斯广场天虹商场2楼</li>
					<li><strong>东莞南城海雅</strong><br/>东莞市南城区鸿福路83号4楼</li>
					<li><strong>东莞星河城</strong><br/>东莞市东城区东升路星河城1楼</li>
				</ul></dd>
				<dt><span class="icon"></span>佛山</dt><dd><ul>
					<li><strong>广州佛山友谊</strong><br/>佛山市禅城区（祖庙街道）城门头路18号佛山友谊3楼</li>
				</ul></dd>
				<dt><span class="icon"></span>福州</dt><dd><ul>
					<li><strong>福州万象天虹</strong><br/>福州市台江区工业路378号万象城天虹百货1楼</li>
				</ul></dd>
				<dt><span class="icon"></span>广州</dt><dd><ul>
					<li><strong>广州番禺天河城折扣店</strong><br/>广州市番禺万博中心天河城折扣店1楼</li>
					<li><strong>广州国金友谊商场</strong><br/>广州市珠江新城西路5号西塔国金友谊商场4楼</li>
					<li><strong>广州环市东友谊店</strong><br/>广州市环市路369号友谊商店股份有限公司5楼</li>
					<li><strong>广州太古汇</strong><br/>广州市天河区太古汇广场负二楼</li>
					<li><strong>广州正佳友谊广场</strong><br/>广州市天河路228号正佳广场3楼</li>
				</ul></dd>
				<dt><span class="icon"></span>哈尔滨</dt><dd><ul>
					<li><strong>哈尔滨会展</strong><br/>哈尔滨市南岗区红旗大街322号金座15厅</li>
					<li><strong>哈尔滨燕莎奥莱</strong><br/>哈尔滨市道里区地段街123号1层</li>
					<li><strong>哈尔滨远大</strong><br/>哈尔滨市南岗区果戈里大街378号远大购物中心5楼</li>
				</ul></dd>
				<dt><span class="icon"></span>邯郸</dt><dd><ul>
					<li><strong>邯郸新世纪</strong><br/>邯郸市中华大街29号新世纪商业广场4楼</li>
				</ul></dd>
				<dt><span class="icon"></span>杭州</dt><dd><ul>
					<li><strong>杭州大厦</strong><br/>杭州市武林广场21号杭州大厦5楼</li>
					<li><strong>杭州解百</strong><br/>杭州市解放路251号杭州解百5楼</li>
					<li><strong>杭州尚泰百货</strong><br/>杭州江干区富春路701号尚泰百货2F</li>
					<li><strong>杭州武林银泰</strong><br/>杭州市延安路530号武林银泰5楼</li>
					<li><strong>杭州西湖银泰</strong><br/>杭州市延安路98号西湖银泰2楼</li>
				</ul></dd>
				<dt><span class="icon"></span>合肥</dt><dd><ul>
					<li><strong>合肥百盛购物中心</strong><br/>合肥市庐阳区淮河路步行街77号百盛购物中心4楼</li>
				</ul></dd>
				<dt><span class="icon"></span>呼和浩特</dt><dd><ul>
					<li><strong>呼和浩特天元商厦</strong><br/>呼和浩特市中山西路98号天元商厦2楼</li>
					<li><strong>呼和浩特维多利购物中心</strong><br/>呼和浩特市中山西路1号维多利购物中心2楼</li>
				</ul></dd>
				<dt><span class="icon"></span>济南</dt><dd><ul>
					<li><strong>济南恒隆</strong><br/>济南市历下区泉城路188号恒隆广场四楼东塔419号</li>
				</ul></dd>
				<dt><span class="icon"></span>佳木斯</dt><dd><ul>
					<li><strong>佳木斯久昌7号店</strong><br/>佳木斯市中山街68号久昌7号店1楼</li>
				</ul></dd>
				<dt><span class="icon"></span>昆明</dt><dd><ul>
					<li><strong>昆明百盛一店</strong><br/>昆明市三市街6号柏联广场柏联百盛商场4楼</li>
					<li><strong>昆明金鹰购物中心</strong><br/>昆明市青年路418号金鹰购物中心4楼</li>
					<li><strong>昆明新西南百盛购物中心</strong><br/>昆明市人民中路17号新西南百盛4F</li>
				</ul></dd>
				<dt><span class="icon"></span>兰州</dt><dd><ul>
					<li><strong>兰州国芳百盛购物中心</strong><br/>兰州市皋兰路东方红广场4楼</li>
					<li><strong>兰州亚欧</strong><br/>兰州市中山路120号5楼</li>
				</ul></dd>
				<dt><span class="icon"></span>廊坊</dt><dd><ul>
					<li><strong>廊坊万达广场</strong><br/>廊坊市安次区新华路万达广场二层2040商铺</li>
				</ul></dd>
				<dt><span class="icon"></span>临汾</dt><dd><ul>
					<li><strong>临汾世纪百悦购物中心</strong><br/>临汾市解放路世纪百悦购物中心4楼</li>
				</ul></dd>
				<dt><span class="icon"></span>南京</dt><dd><ul>
					<li><strong>南京金鹰国际购物中心</strong><br/>江苏省南京市汉中路89号金鹰国际购物中心5楼</li>
				</ul></dd>
				<dt><span class="icon"></span>南宁</dt><dd><ul>
					<li><strong>南宁梦之岛</strong><br/>南宁市民族大道中段49号梦之岛百货5楼</li>
					<li><strong>南宁水晶城梦之岛</strong><br/>南宁金湖路61号4楼</li>
					<li><strong>南宁友谊</strong><br/>南宁市青秀区金湖路59号地王国际3楼</li>
				</ul></dd>
				<dt><span class="icon"></span>南通</dt><dd><ul>
					<li><strong>南通文峰大世界</strong><br/>南通市南大街3-21号3楼</li>
				</ul></dd>
				<dt><span class="icon"></span>宁波</dt><dd><ul>
					<li><strong>宁波天一银泰</strong><br/>宁波市中山东路238号东门银泰5楼</li>
					<li><strong>宁波鄞州万达广场</strong><br/>宁波市鄞州区四民中路999号万达广场2B16-07店铺</li>
				</ul></dd>
				<dt><span class="icon"></span>青岛</dt><dd><ul>
					<li><strong>青岛百盛购物中心</strong><br/>青岛市市南区中山路44-60号百盛购物中心6楼</li>
					<li><strong>青岛麦凯乐</strong><br/>青岛市市南区香港中路69号麦凯乐4楼</li>
					<li><strong>青岛阳光百货</strong><br/>青岛市香港中路38号阳光百货3楼</li>
				</ul></dd>
				<dt><span class="icon"></span>泉州</dt><dd><ul>
					<li><strong>泉州天虹</strong><br/>泉州市丰泽区泉秀路与云鹿路交界处十字路口</li>
				</ul></dd>
				<dt><span class="icon"></span>厦门</dt><dd><ul>
					<li><strong>厦门新生活广场广场二期</strong><br/>厦门市嘉禾路399号新生活广场黄宝石3F</li>
					<li><strong>厦门大西洋天虹百货</strong><br/>厦门市湖滨西路7号大西洋天虹百货1楼</li>
					<li><strong>厦门禾祥奥莱</strong><br/>厦门市禾祥西路897号</li>
					<li><strong>厦门罗宾森</strong><br/>厦门市厦禾路885号1楼</li>
					<li><strong>厦门磐基广场</strong><br/>厦门市思明区嘉禾路197号磐基中心2楼</li>
					<li><strong>厦门中华城</strong><br/>厦门市思明南路171号之28中华城A2地块C区1楼1051号店</li>
				</ul></dd>
				<dt><span class="icon"></span>上海</dt><dd><ul>
					<li><strong>上海巴黎春天大华店</strong><br/>上海市宝山区真华路888号巴黎春天大华店5楼</li>
					<li><strong>上海飞州国际</strong><br/>上海市零陵路899号4楼</li>
					<li><strong>上海港汇广场</strong><br/>上海市虹桥路1号港汇广场415号4楼</li>
					<li><strong>上海淮海太平洋百货</strong><br/>上海市淮海中路333号地下一层</li>
					<li><strong>上海汇金百货</strong><br/>上海市肇嘉浜路1000号汇金百货6楼</li>
					<li><strong>上海久光百货</strong><br/>上海市南京西路1618号久光百货5楼</li>
					<li><strong>上海浦东八佰伴</strong><br/>上海市浦东新区张扬路501号5楼</li>
					<li><strong>上海浦东巴黎春天</strong><br/>上海市浦东新区浦建路118号浦东巴黎春天4楼</li>
					<li><strong>上海浦东机场店</strong><br/>上海市浦东国际机场二号候机楼</li>
					<li><strong>上海青浦奥莱</strong><br/>上海市青浦市沪青平公路2888号4楼</li>
					<li><strong>上海五角场万达特力屋</strong><br/>杨浦区邯郸路600号万达商业广场1楼</li>
					<li><strong>上海五角场又一城</strong><br/>杨浦区淞沪路8号百联又一城5楼</li>
					<li><strong>上海徐家汇太平洋百货</strong><br/>上海市徐汇区衡山路932号5楼</li>
					<li><strong>上海正大广场</strong><br/>上海市浦东新区陆家嘴西路168号4楼</li>
				</ul></dd>
				<dt><span class="icon"></span>深圳</dt><dd><ul>
					<li><strong>深圳大梅沙</strong><br/>深圳市盐田区大梅沙奥特莱斯村L栋3号</li>
					<li><strong>深圳福田COCOPARK购物中心</strong><br/>深圳市福田区福华三路COCOPARK购物中心1楼</li>
					<li><strong>深圳华强北茂业</strong><br/>深圳市福田区华强北路2005-2006号华强茂业632号6楼</li>
					<li><strong>深圳金光华广场</strong><br/>深圳市罗湖区人民南路金光华广场2楼</li>
					<li><strong>深圳京基广场</strong><br/>深圳市罗湖区深南东路5016号京基金融广场店3楼</li>
					<li><strong>深圳星河天虹购物广场</strong><br/>深圳市福田区福华三路星河国际天虹购物广场2楼</li>
					<li><strong>深圳益田假日广场</strong><br/>深圳市南山区华侨城益田假日广场-1楼</li>
				</ul></dd>
				<dt><span class="icon"></span>沈阳</dt><dd><ul>
					<li><strong>辽宁葫芦岛百货大楼</strong><br/>辽宁省葫芦岛市百货大楼2楼</li>
					<li><strong>沈阳大悦城</strong><br/>沈阳市小东路10号大悦城C座1楼C128 C129</li>
					<li><strong>沈阳伊势丹百货</strong><br/>沈阳市和平区太原北街84号沈阳伊势丹百货4层</li>
					<li><strong>沈阳中街新玛特商场</strong><br/>沈阳市大东区小东路1号 6层</li>
					<li><strong>沈阳中兴商厦</strong><br/>太原市北街86号中兴商厦4楼</li>
					<li><strong>沈阳卓展购物中心</strong><br/>沈阳市沈河区北京街7-1号卓展购物中心5楼</li>
				</ul></dd>
				<dt><span class="icon"></span>十堰</dt><dd><ul>
					<li><strong>十堰人民商场</strong><br/>十堰市人民北路1号5楼</li>
				</ul></dd>
				<dt><span class="icon"></span>石家庄</dt><dd><ul>
					<li><strong>石家庄北国商城</strong><br/>石家庄市中山东路188号北国商城4楼</li>
					<li><strong>石家庄先天下广场</strong><br/>石家庄市中山东路326号先天下广场3楼</li>
				</ul></dd>
				<dt><span class="icon"></span>苏州</dt><dd><ul>
					<li><strong>苏州天虹百货</strong><br/>苏州市工业园区苏雅路388号新天翔广场B座1楼 </li>
				</ul></dd>
				<dt><span class="icon"></span>太原</dt><dd><ul>
					<li><strong>太原华宇购物中心</strong><br/>太原市迎泽区开化寺街87号华宇购物中心6层</li>
					<li><strong>太原天美新天地</strong><br/>太原市长风街113号天美新天地4楼</li>
					<li><strong>太原王府井百货大楼</strong><br/>太原市小店区亲贤北街99号王府井百货大楼4层</li>
				</ul></dd>
				<dt><span class="icon"></span>唐山</dt><dd><ul>
					<li><strong>唐山凤凰购物广场</strong><br/>唐山市北新西道22号凤凰购物广场2楼</li>
				</ul></dd>
				<dt><span class="icon"></span>天津</dt><dd><ul>
					<li><strong>天津海信广场</strong><br/>天津市解放北路188号海信广场4楼</li>
					<li><strong>天津金元宝商场</strong><br/>天津市塘沽区解放路668号金元宝商场4楼</li>
					<li><strong>天津金元宝滨海店</strong><br/>天津市塘沽区泰达开发区黄海路19号3楼</li>
					<li><strong>天津伊势丹商场</strong><br/>天津市和平区南京路108号伊势丹商场4楼</li>
					<li><strong>天津友谊商场</strong><br/>天津市河西区友谊路21号友谊商场3楼</li>
					<li><strong>天津友谊新天地广场</strong><br/>天津市和平区滨江道208号友谊新天地广场4楼</li>
					<li><strong>天津武清奥莱</strong><br/>天津市武清区前进道北侧,距京津高速铁路武清站出口100米,佛罗伦萨小镇108-109商铺</li>
				</ul></dd>
				<dt><span class="icon"></span>乌鲁木齐</dt><dd><ul>
					<li><strong>天山百货大楼</strong><br/>乌鲁木齐市和平北路16号天山百货大楼5楼</li>
					<li><strong>乌鲁木齐美美百货</strong><br/>乌鲁木齐市友好北路美美百货4楼</li>
					<li><strong>乌鲁木齐友好百盛购物中心</strong><br/>新疆乌鲁木齐市友好南路668号百盛购物中心3楼</li>
				</ul></dd>
				<dt><span class="icon"></span>无锡</dt><dd><ul>
					<li><strong>无锡商业大厦</strong><br/>无锡市中山路343号无锡大东方百货4楼</li>
				</ul></dd>
				<dt><span class="icon"></span>武汉</dt><dd><ul>
					<li><strong>武汉国广</strong><br/>武汉市解放大道690号5楼</li>
					<li><strong>武汉群光</strong><br/>武汉市洪山区珞瑜路6号4楼</li>
					<li><strong>武汉奥莱</strong><br/>武汉市江夏区江夏大道特1号</li>
				</ul></dd>
				<dt><span class="icon"></span>西安</dt><dd><ul>
					<li><strong>西安东街百盛购物中心</strong><br/>西安市碑林区东大街239号2楼</li>
					<li><strong>西安世纪金花</strong><br/>西安市西大街1号钟鼓楼广场地下一层</li>
				</ul></dd>
				<dt><span class="icon"></span>西宁</dt><dd><ul>
					<li><strong>西宁王府井百货</strong><br/>西宁市西大街40号4楼</li>
				</ul></dd>
				<dt><span class="icon"></span>邢台</dt><dd><ul>
					<li><strong>邢台天一广场大洋百货</strong><br/>邢台市桥东区新华北路235号天一广场大洋百货4楼</li>
				</ul></dd>
				<dt><span class="icon"></span>徐州</dt><dd><ul>
					<li><strong>徐州金鹰购物中心</strong><br/>徐州市中山北路2号6楼</li>
				</ul></dd>
				<dt><span class="icon"></span>盐城</dt><dd><ul>
					<li><strong>盐城金鹰购物中心</strong><br/>盐城市建军中路169号4楼</li>
				</ul></dd>
				<dt><span class="icon"></span>银川</dt><dd><ul>
					<li><strong>银川新华百货</strong><br/>银川市新华东街新华百货2楼</li>
				</ul></dd>
				<dt><span class="icon"></span>营口</dt><dd><ul>
					<li><strong>营口财富广场</strong><br/>辽宁省营口市站前区市府路财富广场壹号1楼</li>
				</ul></dd>
				<dt><span class="icon"></span>张家口</dt><dd><ul>
					<li><strong>张家口百盛购物中心</strong><br/>张家口市桥东区滨河中路2号百盛购物中心3楼</li>
				</ul></dd>
				<dt><span class="icon"></span>长春</dt><dd><ul>
					<li><strong>长春国商</strong><br/>长春市辽宁路2号国商6楼</li>
					<li><strong>长春欧亚商都</strong><br/>长春市朝阳区工农大路1128号欧亚商都5楼</li>
					<li><strong>长春卓展购物中心</strong><br/>长春市重庆路1255号卓展购物中心5楼</li>
				</ul></dd>
				<dt><span class="icon"></span>长治</dt><dd><ul>
					<li><strong>长治东方鸟国际名店</strong><br/>长治市长兴中路658号东方鸟国际名店2楼</li>
				</ul></dd>
				<dt><span class="icon"></span>郑州</dt><dd><ul>
					<li><strong>郑州丹尼斯花园店</strong><br/>郑州市花园路与农业路交叉口东北角丹尼斯花园店9楼</li>
					<li><strong>郑州丹尼斯人民路店</strong><br/>郑州市人民路2号丹尼斯人民店2号馆3楼</li>
				</ul></dd>
				<dt><span class="icon"></span>淄博</dt><dd><ul>
					<li><strong>淄博银座</strong><br/>淄博市张店区柳泉路128号淄博银座3楼 </li>
				</ul></dd>
			</dl>
		</div>
        <!--<div class="subnav" id="huodong_nav">
            <ul>
                <li class="active">进行中</li>
                <li>提前预告</li>
                <li>往期回顾</li>
            </ul>
			<span class="subnav_on"></span>
        </div>
        <div class="huodong_c">
			<div>
				<img src="images/huodong.jpg" alt="">
				<div class="btn_guanzhu"><img src="images/btn_care.png" width="100%" /></div>
			</div>
			<div class="none">
				<img src="images/huodong1.jpg" alt="">
			</div>
			<div class="myhuodong none">
				<ul>
					<img src="images/huodong_ls1.jpg" alt="" />
					<img src="images/huodong_ls3.jpg" alt="" />
					<img src="images/huodong_ls5.jpg" alt="" />
				</ul>
				<ul>
					<img src="images/huodong_ls2.jpg" alt="" />
					<img src="images/huodong_ls4.jpg" alt="" />
					<img src="images/huodong_ls6.jpg" alt="" />
				</ul>
			</div>
        </div>-->
    </div>
    
    <div id="dipan_cont" class="panel">
        <div class="dipan_info">
            <img src="images/02.jpg" alt="" class="face" id="userface">
            <div class="jifen">
                <strong class="strong" id="dipan_screen_name">loding……</strong><br/>
                <!--当前积分 <span id="dipan_points">loding……</span>-->
            </div>
        </div>
        <div class="dipan_nav">
            <ul>
                <li name="mylike"><a href="#mylike" onclick="javascript:ga('timberland.umaman.com','我的地盘_ilike');"><img src="images/dipan_icon1.gif" alt="" class="icon"> i Like</a></li>
                <li name="mytaolun"><a href="#mytaolun" onclick="javascript:ga('timberland.umaman.com','我的地盘_我的讨论');"><img src="images/dipan_icon2.gif" alt="" class="icon"> 我的讨论</a></li>
                <li name="myhuodong"><a href="#myhuodong" onclick="javascript:ga('timberland.umaman.com','我的地盘_我的活动');"><img src="images/dipan_icon3.gif" alt="" class="icon"> 我的活动</a></li>
                <li name="myjifen"><a href="#myjifen" onclick="javascript:ga('timberland.umaman.com','我的地盘_我的积分');"><img src="images/dipan_icon4.gif" alt="" class="icon"> 我的积分</a></li>
                <li name="myziliao"><a href="#myziliao" onclick="javascript:ga('timberland.umaman.com','我的地盘_我的资料');"><img src="images/dipan_icon5.gif" alt="" class="icon"> 我的资料</a></li>
                <li><a href="ajax.php?action=logout" onclick="javascript:ga('timberland.umaman.com','我的地盘_退出帐号');" target="_self">退出帐号</a></li>
            </ul>
        </div>
    </div>
    
    <div id="mylike_cont" class="panel">
        <div class="subnav" id="mylike_nav">
            <ul>
                <li onclick="javascript:ga('timberland.umaman.com','我的地盘_ilike_返回');"><img src="images/jiantou.png" class="jiantou" alt=""></li>
                <li>i Like</li>
            </ul>
        </div>
        <div class="hots">
            <ul id="container1">
            </ul>
        </div>
		<a href="javascript:void(0);" onclick="getMyDatas('ilike');ga('timberland.umaman.com','我的地盘_ilike_查看更多');" class="a_more">查看更多</a>
    </div>
    
    <div id="mytaolun_cont" class="panel">
        <div class="subnav" id="mytaolun_nav">
            <ul>
                <li onclick="javascript:ga('timberland.umaman.com','我的地盘_我的讨论_返回');"><img src="images/jiantou.png" class="jiantou" alt=""></li>
                <li onclick="javascript:ga('timberland.umaman.com','我的地盘_我的讨论_我参与的讨论');" id="mytl_nav1" class="active">我参与的讨论</li>
                <li onclick="javascript:ga('timberland.umaman.com','我的地盘_我的讨论_我发起的讨论');" id="mytl_nav2">我发起的讨论</li>
            </ul>
            <span class="subnav_on"></span>
        </div>
        
        <div class="hots" id="mytaolun_c">
            <ul id="mytl_nav1_cont">
               
            </ul>
            <ul id="mytl_nav2_cont" class="none">
                
            </ul>
        </div>
		<a href="javascript:void(0);" onclick="getMyDatas('repost');ga('timberland.umaman.com','我的地盘_我参与的讨论_查看更多');" class="a_more" id="mytaolun_more0">查看更多</a>
		<a href="javascript:void(0);" onclick="getMyDatas('post');ga('timberland.umaman.com','我的地盘_我发起的讨论_查看更多');" class="a_more none" id="mytaolun_more1">查看更多</a>
    </div>
    
    <div id="myhuodong_cont" class="panel">
        <div class="subnav" id="myhuodong_nav">
            <ul>
                <li onclick="javascript:ga('timberland.umaman.com','我的地盘_我的活动_返回');"><img src="images/jiantou.png" class="jiantou" alt=""></li>
                <li>我的活动</li>
            </ul>
        </div>
        <div class="myhuodong">
            <ul>
            	<!-- 
                <li>
                    <div>奥运英雄联盟<br/>
                    <span class="ison">进行中……</span></div>
                </li>
                <li>
                    <div>添柏岚新品发布<br/>
                    <span class="isover">已结束</span></div>
                </li>
                 -->
            </ul>
        </div>
		<a href="javascript:void(0);" onclick="ga('timberland.umaman.com','我的地盘_我的活动_查看更多');" class="a_more">查看更多</a>
    </div>
    
    <div id="myjifen_cont" class="panel">
        <div class="subnav" id="myjifen_nav">
            <ul>
                <li onclick="javascript:ga('timberland.umaman.com','我的地盘_我的积分_返回');"><img src="images/jiantou.png" class="jiantou" alt=""></li>
                <li onclick="javascript:ga('timberland.umaman.com','我的地盘_我的积分_积分兑换');">积分兑换</li>
                <li onclick="javascript:ga('timberland.umaman.com','我的地盘_我的积分_兑换历史');">兑换历史</li>
                <li onclick="javascript:ga('timberland.umaman.com','我的地盘_我的积分_积分规则');">积分规则</li>
            </ul>
            <span class="subnav_on"></span>
        </div>
		<div id="myjifen_div">
			<!--<img src="images/huodong1.jpg" alt="">-->
			<div class="myjifen">
				<ul>
					<img src="images/huodong1.jpg" width="100%" alt="">
					<!--<li>
						<img src="images/06.jpg" alt="" class="pic">
						<span class="info">
							<span class="name">Timberland珍藏版靴款</span><br/>
							所需积分：<br/>
							<span class="fenshu">9000</span>
						</span>
						<a href="javascript:;" class="duihuan duihuan1">积分不足</a>
					</li>
					<li>
						<img src="images/07.jpg" alt="" class="pic">
						<span class="info">
							<span class="name">Timberland珍藏版靴款</span><br/>
							所需积分：<br/>
							<span class="fenshu">9000</span>
						</span>
						<a href="javascript:;" class="duihuan duihuan1">积分不足</a>
					</li>
					<li>
						<img src="images/08.jpg" alt="" class="pic">
						<span class="info">
							<span class="name">Timberland珍藏版靴款</span><br/>
							所需积分：<br/>
							<span class="fenshu">9000</span>
						</span>
						<a href="javascript:;" class="duihuan duihuan1">积分不足</a>
					</li>
					<li>
						<img src="images/06.jpg" alt="" class="pic">
						<span class="info">
							<span class="name">Timberland珍藏版靴款</span><br/>
							所需积分：<br/>
							<span class="fenshu">9000</span>
						</span>
						<a href="javascript:;" class="duihuan duihuan1">积分不足</a>
					</li>-->
				</ul>
			</div>
			<div class="myjifen none">
				<img src="images/huodong1.jpg" width="100%" alt="">
				<!--<ul>
					<li>
						<img src="images/06.jpg" alt="" class="pic">
						<span class="info">
							<span class="name">Timberland珍藏版靴款</span><br/>
							兑换积分：<br/>
							<span class="fenshu">9000</span>
						</span>
					</li>
				</ul>-->
			</div>
			<div class="none">
				<img src="images/rule.gif" width="100%" alt="" />
			</div>
		</div>
		<!--<a href="javascript:void(0);" class="a_more">查看更多</a>-->
    </div>
    
    <div id="myziliao_cont" class="panel">
        <div class="dipan_info">
            <img src="images/02.jpg" alt="" class="face" id="userface1">
            <div class="jifen">
                <strong class="strong">TimberlandChina</strong>欢迎来到添柏岚俱乐部<br/>
                完善个人资料。<!--赠送 <span>0</span> 个积分！-->
            </div>
        </div>
		<div class="myziliao">
			<span class="span">请填写您在添柏岚俱乐部的联系方式，<br/>
			以便兑换奖品后工作人员能及时联系到您。</span><br/>
			<label>所在城市<select name="province" id="province" class="select"><!-- onclick="javascript:alert(1111);"-->
			<?php foreach($provinces as $province) {?>
				<option value="<?php echo $province;?>" <?php if($_SESSION['userInfo']['timberland']['province']==$province){?>selected="selected"<?php }?>><?php echo $province;?></option>
			<?php }?>
			</select></label><br/>
			<label>真实姓名 <input name="name" id="name" type="text" value="<?php echo $_SESSION['userInfo']['timberland']['name'];?>" class="input"></label><br/>
			<label>手机号码 <input name="mobile" id="mobile" type="text" value="<?php echo $_SESSION['userInfo']['timberland']['mobile'];?>" class="input"></label><br/>
			<label>联系地址 <textarea name="address" id="address" class="input textarea"><?php echo $_SESSION['userInfo']['timberland']['address'];?></textarea></label>
			<input type="button" value="提交资料 开始体验添柏岚俱乐部" class="btn_submit" id="btn_personal_data_submit" onclick="javascript:ga('timberland.umaman.com','我的地盘_个人资料_提交');">
		</div>
    </div>
    
    
 
    <div class="footer_nav none">
        <ul>
            <li><?php if(isset($_SESSION['umaId'])){?><a href="ajax.php?action=logout">退出</a><?php }?></li>
            <li><?php if(isset($_SESSION['userInfo'])){ echo $_SESSION['userInfo']['screen_name']; }?></li>
            <li>TOP</li>
        </ul>
    </div>  
    <!--浮动导航-->
    <div class="nav1">
        <ul>
            <li><a href="#index" onclick="javascript:ga('timberland.umaman.com','浮动导航_首页');"><img src="images/nav1.png" alt=""><img src="images/nav1on.png" alt="" class="none"></a></li>
            <li><a href="#xingxiu" onclick="javascript:ga('timberland.umaman.com','浮动导航_最佳推荐');"><img src="images/nav2.png" alt="" class="none"><img src="images/nav2on.png" alt=""></a></li>
            <li><a href="#redian" onclick="javascript:ga('timberland.umaman.com','浮动导航_最新排行');"><img src="images/nav3.png" alt=""><img src="images/nav3on.png" alt="" class="none"></a></li>
            <li><a href="#huodong" onclick="javascript:ga('timberland.umaman.com','浮动导航_店铺查询');"><img src="images/nav4.png" alt=""><img src="images/nav4on.png" alt="" class="none"></a></li>
            <li><a href="#dipan" onclick="javascript:ga('timberland.umaman.com','浮动导航_我的地盘');" class="nav1dipan"><img src="images/nav5.png" alt=""><img src="images/nav5on.png" alt="" class="none"></a></li>
        </ul>
        <span class="nav_on1"></span>
    </div>
    <div class="btn_fudong"><img src="images/fudong_btn.png" alt="" onclick="javascript:ga('timberland.umaman.com','浮动导航_下拉收起');"></div>
    <!--输入框-->
    
    
    
    <!-- 转发和评论窗口 -->
    <div class="mask none"></div>
	<div class="loading">
		<img src="images/loading.gif" alt="">
	</div>
    <div class="zhuanfa none">
        
    </div>
</div>
<div class="bottom"><img src="images/footer.gif" alt="" class="block"></div>
<!--<img src="" alt="" class="img_home">-->
<div class="mask"></div>
<div class="loading">
	<img src="images/loading.gif" alt="">
</div>
<div class="bigpic" onclick="hideBigPic()">
	<div><img src="" alt="" /></div>
</div>
<img src="images/jiaoyin.png" alt="" class="jiaoyin" onclick="javascript:ga('timberland.umaman.com','左下角_脚印');">
<div class="xiedai">
	<ul>
		<a href="#mylike" class="xddipan1" onclick="javascript:ga('timberland.umaman.com','左下角_ilike');"><li class="li1"></li></a>
		<a href="#mytaolun" class="xddipan2" onclick="javascript:ga('timberland.umaman.com','左下角_我的讨论');"><li class="li2"></li></a>
		<a href="#myhuodong" class="xddipan3" onclick="javascript:ga('timberland.umaman.com','左下角_我的活动');"><li class="li3"></li></a>
		<a href="#myjifen" class="xddipan4" onclick="javascript:ga('timberland.umaman.com','左下角_我的积分');"><li class="li4"></li></a>
		<a href="#myziliao" class="xddipan5" onclick="javascript:ga('timberland.umaman.com','左下角_我的资料');"><li class="li5"></li></a>
		<a href="javascript:window.location.reload();" onclick="javascript:ga('timberland.umaman.com','左下角_刷新');"><li class="li6"></li></a>
	</ul>
</div>
<script type="text/javascript"> 
addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
function hideURLbar(){
	window.scrollTo(0,1);
}
</script>
<?php include("footer.php");?>