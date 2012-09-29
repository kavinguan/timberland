// JavaScript Document
$(document).ready(function() {
	$(".btn_join").click(function(){
		if(url.indexOf("umaId") != -1) {
			$(".info_l").find("img").eq(0).hide();
			$(".info_l").find("img").eq(1).show();
			$(".jiangpin_title").find("img").eq(1).hide();
			$(".btn_join").hide();
			$(".fabiao").show();
		}
		else {
			umaWeibo.getAuthorizeURL('http://timberland.umaman.com/aoyun/index.html','5018a8f97c999daa7400000c');
		}
	});
	$(".btn_fabu").click(function(){
		if(url.indexOf("umaId") != -1) {
			var umaId = getQueryString("umaId");
			var sharetext = $(".fabiao textarea").val()+"活动地址：http://timberland.umaman.com/aoyun/";
			var picurl = $("#request").text();
			var params = {status:encodeURIComponent(sharetext),pic:"@"+picurl};
			if(picurl == "") {
				alert("请上传图片！");
				return;
			}
			alert("发布成功！");
			umaWeibo.callback = function(data) {
				if(data.error == undefined) {
					console.info(data);
					console.log(data.id+" "+data.mid+" "+data.bmiddle_pic+" "+data.original_pic+" "+data.text+" "+data.user.id+" "+data.user.profile_image_url+" "+data.user.screen_name);
					var datas = {
						id:data.id,
						mid:data.mid,
						pic:data.bmiddle_pic,
						piclarge:data.original_pic,
						content:data.text,
						userid:data.user.id,
						userface:data.user.profile_image_url,
						username:data.user.screen_name
					};
					umaWeibo.callback = function(data) {
						console.info(data);
					}
					umaWeibo.record(umaId,datas);
				}
				else {
					//alert("已发布过！");
				}
			};
			umaWeibo.post(umaId,'statuses/upload',params,1);
		}
		else {
			umaWeibo.getAuthorizeURL('http://timberland.umaman.com/aoyun/index.html','5018a8f97c999daa7400000c');
		}
	});
	
	if(url.indexOf("umaId") != -1) {
		$(".info_l").find("img").eq(0).hide();
		$(".info_l").find("img").eq(1).show();
		$(".jiangpin_title").find("img").eq(1).hide();
		$(".btn_join").hide();
		$(".fabiao").show();
	}
	else {
		
	}
});
var url = window.location.href;
function getQueryString(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
	var r = window.location.search.substr(1).match(reg);
	if (r != null) return unescape(r[2]); return null;
}
function check_login(){
	if(url.indexOf("umaId") != -1) {
		return true;
	}
	else {
		return false;
	}
}
function closeTan() {
	$(".mask").hide();
	$(".fayan").hide();
	$(".bigpic").hide();
}
function showBigpic(picurl) {
	$(".bigpic div").width($(".bigpic").width());
	$(".bigpic div").height($(".bigpic").height());
	$(".bigpic img").attr("src",picurl);
	$(".mask").height($("body").height());
	$(".mask").show();
	$(".bigpic").show();
}
function show_repost_or_comment(weibo_id,type,cid,source,pic,piclarge) {
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
		
		$(".mask").height($("body").height());
		$(".fayan,.mask").show();
		
		var html = '';
		html = '<div class="fayan_title">'+
					'<div class="btn_close"></div>'+title+
				'</div>'+
				'<div class="fayan_pic"><img src="'+pic+'" alt="" /></div>'+
				'<textarea class="textarea">#添柏岚慧眼英雄 火热英伦＃</textarea>'+
				'<img src="images/'+btn+'" alt="转发" class="btn_fayan" onclick="send_msg(\''+weibo_id+'\',\''+type+'\',\''+cid+'\');" />';
        $(".fayan").html(html);
		$(".btn_close").click(closeTan);
	}
	else {
		umaWeibo.getAuthorizeURL('http://timberland.umaman.com/aoyun/index.html','5018a8f97c999daa7400000c');
	}
}
function send_msg(weibo_id,type,cid) {
	if(!check_login()) {
		umaWeibo.getAuthorizeURL('http://timberland.umaman.com/aoyun/index.html','5018a8f97c999daa7400000c');
	}
	var msg = $(".textarea").val();
	if(msg=='') {
		alert("请输入您评论或者转发的理由~");
		return;
	}
	var umaId = getQueryString("umaId");
	var sharetext = msg;
	var params = {status:encodeURIComponent(sharetext),id:weibo_id};
	umaWeibo.callback = function(data) {
		console.info(data);
	}
	if(type == "repost") {
		var params = {status:encodeURIComponent(sharetext),id:weibo_id};
		umaWeibo.post(umaId,'statuses/repost',params);
		closeTan();
		alert("转发成功！");
	}
	else if(type == "comment") {
		var params = {comment:encodeURIComponent(sharetext),id:weibo_id};
		umaWeibo.post(umaId,'comments/create ',params);
		closeTan();
		alert("评论成功！");
	}
}
function gotiezi(id,uid) {
	if(!check_login()) {
		umaWeibo.getAuthorizeURL('http://timberland.umaman.com/aoyun/index.html','5018a8f97c999daa7400000c');
		return;
	}
	var umaId = getQueryString("umaId");
	var params = {id:id,type:1};
	umaWeibo.callback = function(data) {
		//var mid = data.mid;
		//window.location.href="http://weibo.com/"+uid+"/"+data.mid;
		window.open("http://weibo.com/"+uid+"/"+data.mid);
	}
	umaWeibo.get(umaId,'statuses/querymid',params);
}