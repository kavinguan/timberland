var xingxiu_click_type = 'all';
var top_click_type = 'all';
var getMyDatasType = '';

$.ajaxSetup({
	beforeSend: ajaxStart,
	complete: ajaxEnd,
	timeout:120000
});
function ajaxGetmore() {
	$(".a_more").html("查看更多"+" <img src='images/loading.gif' alt=''>");
	$(".a_more1").html("查看更多"+" <img src='images/loading.gif' alt=''>");
}
function endGetmore() {
	$(".a_more").html("查看更多");
	$(".a_more1").html("查看更多");
}
$(document).ready(function(){
	var name = window.location.href;
	name = name.substr(name.indexOf("#")+1,name.length);
	if(name == "xingxiu"){
		get_xingxiu_more(xingxiu_click_type);
	}
	if(name == "redian"){
		get_top_more(top_click_type);
	}
	
	if($.query.get('umaId')!=='') {
		$.cookie('umaId',$.query.get('umaId'));
		$.cookie('uid',$.query.get('uid'));
	}
	
	$("#btn_personal_data_submit").click(function(){
		var params = {};
		params['action']   = 'completion';
		params['province'] = $.trim($("#province").val());
		params['name']     = $.trim($("#name").val());
		params['mobile']   = $.trim($("#mobile").val());
		params['address']  = $.trim($("#address").val());
		
		$.ajax({
			url: "ajax.php",
			type: "POST",
			data: params,
			dataType: "json",
			beforeSend: ajaxGetmore,
			complete: endGetmore,
			success:function(data) {
				if(data.error>0) {
					alert(data.msg);
				}
				else {
					window.location.href = 'index.php';
					alert(data.msg);
				}
			}
		});
		
	});
	//
	$(".indexdipan,.navdipan,.nav1dipan,.xddipan1,.xddipan2,.xddipan3,.xddipan4,.xddipan5").click(function(event){
		if(check_login()){
			event.preventDefault();
			window.location = $(this).attr("href");
		}
		else {
			event.preventDefault();
		}
	});
	
	$(".indexdipan,.navdipan,.nav1dipan").click(function(){
		loadMyInfo();
	});
	
	//关注微博
	$(".btn_guanzhu").bind("click",function(){
		if(check_login()){
			var umaId = $.cookie('umaId');
			var params = {uid:1977283792};
			umaWeibo.callback = function(data) {
				console.info(data);
				alert("关注成功");
			}
			umaWeibo.post(umaId,'friendships/create',params,0);
		}
	});
	/*门店地址*/
	/*var addressObj=eval("("+addresss+")");
	console.log(addressObj.citys.length);
	for(var i=0; i<addressObj.citys.length; i++) {
		console.log(addressObj.citys[i].city);
		for(var j=0; j<$(".address_list dt").length; j++) {
			if($(".address_list dt").eq(j).has(addressObj.citys[i].city)) {
				$(".address_list dt").eq(j).html();
			}
		}
	}*/
	$(".address_list dt").bind("click",function(){
		if($(this).find("span").hasClass("icon_on")) {
			$(this).find("span").removeClass("icon_on");
			$(this).next("dd").hide();
		}
		else {
			$(this).find("span").addClass("icon_on");
			$(this).next("dd").show();
		}
	});
	$(".address_search input").focus(function(){
		if($(this).val() == "搜索") $(this).val("");
		//alert("focus");
		
	});
	$(".address_search input").blur(function(){
		if($(this).val() == "") {
			$(this).val("搜索");
			$(".address_list dt").show();
			$(".address_list li").show();
			$(".address_list dd").hide();
		}
		//alert("blur");
	});
	$(".address_search input").keyup(function(){
		var text = $(this).val();
		var lilength = $(".address_list li").length;
		if(text == "") {
			$(".address_list dt").show();
			$(".address_list li").show();
			$(".address_list dd").hide();
			return;
		}
		$(".address_list dt").hide();
		$(".address_list li").hide();
		$(".address_list dd").show();
		for(var i=0; i<lilength; i++) {
			var txt = $(".address_list li").eq(i).html();
			console.log(txt);
			console.log(txt.indexOf(text));
			if(txt.indexOf(text) != -1) {
				$(".address_list li").eq(i).show();
			}
		}
	});
});

