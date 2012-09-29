<?php 
include 'conf.php';
$cache_version = get_cache_version(); 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Timberland</title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta name="format-detection" content="telephone=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="apple-touch-icon" href="images/icon.png"/>
<link rel="apple-touch-startup-image" href="images/loading.png">
<link rel="stylesheet" type="text/css" href="css/css.css?ver=<?php echo $cache_version;?>">
<script type="text/javascript" src="js/zepto.min.js"></script>
<script type="text/javascript" src="js/common.js?ver=<?php echo $cache_version;?>"></script>
<script type="text/javascript" src="js/jquery1.7.1.js"></script>
<script type="text/javascript" src="js/jquery.query.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/umaclient.js?ver=<?php echo $cache_version;?>"></script>
<script type="text/javascript" src="js/timberland.js?ver=<?php echo $cache_version;?>"></script>
<script type="text/javascript" src="js/date.js"></script>
<script type="text/javascript" src="js/jquery.address-1.5.min.js"></script>
<script type="text/javascript">
var navFilter = function(el) {
	return $(el).attr('href').replace(/^#/, '');
}
if ($.address.value() == '') {
	$.address.history(false).value(initialTab).history(true);
}
$.address.init(function(event) {
	//alert($.address.value());
	/*$('.nav a').click(function(event) {
		tabEvent = true;
		$.address.value(navFilter(event.target));
		tabEvent = false;
		return false;
	});*/
}).change(function(event) {
	var current = $('a[href=#' + event.value + ']:first');
	var navwidth = $(".top").width()/5;
	var name = window.location.href;
	if(name.indexOf("#") == -1) {
		name = "index";
	}
	if(name.substr(name.indexOf("#")+1,name.length) == "") return;
	name = name.substr(name.indexOf("#")+1,name.length);
	$(".panel").attr("selectgkf","");
	$("#"+name+"_cont").attr("selectgkf","true");
	if(name != "index") {
		notpageindex();
	} else {
		ispageindex();
	}
	var node = {"index":0,"xingxiu":1,"xingxiuc":1,"redian":2,"huodong":3,"dipan":4,"mylike":4,"mytaolun":4,"myhuodong":4,"myjifen":4,"myziliao":4};
	$(".panel").attr("selectgkf","");
	$("#"+name+"_cont").attr("selectgkf","true");
	$(".nav_on,.nav_on1").css("-webkit-transition","-webkit-transform 0ms ease-in-out");
	$(".nav_on,.nav_on1").css("-webkit-transform","translate3d("+navwidth*node[name]+"px, 0px, 0px)");
	$(".nav li img:nth-child(1),.nav1 li img:nth-child(1)").show();
	$(".nav li img:nth-child(2),.nav1 li img:nth-child(2)").hide();
	$(".nav li:nth-child("+(node[name]+1)+"),.nav1 li:nth-child("+(node[name]+1)+")").find("img:nth-child(1)").hide();
	$(".nav li:nth-child("+(node[name]+1)+"),.nav1 li:nth-child("+(node[name]+1)+")").find("img:nth-child(2)").show();
	//alert(name);
	// Sets the page title
	//$.address.title($.address.title().split(' | ')[0] + ' | ' + current.text());

	// Selects the proper tab
	/*if (!tabEvent) {
		tabs.tabs('select', current.attr('href'));
	}*/
});
</script>
</head>
<body>