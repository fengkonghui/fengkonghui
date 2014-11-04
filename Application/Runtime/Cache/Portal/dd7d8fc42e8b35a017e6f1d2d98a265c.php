<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>红途-风控汇</title>
<!-- css -->
<link rel="stylesheet" href="/static/Portal/fengkonghui/Public/css/style.css">

<!--script-->
<script src="/static/Portal/fengkonghui/Public/js/jquery-1.11.1.min.js"></script>
<script src="/static/Portal/fengkonghui/Public/js/jquery.validate.min.js"></script>
<script src="/static/Portal/fengkonghui/Public/js/custom.js"></script>
<!--[if lt IE 10]>
<script type="text/javascript" src="/pie/PIE.js"></script>
<![endif]-->
</head>
<body>
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
	<div class="content">
		<div class="center">
			
<div class="gr_data">
	<div class="da_left">
		<ul class="login_tabs">
			<li><a href="#" class="personal da_left_def">用户登录</a></li>
			<li><a href="#" class="enterprise">企业登录</a></li>
		</ul>
	</div>
	<div class="da_right login_right personal">
		<div class="da_img_left">
			<img src="/static/Portal/fengkonghui/Public/img/login.jpg" />
		</div>
		<form id="login" action="<?php echo U('Member/dologin');?>" method="post">
			<input type="hidden" name="type" value="personal" />
			<div class="login_row">
				<span>手机号</span> <br /> <input type="text" name="user_login_name"
					class="login_input" maxlength="11" />
			</div>
			<div class="login_row">
				<span>密码</span> <br /> <input type="password" name="passwd"
					maxlength="15" value="" class="login_input login_pwd" />
			</div>
			<a href="<?php echo U('Member/register');?>">免费注册</a> | <a href="">忘记密码？</a> <br />
			<input type="submit" name="sub" value="登录" class="login_submit" />

			<div class="login_qh">
				直接使用区号登录：<a href="<?php echo U('/Portal/user/login',array('type'=>'weibo'));?>"><img src="/static/Portal/fengkonghui/Public/img/login_04.gif" />
					微博</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo U('/Portal/user/login',array('type'=>'qq'));?>"><img
					src="/static/Portal/fengkonghui/Public/img/login_01.jpg" />QQ</a>
			</div>
		</form>
	</div>
	<div class="da_right login_right enterprise" style="display: none;">
		<div class="da_img_left">
			<img src="/static/Portal/fengkonghui/Public/img/login.jpg" />
		</div>
		<form action="<?php echo U('Member/dologin');?>" method="post">
			<input type="hidden" name="type" value="enterprise" /> <span>企业账号</span>
			<br /> <input type="text" name="user_login_name" class="login_input" />
			<br /> <span>密码</span> <br /> <input type="password" name="passwd"
				value="" class="login_input login_pwd" /> <br /> <a
				href="<?php echo U('Member/register');?>">免费注册</a> | <a href="">忘记密码？</a> <br />
			<input type="submit" name="sub" value="登录" class="login_submit" />
		</form>
	</div>
</div>

		</div>
	</div>
	
<!-- 
<div class="footer">
	<div class="container">
		<p class="links fl">
			<a href="" target="_blank">关于我们</a> <a href="" target="_blank">法律声明</a>
			<a href="" target="_blank">网站规则</a> <a href="" target="_blank">提出建议</a>
			<a href="" target="_blank">联系我们</a>
		</p>
		<p class="copyright fr">
			<span>Copyright © 2014 北京红途信息科技服务有限公司</span> <a href="#"><?php echo C ( 'site_icp' );?>&nbsp;</a>
		</p>
	</div>
</div> -->
	
	 <script type="text/javascript">
	$('.login_tabs .personal').click(function() {
		$(this).addClass('da_left_def');
		$('.login_tabs .enterprise').removeClass('da_left_def');
		$('.login_right').hide();
		$('.login_right.personal').show();
	});
	$('.login_tabs .enterprise').click(function() {
		$(this).addClass('da_left_def');
		$('.login_tabs .personal').removeClass('da_left_def');
		$('.login_right').hide();
		$('.login_right.enterprise').show();
	});
	jQuery.extend(jQuery.validator.messages, {
		required : "必填字段",
		remote : "请修正该字段",
		email : "请输入正确格式的电子邮件",
		url : "请输入合法的网址",
		date : "请输入合法的日期",
		dateISO : "请输入合法的日期 (ISO).",
		number : "请输入合法的数字",
		digits : "只能输入整数",
		creditcard : "请输入合法的信用卡号",
		equalTo : "请再次输入相同的值",
		accept : "请输入拥有合法后缀名的字符串",
		maxlength : jQuery.validator.format("请输入一个 长度最多是 {0} 的字符串"),
		minlength : jQuery.validator.format("请输入一个 长度最少是 {0} 的字符串"),
		rangelength : jQuery.validator.format("请输入 一个长度介于 {0} 和 {1} 之间的字符串"),
		range : jQuery.validator.format("请输入一个介于 {0} 和 {1} 之间的值"),
		max : jQuery.validator.format("请输入一个最大为{0} 的值"),
		min : jQuery.validator.format("请输入一个最小为{0} 的值")
	});
	$('#login').validate({
		rules : {
			user_login_name : {
				required : true,
				minlength : 11
			},
			passwd : {
				required : true,
				minlength : 6
			}
		}
	});
</script> 
	<?php echo ($site_tongji); ?>
</body>
</html>