xingxiu_hot_start = 0;//热门
xingxiu_new_start = 0;//推荐
xingxiu_all_start = 0;//最新
function get_xingxiu_more(type) {	
	eval("var start=xingxiu_"+type+"_start;");
	$.ajax({
		url: "ajax.php",
		type: "POST",
		data: {action : 'best', type:type, start:start},
		dataType: "json",
		beforeSend: ajaxGetmore,
		complete: endGetmore,
		success:function(data) {
			var ul1height;
			var ul2height;
			var html = '';
			$.each(data,function(index,value) {
				
				var verified = '';
				if(value.userInfo.verified===true) {
					verified = '<img src="images/v1.gif" alt="">';
				}
				console.log(value.weibo.postId+"_"+value.weibo.mid);
				html = '<a href="#xingxiuc" onclick="showXingxiu(\''+(value.weibo.mid==undefined||value.weibo.mid==null?value.weibo.postId:value.weibo.mid)+'\');ga(\'timberland.umaman.com\',\'最佳推荐_查看详细\');"><li class="item">'+
						'<img src="http://ww1.sinaimg.cn/bmiddle/'+value.weibo.picId+'.jpg" alt="" class="pic">'+
	                    '<div class="div">'+
	                        '<img src="'+(value.userInfo.profile_image_url==undefined?'images/02.jpg':value.userInfo.profile_image_url)+'" alt="" class="face">'+
	                        '<span class="text">'+
	                            '<strong>'+(value.userInfo.screen_name==undefined?value.weibo.nickname:value.userInfo.screen_name)+'</strong>'+verified+'<br/>'+
	                            '<span class="num">粉丝'+(value.userInfo.followers_count==undefined?0:value.userInfo.followers_count)+'人</span>'+
	                        '</span>'+
	                        '<span class="plnum">'+
	                            '<img src="images/heart.png" alt=""><br/>'+
	                            '<strong>'+value.weibo.commentTimes+'</strong>'+
	                        '</span>'+
	                    '</div>'+
	                    '</li></a>';
				$("#xingxiu_cont .pubu").hide();
				$("#xingxiu_"+type+"_content").show();
				if(index % 2 == 0) {
					$("#xingxiu_"+type+"_content ul:last-child").append(html);
				}
				else {
					$("#xingxiu_"+type+"_content ul:first-child").append(html);
				}
				/*var img = new Image();
				img.src = 'http://ww1.sinaimg.cn/bmiddle/'+value.weibo.picId+'.jpg';
				ul1height = $("#xingxiu_"+type+"_content ul:first-child").height();
				ul2height = $("#xingxiu_"+type+"_content ul:last-child").height();
				ul1height > ul2height ? $("#xingxiu_"+type+"_content ul:last-child").append(html) : $("#xingxiu_"+type+"_content ul:first-child").append(html);*/
			});
			eval("xingxiu_"+type+"_start += 10;");

		}
	});
}

function show_weibo_detail(mid) {
	//$("#xingxiuc_cont").find(".peitu").hide();
	$("#xingxiuc_cont").find(".peitu").attr("src","images/default.gif");
	$.ajax({
		url: "ajax.php",
		type: "POST",
		data: {action : 'getStatus',mid:mid},
		dataType: "json",
		success:function(data) {
			if(data.error!==undefined) {
				alert("和谐了……");
			}
			else {
				console.info(data);
				if(data.bmiddle_pic!='' && data.bmiddle_pic!==undefined) {
					$("#xingxiuc_cont").find(".peitu").attr('src',data.bmiddle_pic);
					//$("#xingxiuc_cont").find(".peitu").show();
				}
				else {
					//$("#xingxiuc_cont").find(".peitu").hide();
					$("#xingxiuc_cont").find(".peitu").attr("src","images/default.gif");
				}
				
				$("#xingxiuc_cont").find(".louzhu_txt").html(data.text+'<br /><span class="from">'+
						                                     Date.parse(data.created_at).toString('yyyy-MM-dd HH:mm')+
						                                     '来自：'+data.source+'</span><br/>'+
						                                     '<a href="javascript:;" onclick="ilike(\''+data.id+'\');ga(\'timberland.umaman.com\',\'详细_收藏\');myLike=0;myRePost=0;"  class="a_zf">收藏</a>'+
						                                     '<a href="javascript:show_repost_or_comment(\''+data.id+'\',\'comment\',\'0\',\''+data.text+'\');ga(\'timberland.umaman.com\',\'详细_评论\');" class="a_zf">评论</a>'+
						                                     '<a href="javascript:show_repost_or_comment(\''+data.id+'\',\'repost\',\'0\',\''+data.text+'\');ga(\'timberland.umaman.com\',\'详细_转发\');" class="a_zf">转发</a>');
				$("#xingxiuc_cont").find(".louzhu").html('<a href="javascript:;" onclick="ilike(\''+data.id+'\');ga(\'timberland.umaman.com\',\'详细_收藏\');myLike=0;myRePost=0;"><span class="plnum"><img src="images/heart.png" alt="">'+data.comments_count+'</span></a>'+
                '<img src="'+data.user.profile_image_url+'" class="face">'+data.user.screen_name+(data.user.verified==true?'<img src="images/v.gif" alt="">':''));
				$("#weibo_comments_number").html('评论('+data.comments_count+')');
				
				if(data.comments_count > 0) {
					console.info(data);
					loading_weibo_comment(data.id);
				}
				else {
					$("#weibo_comments").html('');
				}
			}
		}
	});
}

