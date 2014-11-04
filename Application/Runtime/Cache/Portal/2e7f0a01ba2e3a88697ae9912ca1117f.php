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
			
<div class="special">

	<div class="spec_title xindai_title">
		<div>&nbsp;</div>
		<h2>实战直通车</h2>
		<div>&nbsp;</div>
	</div>
	<div class="xindai_wq">
		<a href="<?php echo U('xdal/wqcx',array('menu_id'=>'2'));?>" class="xindai_def_a">往期查询</a> <a href="#"
			class="gz_tanchuceng">规则说明 </a>
	</div>
	<div class="xindai_anli_01">
		<div class="xindai_img">
			<img alt=""
				src="<?php echo ((isset($row1["xd_image"]) && ($row1["xd_image"] !== ""))?($row1["xd_image"]):'http://placehold.it/550x250'); ?>" />
		</div>
		<div class="xindai_neirong">
			<div class="xindai_neirong_title">
				（案例直播）<?php echo ($row1["xd_title"]); ?> <span class="tiemleft_line">剩余时间：<span
					data-st="<?php echo (strtotime($row1["xd_surplus"])); ?>" class="tiemleft"><?php echo (lefttime($row1["xd_surplus"])); ?></span></span>
			</div>
			<div class="xindai_neirong_a">
				<div class="xindai_nr">案例介绍：</div>
				<p><?php echo ($row1["xd_jianjie"]); ?></p>
			</div>
			<div class="xindai_bu_jr">
				<a href="<?php echo U('row',array('menu_id'=>2,'id'=>$row1[ID]));?>" style="z-index: 20;position: relative;" class="bnt">进入</a>
			</div>
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="xindai_anli_01">

		<div class="xindai_neirong xindai_nr_left">
			<div class="xindai_neirong_title">
				（案例直播）<?php echo ($row2["xd_title"]); ?> <span class="tiemleft_line">剩余时间：<span
					data-st="<?php echo (strtotime($row2["xd_surplus"])); ?>" class="tiemleft"><?php echo (lefttime($row2["xd_surplus"])); ?></span></span>
			</div>
			<div class="xindai_neirong_a">
				<div class="xindai_nr">案例介绍：</div>
				<p><?php echo ($row2["xd_jianjie"]); ?></p>
			</div>
			<div class="xindai_bu_jr">
				<a href="<?php echo U('row',array('menu_id'=>2,'id'=>$row2[ID]));?>" style="z-index: 20;position: relative;" class="bnt">进入</a>
			</div>
		</div>
		<div class="xindai_img">
			<img alt=""
				src="<?php echo ((isset($row2["xd_image"]) && ($row2["xd_image"] !== ""))?($row2["xd_image"]):'http://placehold.it/550x250'); ?>" />
		</div>
		<div class="clearboth"></div>
	</div>
</div>
<div class="xindai_vs">
	<div class="xindai_vs1" id="wqcx">
		<?php if(is_array($rows)): foreach($rows as $key=>$row): ?><div class="xindai_vs_div"
			style="background-image: url('<?php echo ((isset($row["xd_image"]) && ($row["xd_image"] !== ""))?($row["xd_image"]):' http :// placehold.it/ 550x250 '); ?>')">
			<div class="xindai_txdw">
				<img alt=""
					src="<?php echo avatars($row['zheng']);?>" />
			</div>
			<div class="xindai_txdw2">
				<img src="/static/Portal/fengkonghui/Public/img/xindai_04.png" />
			</div>
			<div class="xindai_txdw1">
				<img alt=""
					src="<?php echo avatars($row['fan']);?>" />
			</div>
			<div class="xindai_txdw3">
				<div><?php echo ($row["xd_title"]); ?></div>
				<div style="text-align: center;">
					<a class="sbut"
						href="<?php echo U('row',array('menu_id'=>2,'id'=>$row[ID]));?>">进入</a>
				</div>
			</div>
		</div><?php endforeach; endif; ?>
	</div>
	<?php if($hasmore): ?><div class="xindai_vs2">
		<a href="<?php echo U('xdal/index',array('id'=>2,'p'=>$page));?>"
			style="text-decoration: none; color: #fff;">加载更多</a>
	</div><?php endif; ?>
</div>
<div class="xindai_fx" id="xindai_fx">
	<div class="spec_rig_top jishu_left_x xindai_fx1">
		<h2>案例分享</h2>
		<div>
			<a <?php echo $_GET['type']=='' ? 'class="on"' : '';?> href="<?php echo U('xindaixiangqing/wangyouanli',array('menu_id'=>2));?>">发布案例</a>
			<a <?php echo $_GET['type']=='now' ? 'class="on"' : '';?> href="<?php echo U('xdal/index#xindai_fx',array('menu_id'=>2,'type'=>'now'));?>">最新</a> | 
			<a <?php echo $_GET['type']=='essence' ? 'class="on"' : '';?> href="<?php echo U('xdal/index#xindai_fx',array('menu_id'=>2,'type'=>'essence'));?>">精华</a> | 
			<a <?php echo $_GET['type']=='popularity' ? 'class="on"' : '';?> href="<?php echo U('xdal/index#xindai_fx',array('menu_id'=>2,'type'=>'popularity'));?>">人气</a>
		</div>
	</div>
	<div class="jishu_cont">
		<?php if(is_array($wangyou)): foreach($wangyou as $key=>$arr): ?><div class="jishu_cont1 xindai_fx2" style="height: 80px;">
				<div class="touxiang corner">
					<a href="<?php echo U('Portal/member/user',array('uid'=>$arr['user_id']));?>" target="_blank"><img src="<?php echo avatars($arr['user_id']);?>" /></a>
				</div>
				<p><?php echo (getname($arr["user_id"])); ?>&nbsp;</p>
				<p><a href="<?php echo U('xindai/anlixiangqing',array('menu_id'=>2,'wy_id'=>$arr[ID]));?>"><?php echo ($arr["wy_title"]); ?></a></p>
			</div><?php endforeach; endif; ?>
	</div>
	<div class="page"><?php echo ($Page1); ?></div>
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
	<div>
		<img src="/static/Portal/fengkonghui/Public/img/gz_01.jpg" class="gz_img" /> <img
			src="/static/Portal/fengkonghui/Public/img/gz_02.png" />
	</div>
</div>

	 <script type="text/javascript">
	function pad(num, n) { 
		var i = (num + "").length; 
		while(i++ < n) num = "0" + num; 
		return num; 
	} 
	window.setInterval(function() {
		$('.tiemleft').each(function() {
			var now = new Date(); 
			var endDate = new Date($(this).data('st') * 1000);
			var leftTime=endDate.getTime()-now.getTime(); 
			if(leftTime > 0){
				var leftsecond = parseInt(leftTime/1000); 
				var day1=Math.floor(leftsecond/(60*60*24)); 
				var hour=Math.floor((leftsecond-day1*24*60*60)/3600); 
				var minute=Math.floor((leftsecond-day1*24*60*60-hour*3600)/60); 
				var second=Math.floor(leftsecond-day1*24*60*60-hour*3600-minute*60); 
				if(day1)
					$(this).text(day1+"天 "+pad(hour,2)+":"+pad(minute,2)+":"+pad(second,2));
				else
					$(this).text(pad(hour,2)+":"+pad(minute,2)+":"+pad(second,2));
					
			}else{
				$(this).text('已公布');
			}
		});
	}, 1000);
	$('.xindai_fx .page a').each(function(){
		$(this).attr('href',$(this).attr('href') + '#xindai_fx');
	});
</script> 
	<?php echo ($site_tongji); ?>
</body>
</html>