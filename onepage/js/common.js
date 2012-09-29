// JavaScript Document
$(document).ready(function() {
	$(".p_top li").each(function(i) {
		$(this).click(function(){
			$(".p_top li").removeClass("active");
			$(this).addClass("active");
			$(".pics > ul").hide();
			$(".pics > ul").eq(i).show();
			loadtype = i+1;
			loadMore(loadtype);
		});
	});
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
	$(".bigpic img").attr("src","http://ww1.sinaimg.cn/large/"+picurl);
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
				'<div class="fayan_pic"><img src="http://ww1.sinaimg.cn/bmiddle/'+pic+'" alt="" /></div>'+
				'<textarea class="textarea"></textarea>'+
				'<img src="images/'+btn+'" alt="转发" class="btn_fayan" onclick="send_msg(\''+weibo_id+'\',\''+type+'\',\''+cid+'\');" />';
        $(".fayan").html(html);
		$(".btn_close").click(closeTan);
	}
	else {
		umaWeibo.getAuthorizeURL('http://timberland.umaman.com/onepage/index.html','505acd9a2e4690fd26000b08');
	}
}
function send_msg(weibo_id,type,cid) {
	if(!check_login()) {
		umaWeibo.getAuthorizeURL('http://timberland.umaman.com/onepage/index.html','505acd9a2e4690fd26000b08');
	}
	var msg = $(".textarea").val();
	if(msg=='') {
		alert("请输入您评论或者转发的理由~");
		return;
	}
	var umaId = getQueryString("umaId");
	var sharetext = msg;
	var params1 = {mid:weibo_id,type:1,isBase62:1};
	umaWeibo.callback = function(data) {
		var weiboid = data.id;
		umaWeibo.callback = function(data) {
			console.info(data);
		}
		if(type == "repost") {
			var params = {status:encodeURIComponent(sharetext)+"http://timberland.umaman.com/onepage",id:weiboid};
			umaWeibo.post(umaId,'statuses/repost',params);
			closeTan();
			alert("转发成功！");
		}
		else if(type == "comment") {
			var params = {comment:encodeURIComponent(sharetext)+"http://timberland.umaman.com/onepage",id:weiboid};
			umaWeibo.post(umaId,'comments/create ',params);
			closeTan();
			alert("评论成功！");
		}
	}
	umaWeibo.get(umaId,'statuses/queryid',params1);
	
}
function gotiezi(id,uid) {
	/*if(!check_login()) {
		umaWeibo.getAuthorizeURL('http://timberland.umaman.com/onepage/index.html','505acd9a2e4690fd26000b08');
		return;
	}
	var umaId = getQueryString("umaId");
	var params = {id:id,type:1};*/
	window.open("http://weibo.com/"+uid+"/"+id);
	/*umaWeibo.callback = function(data) {
		window.open("http://weibo.com/"+uid+"/"+data.mid);
	}
	umaWeibo.get(umaId,'statuses/querymid',params);*/
}