function loading_weibo_comment(weiboId) {
	$("#weibo_comments").html('');
	$.ajax({
		url: "ajax.php",
		type: "POST",
		data: {action : 'getComments',weiboId:weiboId},
		dataType: "json",
		success:function(data) {
			var html = '';
			$.each(data,function(i,value){
				console.info(value);
				if(value.user.id!=undefined) {
					 html += '<li>'+
	                 '<img src="'+value.user.profile_image_url+'" class="face" alt="">'+
	                 '<div class="neirong">'+
	                     '<strong class="blue">'+value.user.screen_name+'</strong><br/>'+
	                     value.text+
	                 '</div>'+
	                 '<div class="time">'+
	                 Date.parse(value.created_at).toString('yyyy-MM-dd HH:mm')+'<br/>'+
	                     '<a href="javascript:show_repost_or_comment(\''+weiboId+'\',\'comment\',\''+value.user.id+'\',\''+value.text+'\');ga(\'timberland.umaman.com\',\'详细_回复\');" class="blue">回复</a>'+
	                 '</div>'+
	                 '</li>';
				}
			});
			console.info(html);
			$("#weibo_comments").html(html);
		}
	});
}

top_hot_start = 0;//热门
top_new_start = 0;//推荐
top_all_start = 0;//最新
function get_top_more(type) {	
	eval("var start=top_"+type+"_start;");
	$.ajax({
		url: "ajax.php",
		type: "POST",
		data: {action : 'top', type:type, start:start},
		dataType: "json",
		beforeSend: ajaxGetmore,
		complete: endGetmore,
		success:function(data) {
			console.info(data);
			var html = '';
			$.each(data,function(index,value) {
				var image = '';
				if(value.weibo.picId!='') {
					image = '<a href="javascript:showBigPic(\''+value.weibo.picId+'\');ga(\'timberland.umaman.com\',\'最新排行_查看大图\');"><img src="http://ww1.sinaimg.cn/bmiddle/'+value.weibo.picId+'.jpg" alt="" class="img"></a>';
				}
				if(value.userInfo.id!=undefined) {
					html += '<a href="#xingxiuc" onclick="showXingxiu(\''+(value.weibo.mid==undefined||value.weibo.mid==null?value.weibo.postId:value.weibo.mid)+'\');ga(\'timberland.umaman.com\',\'最新排行_查看详细\');"><li>'+
							'<img src="'+value.userInfo.profile_image_url+'" alt="" class="face">'+
							'<div class="div">'+
							'<strong class="name">'+value.userInfo.screen_name+'</strong><br/><span class="plnum">'+value.weibo.createTime+'</span><br/>'+
							value.weibo.content+
							'<br/>'+image+'<br/>'+
							'<a href="javascript:showXingxiu(\''+(value.weibo.mid==undefined||value.weibo.mid==null?value.weibo.postId:value.weibo.mid)+'\');"><span class="plnum1"><img src="images/topic_icon.gif" alt="">'+value.weibo.commentTimes+'</span></a>'+
							'<span class="from">添柏岚俱乐部</span><br/>'+
							'<a href="javascript:;" onclick="ilike(\''+value.weibo.postId+'\');ga(\'timberland.umaman.com\',\'详细_收藏\');" class="a_zf">收藏</a>'+
							'<a href="javascript:show_repost_or_comment(\''+value.weibo.postId+'\',\'comment\',\'0\',\''+value.weibo.content+'\');ga(\'timberland.umaman.com\',\'详细_评论\');" class="a_zf">评论</a>'+
							'<a href="javascript:show_repost_or_comment(\''+value.weibo.postId+'\',\'repost\',\'0\',\''+value.weibo.content+'\');ga(\'timberland.umaman.com\',\'详细_转发\');" class="a_zf">转发</a>'+
		                    ''+
		                    '</div>'+
							'</li></a>';
				}
			});
			$("#redian_cont .hots").hide();
			$("#top_"+type+"_content").show();
			eval("top_"+type+"_start += 10;");
			$("#top_"+type+"_content > ul").append(html);
		}
	});
}

