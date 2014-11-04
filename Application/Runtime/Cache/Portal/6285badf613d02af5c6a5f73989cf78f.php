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
<div class="spec_title">
	<div>&nbsp;</div>
	<h2>风控专题</h2>
	<div>&nbsp;</div>
</div>
	<div class="spec_left">
		<?php if(is_array($zhuanti)): $i = 0; $__LIST__ = $zhuanti;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="spec_cont">
			<div class="spec_cont_num"><?php echo ($i); ?></div>
			<div class='spec_cont_img<?php echo ($i); ?>'>
				<img src="<?php echo ($vo["image"]); ?>">
			</div>
			<div class="spec_wz2 spec_width<?php echo ($i); ?>">
				<a target="_blank"
					href="<?php echo U('Portal/zhuanti/zhuanti_show',array('id'=>$vo['ID']));?>"
					class="spec_cont_title"><?php echo ($vo["zt_title"]); ?></a>
				<p><?php echo nv_cutstr($vo['describe'],110);?></p>
				<a target="_blank"
					href="<?php echo U('Portal/zhuanti/zhuanti_show',array('id'=>$vo['ID']));?>"
					class="xq">了解详情 &gt;&gt;</a>
			</div>
		</div><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
	<div class="spec_right">
		<div class="spec_rig_top">
			<h2>下周专题</h2>
			<div>&nbsp;</div>
		</div>
		<div class="spec_rig_xz">
			<div class="spec_rig_xz1">
				<?php if(is_array($xq_zhuanti1)): foreach($xq_zhuanti1 as $key=>$xq_zhuanti1): ?><div class="spec_click spec_click_<?php echo ($key+1); ?>"
					title="<?php echo ($xq_zhuanti1["title"]); ?>">
					<?php echo nv_cutstr($xq_zhuanti1['title'],36);?> <img class="spec_rig_img"
						src="/static/Portal/fengkonghui/Public/img/fengkonghui.png"> <input
						type="checkbox" value="<?php echo ($xq_zhuanti1["id"]); ?>" name="weekIds[]"
						style="display: none">
				</div><?php endforeach; endif; ?>
			</div>
			<input type="hidden" name="toupiao" class="toupiao" /> <input
				type="hidden" name="" class="num" value="1" />
			<div class="spec_rig_xz1">
				<div id="toupiao" class="spec_sub">投票</div>
			</div>
		</div>
		<div class="spec_shuliang">
			<div class="spec_shuzhuang"
				style="padding-top: 20px; overflow: inherit;">
				<?php if(is_array($piaoshu)): $i = 0; $__LIST__ = $piaoshu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="spec_div<?php echo ($key+1); ?>"
					style="height: <?php echo round($vo [ 'number' ]/ $vote_total * 100, 10);?>">
					<span class="spec_span<?php echo ($key+1); ?>"><?php echo ($vo["number"]); ?></span>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
			<div class="spec_biaoti">
				<?php if(is_array($piaoshu)): foreach($piaoshu as $key=>$a): ?><div><?php echo ($key+1); ?></div><?php endforeach; endif; ?>
			</div>
		</div>
	</div>
</div>
<div class="knowledge">
	<div class="kno_title">
		<div>&nbsp;</div>
		<h2>风控技术知识</h2>
		<div>&nbsp;</div>
	</div>
	<div class="kno_xz">
		<div class="kno_xz1">
			<div class="kno_xz4 prevPage">
				<img src="/static/Portal/fengkonghui/Public/img/kno_1.png">
			</div>
			<div class="kno_xz3" id="forceCentered">
				<ul>
					<?php if($type == null): ?>&nbsp; <?php else: ?>
					<li><?php if(is_array($type)): foreach($type as $key=>$type): ?><div class="kno_d <?php echo ($type["class"]); ?>" type_id="<?php echo ($type["ID"]); ?>">
							<a href="javascript:"><?php echo ($type["ty_title"]); ?></a>
						</div><?php endforeach; endif; ?></li><?php endif; ?>
				</ul>
			</div>
			<div class="kno_xz4 nextPage">
				<img src="/static/Portal/fengkonghui/Public/img/kno_2.png">
			</div>
		</div>
		<div class="kno_xz2">
			<?php if($type == null): ?><div>没有相关数据</div>
			<?php else: ?> <?php if(is_array($jishu)): foreach($jishu as $key=>$jishu): ?><div>
				<a href="<?php echo U('zhuanti/technical',array('type'=>$jishu[ID]));?>"><?php echo ($jishu["ty_title"]); ?></a>
			</div><?php endforeach; endif; endif; ?>
		</div>
	</div>
</div>

