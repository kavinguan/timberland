<?php include("header.php");?>
<div class="cont">
    <div class="nav">
        <ul>
            <li><a href="index.php"><img src="images/nav1.png" alt=""><img src="images/nav1on.png" alt="" class="none"></a></li>
            <li><a href="#xingxiu"><img src="images/nav2.png" alt="" class="none"><img src="images/nav2on.png" alt=""></a></li>
            <li><a href="#redian"><img src="images/nav3.png" alt=""><img src="images/nav3on.png" alt="" class="none"></a></li>
            <li><a href="#huodong"><img src="images/nav4.png" alt=""><img src="images/nav4on.png" alt="" class="none"></a></li>
            <!--<li><a href="#dipan" onclick="check_login()"><img src="images/nav5.png" alt=""><img src="images/nav5on.png" alt="" class="none"></a></li>-->
            <li><a href="javascript:;" onclick="javascript:if(check_login()){ window.location.href='show.php#dipan'};"><img src="images/nav5.png" alt=""><img src="images/nav5on.png" alt="" class="none"></a></li>
        </ul>
        <span class="nav_on"></span>
    </div>
    
    <div id="xingxiu_cont" class="panel" selectgkf="true">
        <div class="banners">
            <ul>
                <li><img src="images/banner1.jpg" alt=""></li>
                <li><img src="images/banner1.jpg" alt=""></li>
                <li><img src="images/banner1.jpg" alt=""></li>
                <li><img src="images/banner1.jpg" alt=""></li>
            </ul>
        </div>
        
        <div class="subnav">
            <ul>
                <li id="xingxiu_all" class="active">最　新</li>
                <li id="xingxiu_hot">热　门</li>
                <li id="xingxiu_new">推　荐</li> 
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
        
        <a href="javascript:void(0);" onclick="get_xingxiu_more(xingxiu_click_type);" class="a_more">查看更多</a>
        
    </div>
    
    <div id="xingxiuc_cont" class="panel">
        <div class="pictie">
            <img src="images/05.jpg" alt="" class="peitu">
            <div class="pictie_c">
                <div class="louzhu">
                    <span class="plnum"><img src="images/heart.png" alt=""> Loading……</span>
                    <img src="images/02.jpg" class="face">TimberlandChina <img src="images/v.gif" alt="">
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
        
        <div class="subnav">
            <ul>
                <li id="top_all" class="active">最　新</li>
                <li id="top_hot">热　门</li>
                <li id="top_new">推　荐</li>
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
        
        <a href="javascript:;" onclick="get_top_more(top_click_type);" class="a_more1">查看更多</a>
    </div>
    
    <div id="huodong_cont" class="panel">
        <div class="subnav" id="huodong_nav">
            <ul>
                <li class="active">进行中</li>
                <li>提前预告</li>
                <li>往期回顾</li>
            </ul>
            <span class="subnav_on"></span>
        </div>
        <div class="huodong_c">
            <img src="images/huodong.jpg" alt="">
            <span class="num">参与人数<br/><strong>5862</strong></span>
        </div>
    </div>
    
    <div id="dipan_cont" class="panel">
        <div class="dipan_info">
            <img src="images/02.jpg" alt="" class="face">
            <div class="jifen">
                <strong class="strong">TimberlandChina</strong><br/>
                当前积分 <span>9888</span>
            </div>
        </div>
        <div class="dipan_nav">
            <ul>
                <li name="mylike"><a href="javascript:;"><img src="images/dipan_icon1.gif" alt="" class="icon"> i Like</a></li>
                <li name="mytaolun"><a href="javascript:;"><img src="images/dipan_icon2.gif" alt="" class="icon"> 我的讨论</a></li>
                <li name="myhuodong"><a href="javascript:;"><img src="images/dipan_icon3.gif" alt="" class="icon"> 我的活动</a></li>
                <li name="myjifen"><a href="javascript:;"><img src="images/dipan_icon4.gif" alt="" class="icon"> 我的积分</a></li>
                <li name="myziliao"><a href="javascript:;"><img src="images/dipan_icon5.gif" alt="" class="icon"> 我的资料</a></li>
                <li><a href="javascript:;">退出帐号</a></li>
            </ul>
        </div>
    </div>
    
    <div id="mylike_cont" class="panel">
        <div class="subnav" id="mylike_nav">
            <ul>
                <li>←</li>
                <li>i Like</li>
            </ul>
        </div>
        <div class="pubu">
            <ul id="container1">
                <li class="item">
                    <img src="images/01.jpg" alt="" class="pic">
                    <div class="picname">
                        天气可以说变就变，你不能
                    </div>
                </li>
                <li class="item">
                    <img src="images/01.jpg" alt="" class="pic">
                    <div class="picname">
                        经典黄靴
                    </div>
                </li>
            </ul>
			<ul>
                <li class="item">
                    <img src="images/03.jpg" alt="" class="pic">
                    <div class="picname">
                        迎接挑战
                    </div>
                </li>
			</ul>
        </div>
    </div>
    
    <div id="mytaolun_cont" class="panel">
        <div class="subnav" id="mytaolun_nav">
            <ul>
                <li>←</li>
                <li id="mytl_nav1" class="active">我参与的讨论</li>
                <li id="mytl_nav2">我发起的讨论</li>
            </ul>
            <span class="subnav_on"></span>
        </div>
        
        <div class="hots" id="mytaolun_c">
            <ul id="mytl_nav1_cont">
                <li>
                    <img src="images/02.jpg" alt="" class="face">
                    <div class="div">
                        <strong class="name">一林一山</strong><br/>
                        船长威武<br/>
                        <div class="yinyong">夏天将至，收到了来自timberland的帆船鞋！于是....我找到了正确的使用方法[偷笑] 谁叫人家是＂帆船＂鞋呢[嘻嘻] 对吧？船长<br/>
                        <img src="images/04.jpg" alt="" class="img"></div>
                        <a href="javascript:showFabiao('zf');"><span class="plnum1"><img src="images/topic_icon.gif" alt=""> 1568</span></a>　<span class="from">添柏岚俱乐部</span><br/><a href="#" class="a_zf">收藏</a><a href="javascript:showFabiao('pl');" class="a_zf">评论</a><a href="javascript:showFabiao('zf');" class="a_zf">转发</a>
                        <span class="plnum">昨天 09:30</span>
                    </div>
                </li>
                <li>
                    <img src="images/02.jpg" alt="" class="face">
                    <div class="div">
                        <strong class="name">一林一山</strong><br/>
                        船长威武<br/>
                        <div class="yinyong">夏天将至，收到了来自timberland的帆船鞋！于是....我找到了正确的使用方法[偷笑] 谁叫人家是＂帆船＂鞋呢[嘻嘻] 对吧？船长<br/>
                        <img src="images/04.jpg" alt="" class="img"></div>
                        <a href="javascript:showFabiao('zf');"><span class="plnum1"><img src="images/topic_icon.gif" alt=""> 1568</span></a>　<span class="from">添柏岚俱乐部</span><br/><a href="#" class="a_zf">收藏</a><a href="javascript:showFabiao('pl');" class="a_zf">评论</a><a href="javascript:showFabiao('zf');" class="a_zf">转发</a>
                        <span class="plnum">昨天 09:30</span>
                    </div>
                </li>
                <li>
                    <img src="images/02.jpg" alt="" class="face">
                    <div class="div">
                        <strong class="name">一林一山</strong><br/>
                        船长威武<br/>
                        <div class="yinyong">夏天将至，收到了来自timberland的帆船鞋！于是....我找到了正确的使用方法[偷笑] 谁叫人家是＂帆船＂鞋呢[嘻嘻] 对吧？船长<br/>
                        <img src="images/04.jpg" alt="" class="img"></div>
                        <a href="javascript:showFabiao('zf');"><span class="plnum1"><img src="images/topic_icon.gif" alt=""> 1568</span></a>　<span class="from">添柏岚俱乐部</span><br/><a href="#" class="a_zf">收藏</a><a href="javascript:showFabiao('pl');" class="a_zf">评论</a><a href="javascript:showFabiao('zf');" class="a_zf">转发</a>
                        <span class="plnum">昨天 09:30</span>
                    </div>
                </li>
            </ul>
            <ul id="mytl_nav2_cont" class="none">
                <li>
                    <img src="images/02.jpg" alt="" class="face">
                    <div class="div">
                        <strong class="name">一林一山</strong><br/>
                        夏天将至，收到了来自timberland的帆船鞋！于是....我找到了正确的使用方法[偷笑] 谁叫人家是＂帆船＂鞋呢[嘻嘻] 对吧？船长<br/>
                        <img src="images/04.jpg" alt="" class="img"><br/>
                        <a href="javascript:showFabiao('zf');"><span class="plnum1"><img src="images/topic_icon.gif" alt=""> 1568</span></a>　<span class="from">添柏岚俱乐部</span><br/><a href="#" class="a_zf">收藏</a><a href="javascript:showFabiao('pl');" class="a_zf">评论</a><a href="javascript:showFabiao('zf');" class="a_zf">转发</a>
                        <span class="plnum">昨天 09:30</span>
                    </div>
                </li>
                <li>
                    <img src="images/02.jpg" alt="" class="face">
                    <div class="div">
                        <strong class="name">一林一山</strong><br/>
                        夏天将至，收到了来自timberland的帆船鞋！于是....我找到了正确的使用方法[偷笑] 谁叫人家是＂帆船＂鞋呢[嘻嘻] 对吧？船长<br/>
                        <img src="images/04.jpg" alt="" class="img"><br/>
                        <a href="javascript:showFabiao('zf');"><span class="plnum1"><img src="images/topic_icon.gif" alt=""> 1568</span></a>　<span class="from">添柏岚俱乐部</span><br/><a href="#" class="a_zf">收藏</a><a href="javascript:showFabiao('pl');" class="a_zf">评论</a><a href="javascript:showFabiao('zf');" class="a_zf">转发</a>
                        <span class="plnum">昨天 09:30</span>
                    </div>
                </li>
                <li>
                    <img src="images/02.jpg" alt="" class="face">
                    <div class="div">
                        <strong class="name">一林一山</strong><br/>
                        夏天将至，收到了来自timberland的帆船鞋！于是....我找到了正确的使用方法[偷笑] 谁叫人家是＂帆船＂鞋呢[嘻嘻] 对吧？船长<br/>
                        <img src="images/04.jpg" alt="" class="img"><br/>
                        <a href="javascript:showFabiao('zf');"><span class="plnum1"><img src="images/topic_icon.gif" alt=""> 1568</span></a>　<span class="from">添柏岚俱乐部</span><br/><a href="#" class="a_zf">收藏</a><a href="javascript:showFabiao('pl');" class="a_zf">评论</a><a href="javascript:showFabiao('zf');" class="a_zf">转发</a>
                        <span class="plnum">昨天 09:30</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    
    <div id="myhuodong_cont" class="panel">
        <div class="subnav" id="myhuodong_nav">
            <ul>
                <li>←</li>
                <li>我的活动</li>
            </ul>
        </div>
        <div class="myhuodong">
            <ul>
                <li>
                    <div>奥运英雄联盟<br/>
                    <span class="ison">进行中……</span></div>
                </li>
                <li>
                    <div>添柏岚新品发布<br/>
                    <span class="isover">已结束</span></div>
                </li>
            </ul>
        </div>
    </div>
    
    <div id="myjifen_cont" class="panel">
        <div class="subnav" id="myjifen_nav">
            <ul>
                <li>←</li>
                <li>积分兑换</li>
                <li>兑换历史</li>
                <li>积分规则</li>
            </ul>
            <span class="subnav_on"></span>
        </div>
        <div class="myjifen">
            <ul>
                <li>
					<img src="images/06.jpg" alt="" class="pic">
					<span class="info">
						<span class="name">Timberland珍藏版靴款</span><br/>
						所需积分：<br/>
						<span class="fenshu">9000</span>
					</span>
                    <a href="javascript:;" class="duihuan">我要兑换</a>
                </li>
                <li>
					<img src="images/07.jpg" alt="" class="pic">
					<span class="info">
						<span class="name">Timberland珍藏版靴款</span><br/>
						所需积分：<br/>
						<span class="fenshu">9000</span>
					</span>
                    <a href="javascript:;" class="duihuan">我要兑换</a>
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
                </li>
            </ul>
        </div>
    </div>
    
    <div id="myziliao_cont" class="panel">
        <div class="dipan_info">
            <img src="images/02.jpg" alt="" class="face">
            <div class="jifen">
                <strong class="strong">TimberlandChina</strong>欢迎来到添柏岚俱乐部<br/>
                完善个人资料。赠送 <span><?php echo $_SESSION['userInfo']['timberland']['points'];?></span> 个积分！
            </div>
        </div>
		<div class="myziliao">
			<span class="span">请填写您在添柏岚俱乐部的联系方式，<br/>
			以便兑换奖品后工作人员能及时联系到您。</span><br/>
			<label>所在城市<select name="province" id="province" class="select">
			<?php foreach($provinces as $province) {?>
				<option value="<?php echo $province;?>" <?php if($_SESSION['userInfo']['timberland']['province']==$province){?>selected="selected"<?php }?>><?php echo $province;?></option>
			<?php }?>
			</select></label><br/>
			<label>真实姓名 <input name="name" id="name" type="text" value="<?php echo $_SESSION['userInfo']['timberland']['name'];?>" class="input"></label><br/>
			<label>手机号码 <input name="mobile" id="mobile" type="text" value="<?php echo $_SESSION['userInfo']['timberland']['mobile'];?>" class="input"></label><br/>
			<label>联系地址 <textarea name="address" id="address" class="input textarea"><?php echo $_SESSION['userInfo']['timberland']['address'];?></textarea></label>
			<input type="button" value="提交资料 开始体验添柏岚俱乐部" class="btn_submit" id="btn_personal_data_submit">
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
            <li><a href="index.php"><img src="images/nav1.png" alt=""><img src="images/nav1on.png" alt="" class="none"></a></li>
            <li><a href="#xingxiu"><img src="images/nav2.png" alt="" class="none"><img src="images/nav2on.png" alt=""></a></li>
            <li><a href="#redian"><img src="images/nav3.png" alt=""><img src="images/nav3on.png" alt="" class="none"></a></li>
            <li><a href="#huodong"><img src="images/nav4.png" alt=""><img src="images/nav4on.png" alt="" class="none"></a></li>
            <li><a href="#dipan"><img src="images/nav5.png" alt=""><img src="images/nav5on.png" alt="" class="none"></a></li>
        </ul>
        <span class="nav_on1"></span>
    </div>
    <div class="btn_fudong"><img src="images/fudong_btn.png" alt=""></div>
    <!--输入框-->
    
    
    
    <!-- 转发和评论窗口 -->
    <div class="mask none"></div>
	<div class="loading">
		<img src="images/loading.gif" alt="">
	</div>
    <div class="zhuanfa none">
        
    </div>
<img src="images/jiaoyin.png" alt="" class="jiaoyin">
<div class="xiedai">
	<ul>
		<li class="li1"></li>
		<li class="li2"></li>
		<li class="li3"></li>
		<li class="li4"></li>
		<li class="li5"></li>
		<li class="li6"></li>
	</ul>
</div>
    
    
    
</div>
<?php include("footer.php");?>