function send_msg(weibo_id,type,cid) {
	var msg = $("#send_msg").val();
	if(msg=='') {
		alert("请输入您评论或者转发的理由~");
		return false;
	}
	$.ajax({
		url: "ajax.php",
		type: "POST",
		async:false,
		data: {action : 'sendMsg', type:type, topic_id:weibo_id, content:msg ,cid:cid},
		dataType: "json",
		success:function(data) {
			console.info(data);
			if(data.error===undefined) {
				alert("感谢您的互动");
				closeFabiao();
			}
			else {
				alert(data.error);
			}	
		}
	});
}

function check_login() {
	if($.cookie('umaId')==null) {
		umaWeibo.getAuthorizeURL('http://timberland.umaman.com/','50038c017c999d241e000006');
		return false;
	}
	else {
		checkCookies();
		return true;
	}
}

function show_repost_or_comment(weibo_id,type,cid,source) {
	if(check_login()) {
		//显示登录窗口
		var title = '';
		var btn='';
		if(type=='repost') {
			title = '转发';
			btn = 'fayan_btn.gif';
		}
		else if(type=='comment') {
			title = '评论';
			btn = 'fayan_btn1.gif';
		}
		else {
			title = '发表微博';
			btn = 'fayan_btn2.gif';
		}
		
		$(".zhuanfa,.mask").show();
		
		var html = '';
		html = '<div class="zhuanfa_title"><strong>'+title+'</strong><div class="btn_close" onClick="javascript:closeFabiao();"></div></div>'+
        '<div class="zhuanfa_cont">'+
            '<textarea id="send_msg"></textarea>'+
        '</div>'+
        '<div class="zhuanfa_btns">'+
            '<!--<img src="images/fayan_face.gif" alt="" class="left">'+
            '<img src="images/fayan_at.gif" alt="" class="left">-->'+
            '<img src="images/'+btn+'" alt="" class="right" onclick="send_msg(\''+weibo_id+'\',\''+type+'\',\''+cid+'\');ga(\'timberland.umaman.com\',\''+title+'\');">'+
        '</div>';
		
		if(source!='') {
	        html += '<div class="zhuanfa_cont">'+
	            '<div class="zhuanfa_yuanwen">'+
	            myunescape(source)+
	            '</div>'+
	        '</div>';
		}
        $(".zhuanfa").html(html);
		setTimeout(function(){
			$(".mask").show();
		},500);
	}
}

function ilike(weibo_id) {
	if(check_login()) {
		$.ajax({
			url: "ajax.php",
			type: "POST",
			data: {action : 'sendMsg', type:'ilike', topic_id:weibo_id},
			dataType: "json",
			success:function(data) {
				console.info(data);
			}
		});
		alert("收藏成功");
	}
}

