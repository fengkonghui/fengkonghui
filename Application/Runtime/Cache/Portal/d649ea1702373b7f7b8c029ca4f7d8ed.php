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
			
		<div class="fkzx_content">
			<div class="spec_title">
				<div>&nbsp;</div>
				<h2>风控解答</h2>
				<div>&nbsp;</div>
			</div>
			<div class="fkzx_cont">
				<div class="fkzx_cont_left">
					<div class="fkzx_date">2014-8月30日</div>
					<div class="fkzx_time">解答时间段<br />10:00-15:00</div>
				</div>
				<div class="fkzx_cont_center">
					<div class="spec_rig_top fkzx_title">
						<h2>在线风控解答</h2>
						<div>&nbsp;</div>
					</div>
					<div class="fkzx_jilu">
						<div class="fkzx_tx"><img src="/static/Portal/fengkonghui/Public/img/fkzx_01.jpg" /></div>
						<div class="fkzx_neirong">
							<p class="fkzx_name">张三<span>2014-12-15</span></p>
							<p>支持微博、微信登录。补充说明，即使采用微博、微信登录，也需要用户勾选“所在城市公司类别、职务级别”信息。</p>
							<p class="fkzx_huifu"><a href="#">已回复（2）</a></p>
						</div>
					</div>
					<div class="fkzx_jilu">
						<div class="fkzx_tx"><img src="/static/Portal/fengkonghui/Public/img/fkzx_01.jpg" /></div>
						<div class="fkzx_neirong">
							<p class="fkzx_name">张三<span>2014-12-15</span></p>
							<p>支持微博、微信登录。补充说明，即使采用微博、微信登录，也需要用户勾选“所在城市公司类别、职务级别”信息。</p>
							<p class="fkzx_huifu"><a href="#">已回复（2）</a></p>
						</div>
					</div>
					<div class="fkzx_jilu">
						<div class="fkzx_tx"><img src="/static/Portal/fengkonghui/Public/img/fkzx_01.jpg" /></div>
						<div class="fkzx_neirong">
							<p class="fkzx_name">张三<span>2014-12-15</span></p>
							<p>支持微博、微信登录。补充说明，即使采用微博、微信登录，也需要用户勾选“所在城市公司类别、职务级别”信息。</p>
							<p class="fkzx_huifu"><a href="#">已回复（2）</a></p>
						</div>
					</div>
				</div>
				<div class="fkzx_cont_right">
					<div class="spec_rig_top fkzx_tw">
						<h2>我来提问</h2>
						<div>&nbsp;</div>
					</div>
					<form action="post" method="post">
						<textarea rows="" cols="">
						
						</textarea>
						<input type="submit" name="sub" value="提问" /> 
					</form>
					<div class="fkzx_img">
						<a href="#"><img src="/static/Portal/fengkonghui/Public/img/fkzx_02.jpg" /></a>
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
	
	
	<?php echo ($site_tongji); ?>
</body>
</html>