<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head><title>风控汇 - 红途网-信贷风控技术，小微企业融资，天堑变红途!</title>
<meta charset="UTF-8">
<meta name="keywords" content="风险控制,风控技术,信用贷款,小微信贷,信贷案例,尽职调查,风控汇">
<meta name="description" content="聚焦小微企业融资风控的体系研究，传播自主研发的信贷审查技术，网罗全国风控实战案例，提供免费在线投融资风险评估与风控咨询。以开放、分享、协作的互联网精神，共同构建一个免费的风控服务平台。">
<meta property="qc:admins" content="343735763473767607674571676375" />
<link rel="stylesheet" href="/static/Portal/fengkonghui/Public/css/home.css">
<script src="/static/Portal/fengkonghui/Public/js/jquery-1.11.1.min.js"></script>
</head>
<body onResize="Resize()" onLoad="Resize()">
	<div class="main-outer">	
		<div class="main">
			<div class="linebg"></div>
			<div class="sharp logo">
				<a href="#"> <img src="/static/Portal/fengkonghui/Public/img/guidance_logo1.png"></a>
			</div>
			<div class="sharp zxfk">
				<a href="<?php echo U('zaixian/index');?>"> <img src="/static/Portal/fengkonghui/Public/img/investigator1.png"></a>
			</div>
			<div class="sharp fkjs">
				<a href="<?php echo U('Zhuanti/index',array('id'=>'3'));?>"> <img src="/static/Portal/fengkonghui/Public/img/incestors.png"></a>
			</div>
			<div class="sharp xdsh">
				<a href="#"> <img src="/static/Portal/fengkonghui/Public/img/xindailife.png"></a>
			</div>
			<div class="sharp jgfw">
				<a href="#"> <img src="/static/Portal/fengkonghui/Public/img/cuarantor.png"></a>
			</div>
			<div class="sharp xdal">
				<a href="<?php echo U('xdal/index');?>"> <img src="/static/Portal/fengkonghui/Public/img/borrower.png"></a>
			</div>
			<div class="guidance_bg"></div>
		</div>
	</div>
	<div class="footer">
		<div class="container">
			<p class="links fl">
				<a href="" target="_blank">关于我们</a> <a href="" target="_blank">法律声明</a>
				<a href="" target="_blank">网站规则</a> <a href="" target="_blank">提出建议</a>
				<a href="" target="_blank">联系我们</a>
			</p>
			<p class="copyright fr">
				<span>Copyright © 2014 北京红途信息科技服务有限公司</span> <a href="#"><?php echo ($site_icp); ?>&nbsp;</a>
			</p>
		</div>
	</div>
	<script>
	$(function () {  
		var winWidth,winHeight;
		Resize = function(){
			winWidth = $(window).width(),
			winHeight= $(window).height();
			if(winHeight>780){
				$('.main').addClass('float');
				$('.footer').addClass('float');
			}else{
				$('.main').removeClass('float');
				$('.footer').removeClass('float');
			}
		}
	});
	</script>
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F934437330fe78c87e114dbb1f21ff0ad' type='text/javascript'%3E%3C/script%3E"));
</script>

</body>
</html>