myPost   = 0;
myRePost = 0;
myLike   = 0;
function getMyDatas(type) {
	var limit = 10;
	var start = 0;
	if(type==='post') {
		start = myPost;
	}
	else if(type==='repost') {
		start = myRePost;
	}
	else if(type==='ilike') {
		start = myLike;
	}
	
	if(check_login()) {
		$.ajax({
			url: "ajax.php",
			type: "POST",
			data: {action : 'getMyDatas', type:type, limit:limit, start:start},
			dataType: "json",
			success:function(data) {
				var html = '';
				if(type==='post') {
					$.each(data,function(index,value){
						value = value.datas;
						html += '<li>'+
	                    '<img src="'+value.user.profile_image_url+'" alt="" class="face">'+
	                    '<div class="div">'+
	                        '<strong class="name">'+value.user.screen_name+'</strong><br/>'+
	                        value.text+'<br/>'+
	                        (value.bmiddle_pic!=undefined?'<img src="'+value.bmiddle_pic+'" alt="" class="img"><br/>':'')+
	                        '<a href="javascript:;" onclick="showXingxiu(\''+value.id+'\');"><span class="plnum1"><img src="images/topic_icon.gif" alt=""> '+value.comments_count+'</span></a>'+　
	                        '<span class="from">'+value.source+'</span><br/>'+
	                        '<a href="javascript:;" onclick="ilike(\''+value.id+'\')" class="a_zf">收藏</a>'+
	                        '<a href="javascript:show_repost_or_comment(\''+value.id+'\',\'comment\',\'0\',\''+myescape(value.text)+'\');" class="a_zf">评论</a>'+
	                        '<a href="javascript:show_repost_or_comment(\''+value.id+'\',\'repost\',\'0\',\''+myescape(value.text)+'\');" class="a_zf">转发</a>'+
	                        '<span class="plnum">'+Date.parse(value.created_at).toString('yyyy-MM-dd HH:mm')+'</span>'+
	                    '</div>'+
	                    '</li>';
					});
					if(myPost == 0) {
						$("#mytl_nav2_cont").html(html);
					}
					else {
						$("#mytl_nav2_cont").append(html);
					}
					myPost += data.length;
				}
				else if(type==='repost') {
					$.each(data,function(index,value){
						value = value.datas;
						html += '<li>'+
	                    '<img src="'+value.user.profile_image_url+'" alt="" class="face">'+
	                    '<div class="div">'+
	                        '<strong class="name">'+value.user.screen_name+'</strong><br/>'+
	                        value.text+'<br/>'+
	                        '<div class="yinyong">'+value.retweeted_status.text+'<br/>'+
	                        (value.retweeted_status.bmiddle_pic!=undefined?'<img src="'+value.retweeted_status.bmiddle_pic+'" alt="" class="img"><br/>':'')+'</div>'+
	                        (value.bmiddle_pic!=undefined?'<img src="'+value.bmiddle_pic+'" alt="" class="img"><br/>':'')+
	                        '<a href="javascript:;" onclick="showXingxiu(\''+value.id+'\');"><span class="plnum1"><img src="images/topic_icon.gif" alt=""> '+value.comments_count+'</span></a>'+　
	                        '<span class="from">'+value.source+'</span><br/>'+
	                        '<a href="javascript:;" onclick="ilike(\''+value.id+'\')" class="a_zf">收藏</a>'+
	                        '<a href="javascript:show_repost_or_comment(\''+value.id+'\',\'comment\',\'0\',\''+myescape(value.text)+'\');" class="a_zf">评论</a>'+
	                        '<a href="javascript:show_repost_or_comment(\''+value.id+'\',\'repost\',\'0\',\''+myescape(value.text)+'\');" class="a_zf">转发</a>'+
	                        '<span class="plnum">'+Date.parse(value.created_at).toString('yyyy-MM-dd HH:mm')+'</span>'+
	                    '</div>'+
	                    '</li>';
					});
					if(myRePost == 0) {
						$("#mytl_nav1_cont").html(html);
					}
					else {
						$("#mytl_nav1_cont").append(html);
					}
					myRePost += data.length;
				}
				else if(type==='ilike') {
					$.each(data,function(index,value){
						value = value.datas;
						if(value.retweeted_status==undefined) {
							html += '<li>'+
		                    '<img src="'+value.user.profile_image_url+'" alt="" class="face">'+
		                    '<div class="div">'+
		                        '<strong class="name">'+value.user.screen_name+'</strong><br/>'+
		                        value.text+'<br/>'+
		                        (value.bmiddle_pic!=undefined?'<img src="'+value.bmiddle_pic+'" alt="" class="img"><br/>':'')+
		                        '<a href="javascript:;" onclick="showXingxiu(\''+value.id+'\');"><span class="plnum1"><img src="images/topic_icon.gif" alt=""> '+value.comments_count+'</span></a>'+　
		                        '<span class="from">'+value.source+'</span><br/>'+
		                        '<a href="javascript:;" onclick="ilike(\''+value.id+'\')" class="a_zf">收藏</a>'+
		                        '<a href="javascript:show_repost_or_comment(\''+value.id+'\',\'comment\',\'0\',\''+myescape(value.text)+'\');" class="a_zf">评论</a>'+
		                        '<a href="javascript:show_repost_or_comment(\''+value.id+'\',\'repost\',\'0\',\''+myescape(value.text)+'\');" class="a_zf">转发</a>'+
		                        '<span class="plnum">'+Date.parse(value.created_at).toString('yyyy-MM-dd HH:mm')+'</span>'+
		                    '</div>'+
		                    '</li>';
						}
						else {
							value = value.datas;
							html += '<li>'+
		                    '<img src="'+value.user.profile_image_url+'" alt="" class="face">'+
		                    '<div class="div">'+
		                        '<strong class="name">'+value.user.screen_name+'</strong><br/>'+
		                        value.text+'<br/>'+
		                        '<div class="yinyong">'+value.retweeted_status.text+'<br/>'+
		                        (value.retweeted_status.bmiddle_pic!=undefined?'<img src="'+value.retweeted_status.bmiddle_pic+'" alt="" class="img"><br/>':'')+'</div>'+
		                        (value.bmiddle_pic!=undefined?'<img src="'+value.bmiddle_pic+'" alt="" class="img"><br/>':'')+
		                        '<a href="javascript:;" onclick="showXingxiu(\''+value.id+'\');"><span class="plnum1"><img src="images/topic_icon.gif" alt=""> '+value.comments_count+'</span></a>'+　
		                        '<span class="from">'+value.source+'</span><br/>'+
		                        '<a href="javascript:;" onclick="ilike(\''+value.id+'\')" class="a_zf">收藏</a>'+
		                        '<a href="javascript:show_repost_or_comment(\''+value.id+'\',\'comment\',\'0\',\''+myescape(value.text)+'\');" class="a_zf">评论</a>'+
		                        '<a href="javascript:show_repost_or_comment(\''+value.id+'\',\'repost\',\'0\',\''+myescape(value.text)+'\');" class="a_zf">转发</a>'+
		                        '<span class="plnum">'+Date.parse(value.created_at).toString('yyyy-MM-dd HH:mm')+'</span>'+
		                    '</div>'+
		                    '</li>';
						}
					});
					if(myLike == 0) {
						$("#container1").html(html);
					}
					else {
						$("#container1").append(html);
					}
					myLike += data.length;
				}
				else {
					alert("Error Type");
				}
			}
		});
	}
}

