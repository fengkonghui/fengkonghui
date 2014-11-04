<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>红途-风控汇</title>
<!-- css -->
<link rel="stylesheet" href="/static/Portal/fengkonghui/Public/css/style.css">

<style type="text/css">
.user-info {
	border-bottom: 1px solid #ccc;
	border-top: 1px solid #ccc;
	padding: 5px 0;
	line-height: 24px;
}

.user-info a {
	color: #bc0000;
}
</style>
<style type="text/css">
.jifen,.hongtubi {
	background-color: #fff;
	position: absolute;
	z-index:20;
	top:20%;
	left:20%;
	right:20%;
	width:60%;
}
.jifen li,.hongtubi li{
	height:30px;
	line-height: 30px;
	border-bottom: 1px dashed #e2e2e2;
	text-align: center;
}
.jifen li label,.hongtubi li label{
	display: inline-block;
	width:33%;
} 
.gz{
}
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
		<div class="spec_title da_title">
			<div>&nbsp;</div>
			<h2>会员中心</h2>
			<div>&nbsp;</div>
		</div>
		<div class="da_nav">
			<div class="da_nav_left">
				<div class="da_tx">
					<img src="<?php echo avatars($user_info['ID']);?>" />
					<a href="<?php echo U('center/setface');?>">修改头像</a>
				</div>
				<div class="da_xinxi">
					<p><?php echo ($user_info["user_login_name"]); ?></p>
					<p>&nbsp;</p>
					<p>
						<img src="/static/Portal/fengkonghui/Public/img/geren_07.png" />
						<span><?php echo groupname($user_info['group']);?></span>
					</p>
					<p>
						<input type="image" src="/static/Portal/fengkonghui/Public/img/geren_02.png"
							onclick="alert('栏目建设中，敬请关注');" />
					</p>
				</div>
			</div>
			<div class="da_nav_right">
				<ul>
					<li>
						<a href="<?php echo U('center/integral',array('tab'=>'coin'));?>">
							<img src="/static/Portal/fengkonghui/Public/img/geren_03.png">
						</a>
						<p><?php echo (memberredcoin(session('MEMBER_id'))); ?>红途币</p>
					</li>
					<li>
						<a href="<?php echo U('center/integral',array('tab'=>'integral'));?>" class="da_nav_def">
							<img src="/static/Portal/fengkonghui/Public/img/geren_04.png">
						</a>
						<p><?php echo (memberscore(session('MEMBER_id'))); ?>积分</p>
					</li>
					<li>
						<a href="#">
							<img src="/static/Portal/fengkonghui/Public/img/geren_05.png">
						</a>
						<p>邀请朋友</p>
					</li>
					<li>
						<a href="#">
							<img src="/static/Portal/fengkonghui/Public/img/geren_06.png">
						</a>
						<p>申请跳级</p>
					</li>
				</ul>
			</div>
		</div>
		<div class="da_bewrite">
			<div class="da_bew_dingwei">个人简介</div>
			<p class="profile"><?php echo ($user_info["profile"]); ?></p>
			<a href="javascript://" class="profile-eidt" onclick="p_eidt();">编辑</a>
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
	
	<div class="gz">
		<ul class="db clearfix jifen">
			<li class="myanswer1">
				<label>获取方式</label>
				<label>积分记录</label>
				<label>获取时间</label>
			</li>
			<li class="myanswer1">
				<label>&nbsp;&nbsp;&nbsp;&nbsp;1</label>
				<label>2</label>
				<label>3</label>
			</li>
		</ul>
	</div>

	 <script>
	function p_eidt() {
		var profile = $('.profile');
		profile
				.html('<textarea name="profile" rows="10" cols="120" style="line-height:22px; padding:10px;">'
						+ profile.html() + '</textarea>');
		$('.profile-eidt').attr('onclick', 'p_chcek();').html('保存');
	}
	function p_chcek() {
		var profile = $('textarea[name=profile]');
		$.ajax({
			type : "post",
			url : "<?php echo U('Center/profileEidt');?>",
			data : {
				profile : profile.val()
			},
			dataType : "json",
			success : function(data) {
				if (data.status === 1) {
					window.location.reload();
					$('.profile-eidt').attr('onclick', 'p_eidt();').html('编辑');
				}
			}
		})
	}
</script> 
	<?php echo ($site_tongji); ?>
</body>
</html>