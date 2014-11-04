<?php if (!defined('THINK_PATH')) exit(); if(C('LAYOUT_ON')) { echo ''; } ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>跳转提示</title>
<link rel="stylesheet" href="/static/Portal/fengkonghui/Public/css/style.css">
<script src="/static/Portal/fengkonghui/Public/js/jquery-1.js"></script>
<script src="/static/Portal/fengkonghui/Public/js/bootstrap.js"></script>
<script src="/static/Portal/fengkonghui/Public/js/jquery.js"></script>
<script src="/static/Portal/fengkonghui/Public/js/custom.js"></script>
<style type="text/css">
.content {
	position: relative;
}
.system-message {
	position: absolute;
	display: block;
	width: 700px;
	height: 200px;
	margin-left: -500px;
	margin-top: -200px;
	top: 50%;
	left: 50%;
	background: white;
	padding: 100px 150px;
}
.jump {
	color: #999999;
	font-size: 18px;
	margin-top: 4px;
}
.jump a {
	color: #999999;
	font-size: 18px;
}
.jump a:hover {
	color: #000000;
}

.prompt {
	height: 119px;
	padding-left: 155px;
	background: url("/static/Portal/fengkonghui/Public/img/prompt.png") no-repeat;
}
.prompt.error {
	background-position: 14px 26px;
}
.prompt.success{
	background-position: 14px -128px;
}
.prompt h2 {
	font-size: 38px;
	font-weight: normal;
	padding-top: 18px;
	color: #d00004;
}
</style>
</head>
<body>
<!-- logo -->
<!-- 获取导航信息   -->
<?php if(!empty($nav)): ?><div class="header">
	<div class="header_1">
		<div class="header_img">
			<a href="<?php echo U('/');?>">
			<img src="/static/Portal/fengkonghui/Public/img/logo.png" width="124" height="53" />
			</a>
		</div>
		<div class="header_nav">
			<ul class="header_nav1">
				<?php if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i; if(($r["url"] != 'center/index') OR ($_SESSION['MEMBER_id']!= '')): ?><li><a class="<?php echo ($r["class"]); ?>" 
					href="<?php echo ($r['href'] ? U($r['href'],array('menu_id'=>$r['id'])) : '#'); ?>"
					><?php echo ($r["label"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
		<div class="top-header-menu">
			<ul class="menu">
				<?php if(strlen($_SESSION['MEMBER_id']) != 0): ?><li><a href="<?php echo U('portal/center/index');?>"><?php echo (session('MEMBER_name')); ?>
						<?php if(getMesNum() != 0): ?><span
							class="fa fa-envelope" style="color: #FF4400;">
							<?php echo getMesNum();?></span><?php endif; ?>
				</a>&nbsp;&nbsp;|&nbsp;&nbsp;</li>
				<li id="navright"><a href="<?php echo U('portal/member/logout');?>"><span
						class="icon-signout"></span>退出</a>&nbsp;&nbsp;</li>
				<?php else: ?>
				<li><a href="<?php echo U('Portal/Member/index');?>">登录</a>&nbsp;|&nbsp;</li>
				<li><a href="<?php echo U('Portal/Member/register');?>">注册</a>&nbsp;&nbsp;</li><?php endif; ?>
			</ul>
		</div>
	</div>
</div><?php endif; ?>
<!-- content -->
<div class="content">
	<div class="system-message">
	<?php if(isset($message)): ?><div class="prompt success">
			<h2><?php echo($message); ?></h2>
	<?php else: ?>
		<div class="prompt error">
			<h2><?php echo($error); ?></h2><?php endif; ?>
			<p class="jump">
				页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>秒
			</p>
		</div>
	</div>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</div>
</body>
</html>