<div class="read">
	<div class="read1">
		<div class="read_top">推荐阅读</div>
		<div class="read_content">
			<?php if(is_array($read)): foreach($read as $key=>$read): ?><div class="read_content1">
				<a href="<?php echo U('zhuanti/pdfTuijian',array('ty_id'=>$read[ID]));?>">
					<img src="<?php echo ($read["tj_img"]); ?>" />
				</a>
				<?php switch($read["class"]): case "2": ?><div class="level to1">机构</div><?php break;?> <?php case "3": if(getMemberField('group') < $read['group']): ?><div class="level to3"><?php echo ($read["price"]); ?>红途币</div>
				<?php else: ?>
				<div class="level to2"><?php echo getGroupName($read['group']);?>可阅</div><?php endif; break;?> <?php default: ?>
				<div class="level">免费</div><?php endswitch;?>

				<div class="title"><?php echo ($read["title"]); ?></div>
			</div><?php endforeach; endif; ?>
		</div>
		<div class="read_content">
			<?php if(is_array($read1)): foreach($read1 as $key=>$read1): ?><div class="read_content1">
				<a href="<?php echo U('zhuanti/pdfTuijian',array('ty_id'=>$read1[ID]));?>"><img
					src="<?php echo ($read1["tj_img"]); ?>" /></a>
				<div class="level"><?php echo ($read["price"]); ?></div>
				<div class="title"><?php echo ($read["title"]); ?></div>
			</div><?php endforeach; endif; ?>
		</div>
	</div>
</div>

<div class="jishu">
	<div class="jishu_left" id="jishu">
		<div class="spec_rig_top jishu_left_x">
			<h2>技术分享</h2>
			<div>
				<a href="<?php echo U('zhuanti/jishu',array('menu_id'=>3));?>">发布技术</a> <a
					<?php echo $_GET['type']== 'now' || $_GET['type']== '' ? 'class="on"
					' : '';?> href="<?php echo U('zhuanti/index#jishu',array('menu_id'=>3,'type'=>'now'));?>">最新</a>
				| <a <?php echo $_GET['type']== 'essence' ? 'class="on"
					' : '';?> href="<?php echo U('zhuanti/index#jishu',array('menu_id'=>3,'type'=>'essence'));?>">精华</a>
				| <a <?php echo $_GET['type']== 'popularity' ? 'class="on"
					' : '';?> href="<?php echo U('zhuanti/index#jishu',array('menu_id'=>3,'type'=>'popularity'));?>">人气</a>
			</div>
		</div>
		<div class="jishu_cont">
			<?php if(is_array($fenxiang)): foreach($fenxiang as $key=>$fenxiang): ?><div class="jishu_cont1">
					<div class="touxiang">
						<a href="<?php echo U('Portal/member/user',array('uid'=>$fenxiang['user_id']));?>" target="_blank"><img src="<?php echo avatars($fenxiang['user_id']);?>" /></a>
					</div>
					<p><?php echo (getname($fenxiang["user_id"])); ?></p>
					<p> <a
				href="<?php echo U('zhuanti/jishuxiangqing',array('menu_id'=>3,'xq_id'=>$fenxiang[id]));?>"><?php echo ($fenxiang["fx_title"]); ?></a></p>
				</div><?php endforeach; endif; ?>
		</div>
		<div class="page"><?php echo ($Page); ?></div>
	</div>
	<div class="jishu_right">
		<div class="jishu_rig">
			<div class="spec_rig_top jishu_rig_x">
				<h2>风控专家</h2>
				<div>&nbsp;</div>
			</div>
		</div>
		<div class="jishu_zj">
			<?php if(is_array($expert)): $i = 0; $__LIST__ = $expert;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a
				href="<?php echo U('Portal/member/user',array('uid'=>$vo['uid']));?>"
				target="_blank">
				<div class="jishu_zj1">
					<div>
						<img src="<?php echo avatars($vo['uid']);?>">
					</div>
					<p><?php echo getName($vo['uid']);?></p>
				</div>
			</a><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<div class="zj_fy">
			<div class="zj_fy_y">&nbsp;</div>
			<div class="zj_fy1">
				<a href="" class="">&nbsp;</a> <a href="">&nbsp;</a> <a href="">&nbsp;</a>
			</div>
			<div class="zj_fy_y">&nbsp;</div>
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
	
	 <script
	src="/static/Portal/fengkonghui/Public/js/jquery.sly.js"></script> <script
	type="text/javascript">
		//标签滚动
		$('#forceCentered').sly({
			horizontal : 1,
			itemNav : "basic",
			dragContent : 1,
			startAt : 3,
			scrollBy : 1
		});
		$('.jishu_left .page a').each(function() {
			$(this).attr('href', $(this).attr('href') + '#jishu');
		});
		$(function() {
			$('.spec_sub')
					.click(
							function() {
								var weekIds = $('input[name="weekIds[]"]:checked'), num = weekIds.length, ids = '';
								if (num != 3) {
									alert('请选择三项');
								} else {
									for (var i = 0; i < weekIds.length; i++) {
										ids += weekIds[i].value + ",";
									}
									$.post("<?php echo U('zhuanti/ajToupiao');?>", {
										ids : ids
									}, function(Obj) {
										var Obj = eval("(" + Obj + ")");
										if (Obj.status === 1) {
											alert('投票成功');
										} else {
											alert(Obj.info);
										}
										location = location;
									});
								}
							});
			/**
			 * 风控技术进行分类查询
			 **/
			$('.kno_d').click(function() {
				var ty_id = $(this).attr('type_id');
				$('.kno_d').css('background', '#DFDFDF');
				$(this).css('background', '#F1F1F1');
				$.post("<?php echo U('zhuanti/ajZhishi');?>", {
					ty_id : ty_id
				}, function(data) {
					//替换网页内容
					$('.kno_xz2').html(data);
				});
			});

		});
	</script> 
	<?php echo ($site_tongji); ?>
</body>
</html>