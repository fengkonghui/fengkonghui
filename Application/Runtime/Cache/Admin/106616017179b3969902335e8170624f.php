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

	<div class="wrap J_check_wrap">
		<div class="nav">
			<ul class="cc">
				<li class="current"><a href="<?php echo U('navcat/index');?>">菜单分类</a></li>
				<li><a href="<?php echo U('navcat/add');?>">添加分类</a></li>
			</ul>
		</div>
		<form class="J_ajaxForm" action="" method="post">
			<div class="table_list">
				<table width="100%">
					<colgroup>
						<col width="36">
						<col width="40">
						<col width="80">
						<col width="80">
						<col width="80">
						<col width="90">
						<col width="140">
						<col width="120">
					</colgroup>
					<thead>
						<tr>
							<td><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></td>
							<td>ID</td>
							<td>名称</td>
							<td>描述</td>
							<td>主菜单</td>
							<td>操作</td>
						</tr>
					</thead>
					<?php if(is_array($navcats)): foreach($navcats as $key=>$vo): ?><tr>
							<td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="<?php echo ($vo["navid"]); ?>"></td>
							<td><?php echo ($vo["navcid"]); ?></td>
							<td><?php echo ($vo["name"]); ?></td>
							<td><?php echo ($vo["remark"]); ?></td>
							<td>
						<?php $mainmenu=$vo[active]?"是":"否"; ?>
						<?php echo ($mainmenu); ?>
						</td>
						<td>
							<a href="<?php echo U('navcat/edit',array('id'=>$vo[navcid]));?>">修改</a>|
							<a href="<?php echo U('navcat/delete',array('id'=>$vo[navcid]));?>" class="J_ajax_del" >删除</a>
						</td>
						</tr><?php endforeach; endif; ?>
				</table>
				<div class="p10"><div class="pages">  </div> </div>

			</div>
			<div>
				<div class="btn_wrap_pd">
					<label class="mr20"><input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y">全选</label>  
					<button class="btn J_ajax_submit_btn" type="submit" data-action="#">删除</button>
				</div>
			</div>
		</form>
	</div>

<script src="/static/js/common.js<?php echo ($js_debug); ?>"></script> 

</body>
</html>