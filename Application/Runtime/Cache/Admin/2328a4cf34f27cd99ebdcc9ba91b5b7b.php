<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge" />
		<title>系统后台</title>
		<link href='/static/favicon.ico' rel='shortcut icon'>
		<link href="/static/admin/css/style.css<?php echo ($js_debug); ?>" rel="stylesheet" />
		<link href="/static/js/artDialog/skins/default.css<?php echo ($js_debug); ?>" rel="stylesheet" />
		<script type="text/javascript">
			//全局变量
			var GV = {
				DIMAUB: "/",
				JS_ROOT: "static/js/",
				TOKEN: ""
			};
		</script>
		<script src="/static/js/wind.js<?php echo ($js_debug); ?>"></script>
		<script src="/static/js/jquery.js<?php echo ($js_debug); ?>"></script>
	
</head>
<body class="J_scroll_fixed">

	<div class="wrap">
		<div id="home_toptip"></div>
		<h2 class="h_a">系统信息</h2>
		<div class="home_info">
			<ul>
				<?php if(is_array($server_info)): $i = 0; $__LIST__ = $server_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li> <em><?php echo ($key); ?></em> <span><?php echo ($vo); ?></span> </li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
	</div>

<script src="/static/js/common.js<?php echo ($js_debug); ?>"></script> 

</body>
</html>