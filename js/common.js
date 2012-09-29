// JavaScript Document
Zepto(function($){
	$(".index_btn a").bind("touchstart",function(){
		var src = $(this).find("img").attr("src");
		if(src.substr(src.length-6,2) == "on") return;
		src = src.substr(0,src.length-4);
		$(this).find("img").attr("src",src+"on.gif");
	});
	$(".index_btn a").bind("touchend",function(){
		var src = $(this).find("img").attr("src");
		src = src.substr(0,src.length-6);
		$(this).find("img").attr("src",src+".gif");
	});
	
	$(".dipan_nav li").bind("touchstart",function(){
		$(".dipan_nav li").removeAttr("checked");
		$(this).attr("checked","true");
	});
	$(".dipan_nav li").bind("touchend",function(){
		$(this).removeAttr("checked");
	});
	
	$(".index_btn a").each(function(i){
		$(this).click(function(){
			var name = $(this).attr("href");
			name = name.substr(1,name.length);
			$(".panel").attr("selectgkf","");
			$("#"+name+"_cont").attr("selectgkf","true");
			notpageindex();
			$(".nav_on,.nav_on1").css("-webkit-transition","-webkit-transform 500ms ease-in-out");
			$(".nav_on,.nav_on1").css("-webkit-transform","translate3d("+navwidth*(i+1)+"px, 0px, 0px)");
			$(".nav li img:nth-child(1)").show();
			$(".nav1 li img:nth-child(1)").show();
			$(".nav li img:nth-child(2)").hide();
			$(".nav1 li img:nth-child(2)").hide();
			$(".nav li:nth-child("+(i+2)+")").find("img:nth-child(1)").hide();
			$(".nav1 li:nth-child("+(i+2)+")").find("img:nth-child(1)").hide();
			$(".nav li:nth-child("+(i+2)+")").find("img:nth-child(2)").show();
			$(".nav1 li:nth-child("+(i+2)+")").find("img:nth-child(2)").show();
			if(name == "xingxiu") {
				if(xingxiu_all_start == 0)
					get_xingxiu_more(xingxiu_click_type);
			}
			if(name == "redian") {
				if(top_all_start == 0)
					get_top_more(top_click_type);
			}
		});
	});
	
	var navwidth = $(".top").width()/5;
	var navheight = navwidth/128*88;
	$(".nav1").width($(".top").width());
	$(".nav,.nav1").find("img").height(navheight);
	$(".nav,.nav1").height(navheight);
	$(".nav li").each(function(i) {
		$(this).click(function(){
			$(".zhuanfa").hide();
			$(".nav_on,.nav_on1").css("-webkit-transition","-webkit-transform 500ms ease-in-out");
			$(".nav_on,.nav_on1").css("-webkit-transform","translate3d("+navwidth*i+"px, 0px, 0px)");
			setTimeout(function(){
				$(".nav li img:nth-child(1)").show();
				$(".nav1 li img:nth-child(1)").show();
				$(".nav li img:nth-child(2)").hide();
				$(".nav1 li img:nth-child(2)").hide();
				$(".nav li:nth-child("+(i+1)+")").find("img:nth-child(1)").hide();
				$(".nav1 li:nth-child("+(i+1)+")").find("img:nth-child(1)").hide();
				$(".nav li:nth-child("+(i+1)+")").find("img:nth-child(2)").show();
				$(".nav1 li:nth-child("+(i+1)+")").find("img:nth-child(2)").show();
			},500);
			var name = $(this).find("a").attr("href");
			name = name.substr(1,name.length);
			$(".panel").attr("selectgkf","");
			$("#"+name+"_cont").attr("selectgkf","true");
			if(name != "index") {
				notpageindex();
			} else {
				ispageindex();
			}
			if(name == "redian") {
				$(".fayan").height($(".fabiao .face").height());
				$(".fayan").css("line-height",$(".fabiao .face").height()+"px");
			}
			if(name == "xingxiu") {
				if(xingxiu_all_start == 0)
					get_xingxiu_more(xingxiu_click_type);
			}
			if(name == "redian") {
				if(top_all_start == 0)
					get_top_more(top_click_type);
			}
		});
	});
	$(".nav1").click(function(){
		$(".nav1").css("top",-navheight);
		$(".btn_fudong").css({"top":-$(".top").width()/640*25-navheight});
	});
	$(".nav1 li").each(function(i) {
		$(this).click(function(){
			$(".zhuanfa").hide();
			$(".nav_on,.nav_on1").css("-webkit-transition","-webkit-transform 500ms ease-in-out");
			$(".nav_on,.nav_on1").css("-webkit-transform","translate3d("+navwidth*i+"px, 0px, 0px)");
			setTimeout(function(){
				$(".nav li img:nth-child(1)").show();
				$(".nav1 li img:nth-child(1)").show();
				$(".nav li img:nth-child(2)").hide();
				$(".nav1 li img:nth-child(2)").hide();
				$(".nav li:nth-child("+(i+1)+")").find("img:nth-child(1)").hide();
				$(".nav1 li:nth-child("+(i+1)+")").find("img:nth-child(1)").hide();
				$(".nav li:nth-child("+(i+1)+")").find("img:nth-child(2)").show();
				$(".nav1 li:nth-child("+(i+1)+")").find("img:nth-child(2)").show();
			},500);
			var name = $(this).find("a").attr("href");
			name = name.substr(1,name.length);
			$(".panel").attr("selectgkf","");
			$("#"+name+"_cont").attr("selectgkf","true");
			if(name != "index") {
				notpageindex();
			} else {
				ispageindex();
			}
			if(name == "redian") {
				$(".fayan").height($(".fabiao .face").height());
				$(".fayan").css("line-height",$(".fabiao .face").height()+"px");
			}
			if(name == "xingxiu") {
				if(xingxiu_all_start == 0)
					get_xingxiu_more(xingxiu_click_type);
			}
			if(name == "redian") {
				if(top_all_start == 0)
					get_top_more(top_click_type);
			}
		});
	});
	
	var subnavwidth = $(".top").width()/3;
	var subnavwidth0 = $(".top").width()/2;
	var subnavwidth1 = $(".top").width()/4;
	var subnavwidth2 = $(".top").width()*0.27;
	var subnavwidth3 = $(".top").width()*0.09;
	$("#mytaolun_nav .subnav_on").css("-webkit-transform","translate3d("+subnavwidth2+"px, 0px, 0px)");
	$("#myjifen_nav .subnav_on").css("-webkit-transform","translate3d("+subnavwidth1+"px, 0px, 0px)");
	$(".subnav").each(function(a) {
		$(this).find("li").each(function(i) {
			var li_id = $(this).attr("id");
			
			$(this).click(function(){
				var curr = $(this).parents(".panel").attr("id");
				var subnavid = $(this).parents(".subnav").attr("id");
				if(subnavid == "myjifen_nav") {
					$(this).parent().next("span").css("-webkit-transform","translate3d("+subnavwidth1*i+"px, 0px, 0px)");
				}
				else if(subnavid == "tuijian_nav" || subnavid == "redian_nav") {
					$(this).parent().next("span").css("-webkit-transform","translate3d("+subnavwidth0*i+"px, 0px, 0px)");
				}
				else if(subnavid == "mytaolun_nav") {
					var juli = subnavwidth2*i+subnavwidth3*(i-1);
					$(this).parent().next("span").css("-webkit-transform","translate3d("+juli+"px, 0px, 0px)");
				}
				else {
					$(this).parent().next("span").css("-webkit-transform","translate3d("+subnavwidth*i+"px, 0px, 0px)");
				}
				setTimeout(function(){
					$($(".subnav")[a]).find("li").removeClass("active");
					$($(".subnav")[a]).find("li:nth-child("+(i+1)+")").addClass("active");
					
					//显示相应的页面元素
					if(li_id=='xingxiu_hot') {
						if(xingxiu_hot_start == 0)
							get_xingxiu_more('hot');
						xingxiu_click_type = 'hot';
						$("#xingxiu_cont .pubu").hide();
						$("#xingxiu_"+xingxiu_click_type+"_content").show();
					}
					else if(li_id=='xingxiu_new') {
						if(xingxiu_new_start == 0)
							get_xingxiu_more('new');
						xingxiu_click_type = 'new';
						$("#xingxiu_cont .pubu").hide();
						$("#xingxiu_"+xingxiu_click_type+"_content").show();
					}
					else if(li_id=='xingxiu_all') {
						if(xingxiu_all_start == 0)
							get_xingxiu_more('all');
						xingxiu_click_type = 'all';
						$("#xingxiu_cont .pubu").hide();
						$("#xingxiu_"+xingxiu_click_type+"_content").show();
					}
					else if(li_id=='top_all') {
						if(top_all_start == 0)
							get_top_more('all');
						top_click_type = 'all';
						$("#redian_cont .hots").hide();
						$("#top_"+top_click_type+"_content").show();
					}
					else if(li_id=='top_hot') {
						if(top_hot_start == 0)
							get_top_more('hot');
						top_click_type = 'hot';
						$("#redian_cont .hots").hide();
						$("#top_"+top_click_type+"_content").show();
					}
					else if(li_id=='top_new') {
						if(top_new_start == 0)
							get_top_more('new');
						top_click_type = 'new';
						$("#redian_cont .hots").hide();
						$("#top_"+top_click_type+"_content").show();
					}
					
				},500);
			});
		});
	});
	
	function picscroll(classname) {
		var picindex = 0;
		var picnum = $("."+classname+" li").length;
		$("."+classname+" ul").swipeLeft(function(){
			var picwidth = $("."+classname+" img").width();
			if(picindex == picnum-1) return;
			picindex++;
			$("."+classname+" ul").css("-webkit-transform","translate3d(-"+picwidth*picindex+"px, 0px, 0px)");
		});
		$("."+classname+" ul").swipeRight(function(){
			var picwidth = $("."+classname+" img").width();
			if(picindex == 0) return;
			picindex--;
			$("."+classname+" ul").css("-webkit-transform","translate3d(-"+picwidth*picindex+"px, 0px, 0px)");
		});
	}
	picscroll("banners1");
	//picscroll("banners2");
	
	var is2nav = 0;
	var awidth = $(window).width();
	var ftop = awidth/640*25;
	function subpageLoad() {
		var name = window.location.href;
		if(name.indexOf("#") == -1) {
			name = "index";
		}
		if(name.substr(name.indexOf("#")+1,name.length) == "") return;
		name = name.substr(name.indexOf("#")+1,name.length);
		if(name != "index") {
			notpageindex();
		} else {
			ispageindex();
		}
		if(name == "mylike") getMyDatas('ilike');
		if(name == "mytaolun") getMyDatas('repost');
		var node = {"index":0,"xingxiu":1,"redian":2,"huodong":3,"dipan":4,"mylike":4,"mytaolun":4,"myhuodong":4,"myjifen":4,"myziliao":4};
		$(".panel").attr("selectgkf","");
		$("#"+name+"_cont").attr("selectgkf","true");
		$(".nav_on,.nav_on1").css("-webkit-transition","-webkit-transform 0ms ease-in-out");
		$(".nav_on,.nav_on1").css("-webkit-transform","translate3d("+navwidth*node[name]+"px, 0px, 0px)");
		$(".nav li img:nth-child(1),.nav1 li img:nth-child(1)").show(500);
		$(".nav li img:nth-child(2),.nav1 li img:nth-child(2)").hide(500);
		$(".nav li:nth-child("+(node[name]+1)+"),.nav1 li:nth-child("+(node[name]+1)+")").find("img:nth-child(1)").hide(500);
		$(".nav li:nth-child("+(node[name]+1)+"),.nav1 li:nth-child("+(node[name]+1)+")").find("img:nth-child(2)").show(500);
		$(".nav1").css("top",-navheight);
		$(".nav1").show();
		$(".btn_fudong").css({"top":-(ftop+navheight),"left":$(".top").width()*85.6/100});
		$(".btn_fudong").click(function(){
			if(is2nav == 0) {
				$(".nav1").animate({"top":0},500);
				$(".btn_fudong").animate({"top":navheight},500);
				is2nav = 1;
			}
			else {
				$(".nav1").animate({"top":-navheight},500);
				$(".btn_fudong").animate({"top":-ftop},500);
				is2nav = 0;
			}
		});
		if(node[name] == 4) {
			loadMyInfo();
		}
		//转发弹层
		$(".zhuanfa_title").css({height:awidth/640*56,"line-height":awidth/640*80+"px"});
		setTimeout(function(){$(".zhuanfa_btns").css({height:$(".zhuanfa_btns .right").height(),"line-height":$(".zhuanfa_btns .right").height()+"px"});},500);
		//
		$(".pictie_nav").css({height:awidth/640*53+1,"line-height":awidth/640*53+"px"});
	}
	subpageLoad();
	
	var isdown = 0;
	$(window).scroll(function(){
		if(document.body.scrollTop >= 300 || window.pageYOffset >= 300) {
			$(".btn_fudong").animate({"top":navheight+ftop},500);
			isdown = 1;
		}
		else {
			$(".btn_fudong").animate({"top":-(navheight+ftop)},500);
			isdown = 0;
		}
		if(isdown == 1) {
			$(".nav1").animate({"top":-navheight},500);
			$(".btn_fudong").animate({"top":-ftop},500);
			is2nav = 0;
		}
	});
	
	
	$("#xingxiu_cont .pubu li").click(showXingxiu);
	
	$(".pictie_nav li").each(function(i) {
		$(this).click(function(){
			$(".pictie_nav li").removeClass("active");
			$(".pictie_hf ul").hide();
			$(this).addClass("active");
			$(".pictie_hf ul:nth-child("+(i+1)+")").show();
		});
	});
	//最新活动
	$("#huodong_nav li").each(function(i) {
		$(this).click(function(){
			$(".huodong_c > div").hide();
			$(".huodong_c > div:nth-child("+(i+1)+")").show();
		});
	});
	//我的积分
	$("#myjifen_nav li:not(:first-child)").each(function(i) {
		$(this).click(function(){
			$("#myjifen_div > div").hide();
			$("#myjifen_div > div:nth-child("+(i+1)+")").show();
		});
	});
	//我的地盘内按钮
	$(".dipan_nav li:not(:last-child)").each(function(i) {
		$(this).click(function(){
			var name = $(this).find("a").attr("href");
			name = name.substr(name.indexOf("#")+1,name.length);
			$(".panel").attr("selectgkf","");
			$("#"+name+"_cont").attr("selectgkf","true");
			if(i == 0) {
				getMyDatas('ilike');
			}
			if(i == 1) {
				getMyDatas('repost');
			}
		});
	});
	//我的讨论按钮
	$("#mytaolun_nav li:not(:first-child)").each(function(i) {
		$(this).click(function(){
			getMyDatasType = i==0 ? 'repost' : 'post';
			getMyDatas(getMyDatasType);
			$("#mytaolun_c ul").hide();
			$("#mytaolun_c ul:nth-child("+(i+1)+")").show();
			$("#mytaolun_cont .a_more").hide();
			$("#mytaolun_more"+i).show();
		});
	});
	//我的活动
	$(".myhuodong li:first-child").click(function() {
		$(".panel").removeAttr("selectgkf");
		$("#huodong_cont").attr("selectgkf","true");
	});
	//我的地盘子内容第一个标签
	$("#mylike_cont .subnav li:first-child, #mytaolun_cont .subnav li:first-child, #myhuodong_cont .subnav li:first-child, #myjifen_cont .subnav li:first-child").bind("click",function(){
		$(".panel").attr("selectgkf","");
		$("#dipan_cont").attr("selectgkf","true");
	});
	//鞋带
	var xiedai = 0;
	$(".xiedai").height($(".xiedai").width()*339/204);
	$(".xiedai").css({"left":$(".jiaoyin").width()*1.1,"bottom":$(".jiaoyin").width()*1.2});
	$(".xiedai").css("display","none");
	$(".jiaoyin").bind("click",xiedaiClick);
	function xiedaiClick() {
		if(xiedai == 0) {
			$(".xiedai").css("display","block");
			$(".xiedai").animate({"opacity":1},500);
			setTimeout(function(){$(".xiedai li").addClass("active");},500);
			xiedai = 1;
		}
		else if(xiedai == 1) {
			$(".xiedai").animate({"opacity":0},500);
			setTimeout(function(){$(".xiedai").css("display","none");$(".xiedai li").removeClass("active");},500);
			xiedai = 0;
		}
	}
	//鞋带按钮
	$(".xiedai a").each(function(i) {
		$(this).click(function(){
			var name = $(this).attr("href");
			name = name.substr(1,name.length);
			$(".panel").attr("selectgkf","");
			$("#"+name+"_cont").attr("selectgkf","true");
			if(i == 5) {
				ispageindex();
			}
			else {
				notpageindex();
			}
			if(i == 0) {
				getMyDatas('ilike');
			}
			if(i == 1) {
				getMyDatas('repost');
			}
			console.log(myLike+" "+myRePost);
			$(".nav_on,.nav_on1").css("-webkit-transition","-webkit-transform 500ms ease-in-out");
			$(".nav_on,.nav_on1").css("-webkit-transform","translate3d("+(navwidth*4)+"px, 0px, 0px)");
			$(".nav li img:nth-child(1)").show();
			$(".nav1 li img:nth-child(1)").show();
			$(".nav li img:nth-child(2)").hide();
			$(".nav1 li img:nth-child(2)").hide();
			$(".nav li:nth-child(5)").find("img:nth-child(1)").hide();
			$(".nav1 li:nth-child(5)").find("img:nth-child(1)").hide();
			$(".nav li:nth-child(5)").find("img:nth-child(2)").show();
			$(".nav1 li:nth-child(5)").find("img:nth-child(2)").show();
			xiedaiClick();
		});
	});
	//添加主屏
	/*var ua = navigator.userAgent.toLowerCase();
	if(ua.indexOf('ipad') != -1 || ua.indexOf('iphone os') != -1) {
		if(window.navigator.standalone) {
			$(".img_home").hide();
		}
		else {
			$(".top,.cont,.bottom").hide();
			$(".jiaoyin").hide();
			$(".img_home").attr("src","images/home.jpg");
			$(".img_home").show();
		}
	}*/
	//
	$(".address_search").css({"height":awidth/640*86,"line-height":awidth/640*86+"px"});
	$(".address_list dt").css({"height":awidth/640*64,"line-height":awidth/640*64+"px"});
	$(".address_search input").css("margin-top",$(".address_search").height()*18/100+"px");
})
//关闭 发表，转发，评论
function closeFabiao() {
	$(".mask").hide();
	$(".zhuanfa").hide();
}
//发表，转发，评论
function showFabiao(type) {
	if(type == "zf") {
		$(".zhuanfa_title strong").text("转发");
	}
	else if(type == "pl") {
		$(".zhuanfa_title strong").text("评论");
	}
	$(".mask").show();
	$(".zhuanfa").show();
	$(".zhuanfa textarea").focus();
	$(".zhuanfa_btns").css({height:$(".zhuanfa_btns .right").height(),"line-height":$(".zhuanfa_btns .right").height()+"px"});
}

function showXingxiu(weibo_mid) {
	$(".panel").attr("selectgkf","");
	$("#xingxiuc_cont").attr("selectgkf","true");
	show_weibo_detail(weibo_mid);
}
showFabiao('zf');
//ajax请求开始与结束
function ajaxStart() {
	$(".mask").show();
	$(".loading").show();
}
function ajaxEnd() {
	$(".mask").hide();
	$(".loading").hide();
	console.log(11);
}
//判断首页
function ispageindex() {
	//$(".top").show();
	$(".bottom").show();
	$(".nav").hide();
}
//非判断首页
function notpageindex() {
	//$(".top").hide();
	$(".bottom").hide();
	$(".nav").show();
}
