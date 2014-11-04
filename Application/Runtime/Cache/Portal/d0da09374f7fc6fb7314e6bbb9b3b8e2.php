<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>红途-风控汇</title>
<!-- css -->
<link rel="stylesheet" href="/static/Portal/fengkonghui/Public/css/style.css">

	<style type="text/css">
		.user-info{ border-bottom: 1px solid #ccc; border-top: 1px solid #ccc; padding: 5px 0; line-height: 24px; margin: 10px 0}
		.user-info a { color: #bc0000;}
	</style>

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
				<ul>
	<li><a href="<?php echo U('Center/personal');?>" <?php if(ACTION_NAME == 'personal'): ?>class="da_left_def"<?php endif; ?>>会员中心</a></li>
	<li><a href="<?php echo U('Center/means');?>" <?php if(ACTION_NAME == 'means'): ?>class="da_left_def"<?php endif; ?>>个人资料</a></li>
	<li><a href="<?php echo U('Center/release',array('tab'=>'case'));?>" <?php if(ACTION_NAME == 'release'): ?>class="da_left_def"<?php endif; ?>>我发布的</a></li>
	<li><a href="<?php echo U('Center/myanswer',array('tab'=>'case'));?>" <?php if(ACTION_NAME == 'myanswer'): ?>class="da_left_def"<?php endif; ?>>我的回答</a></li>
	<li><a href="<?php echo U('Center/group');?>" <?php if(ACTION_NAME == 'group'): ?>class="da_left_def"<?php endif; ?>>我的小组</a></li>
</ul>
			</div>
			<div class="da_right">
				<div class="member-nav">
					<a href="<?php echo U('Portal/Center/release',array('tab'=>'case'));?>" <?php if($_GET['tab']== 'case'): ?>class="nav-hover"<?php endif; ?>>案例</a>
					<a href="<?php echo U('Portal/Center/release',array('tab'=>'technology'));?>" <?php if($_GET['tab']== 'technology'): ?>class="nav-hover"<?php endif; ?>>技术</a>
				</div>
				<div class="member-list">
					<ul class="db clearfix">
						<?php if(is_array($release)): $i = 0; $__LIST__ = $release;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="release1 pd">
								<a href="<?php echo ($vo["url"]); ?>" target="_blank"><?php echo ($vo["title"]); ?></a>
							</li>
							<li class="release2"><?php echo ($vo["time"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
					<div class="pages clearfix">
					<?php echo ($page); ?>
					</div>
				</div>
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
	</script>

	<?php echo ($site_tongji); ?>
</body>
</html>