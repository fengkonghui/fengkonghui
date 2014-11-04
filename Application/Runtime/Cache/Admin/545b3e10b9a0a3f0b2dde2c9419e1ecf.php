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
				<li class="current"><a href="<?php echo U('user/index');?>">管理员</a></li>
				<li><a href="<?php echo U('user/add');?>">添加管理员</a></li>
			</ul>
		</div>
		<div class="table_list">
			<table width="100%" cellspacing="0">
				<thead>
					<tr>
						<td width="10%">序号</td>
						<td width="10%" align="left" >用户名</td>
						<td width="10%" align="left" >所属角色</td>
						<td width="10%"  align="left" >最后登录IP</td>
						<td width="10%"  align="left" >最后登录时间</td>
						<td width="15%"  align="left" >E-mail</td>
						<td width="20%">备注</td>
						<td width="15%" >管理操作</td>
					</tr>
				</thead>
				<tbody>
				<?php if(is_array($users)): foreach($users as $key=>$vo): ?><tr>
						<td width="10%" align="center"><?php echo ($vo["ID"]); ?></td>
						<td width="10%" ><?php echo ($vo["user_login"]); ?></td>
						<td width="10%" ><?php echo ($roles[$vo[role_id]]['name']); ?></td>
						<td width="10%" ><?php echo ($vo["last_login_ip"]); ?></td>
						<td width="10%"  >
					<?php if($vo['last_login_time'] == 0): ?>该用户还没登录过
						<?php else: ?>
						<?php echo ($vo["last_login_time"]); endif; ?>
					</td>
					<td width="15%"><?php echo ($vo["user_email"]); ?></td>
					<td width="20%"  align="center"><?php echo ($vo["remark"]); ?></td>
					<td width="15%"  align="center">
					<?php if($User['username'] == $vo['username']): ?><font color="#cccccc">修改</font> | 
						<font color="#cccccc">删除</font>
						<?php else: ?>
						<a href="<?php echo U("Management/edit",array("id"=>$vo[id]));?>">修改</a> | 
						<a class="J_ajax_del" href="<?php echo U('Management/delete',array('id'=>$vo['id']));?>">删除</a><?php endif; ?>
					</td>
					</tr><?php endforeach; endif; ?>
				</tbody>
			</table>
		</div>
	</div>

<script src="/static/js/common.js<?php echo ($js_debug); ?>"></script> 

</body>
</html>