function myescape(str) {
	str = escape(str.replace("'","\'"));
	return str;
}

function myunescape(str) {
	return unescape(str.replace("\'","'"));
}

function loadMyInfo() {
	$.ajax({
		url: "ajax.php",
		type: "POST",
		data: {action : 'getMyInfo'},
		dataType: "json",
		success:function(data) {
			if(data.error!==undefined) {
				alert(data.msg);
				umaWeibo.getAuthorizeURL('http://timberland.umaman.com/','50038c017c999d241e000006');
			}
			else {
				console.info(data);
				$("#dipan_screen_name").html(data.screen_name);
				$("#dipan_points").html(data.timberland.points);
				
				$("#province").val(data.timberland.province);
				$("#name").val(data.timberland.name);
				$("#mobile").val(data.timberland.mobile);
				$("#address").val(data.timberland.address);
				
				$("#userface,#userface1").attr("src",data.avatar_large);
			}
			
		}
	});
}

function checkCookies() {
	$.ajax({
		url: "ajax.php",
		type: "POST",
		data: {action : 'check'},
		dataType: "json",
		success:function(data) {
			if(data.error==1) {
				alert(data.msg);
				umaWeibo.getAuthorizeURL('http://timberland.umaman.com/','50038c017c999d241e000006');
			}
		}
	});
	return true;
}

setInterval(loadMyInfo, 300000);

function showBigPic(pic) {
	var picurl = "http://ww1.sinaimg.cn/large/"+pic+".jpg";
	$.ajax({
		url: "images/huodong.jpg",
		complete: function(){},
		success:function(){
			$(".bigpic img").attr("src",picurl);
			$(".bigpic div").width($(".bigpic").width());
			$(".bigpic div").height($(".bigpic").height());
			$(".mask").show();
			$(".loading").hide();
			$(".bigpic").show();
		}
	});
}
function hideBigPic() {
	$(".bigpic img").attr("src","");
	$(".mask").hide();
	$(".bigpic").hide();
}
function ga(url,info) {
	_gaq.push(['_trackEvent', info, 'click', info]);
	console.log(info);
	//alert(info);
}
