<?php
    if(C('LAYOUT_ON')) {
        echo '{__NOLAYOUT__}';
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>跳转提示</title>
<link rel="stylesheet" href="__TMPL__/Public/css/style.css">
<script src="__TMPL__/Public/js/jquery-1.js"></script>
<script src="__TMPL__/Public/js/bootstrap.js"></script>
<script src="__TMPL__/Public/js/jquery.js"></script>
<script src="__TMPL__/Public/js/custom.js"></script>
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
	background: url("__TMPL__/Public/img/prompt.png") no-repeat;
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
<include file="Public:header" />
<!-- content -->
<div class="content">
	<div class="system-message">
	<present name="message">
		<div class="prompt success">
			<h2><?php echo($message); ?></h2>
	<else/>
		<div class="prompt error">
			<h2><?php echo($error); ?></h2>
	</present>
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
