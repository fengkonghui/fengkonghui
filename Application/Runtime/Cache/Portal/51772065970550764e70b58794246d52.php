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
			
<div class="xiangqing_neirong">
	<div class="neirong-tab">
		<a href="javascript:void(0)" class="on">背景资料</a> <a
			href="javascript:void(0)">贷款结果</a> <a href="javascript:void(0)">案例分析</a>
	</div>
	<div class="xiangqing_nr">
		<div class="main_title">
			<h2><?php echo ($xiangqing["xd_title"]); ?></h2>
		</div>
		<div class="xiangqing_top">
			<p>
				<span class="font_color">案例简介：</span><?php echo ($xiangqing["xd_jianjie"]); ?>
			</p>
			<p>
				<span class="font_color">借款金额：</span> <?php echo ($xiangqing["loan_money"]); ?>
				&nbsp;&nbsp; <span class="font_color">借款期限：</span>
				<?php echo ($xiangqing["loan_qixian"]); ?> &nbsp;&nbsp; <span class="font_color">借款用途：</span>
				<?php echo ($xiangqing["loan_yongtu"]); ?> &nbsp;&nbsp; <span class="font_color">还款来源：</span>
				<?php echo ($xiangqing["repayment_laiyaun"]); ?>
			</p>
		</div>
		<!--背景资料-->
		<div class="tabbody">
			<div class="bg_blue_ash">
				<div class="xiangqing_ziliao">
					<div class="ziliao_title">
						<h2>基本资料</h2>
						<div>&nbsp;</div>
					</div>
					<table>
						<colgroup>
							<col width="300" />
							<col width="150" />
						</colgroup>
						<tr>
							<td><span class="font_color">主 业 务：</span><?php echo ($xiangqing["xd_business"]); ?></td>
							<td><span class="font_color">注册资金：</span><?php echo ($xiangqing["xd_register_funds"]); ?></td>
						</tr>
						<tr>
							<td><span class="font_color">股权结构：</span><?php echo ($xiangqing["xd_structure"]); ?></td>
							<td><span class="font_color">经营年限：</span><?php echo ($xiangqing["xd_management_time"]); ?></td>
						</tr>
						<tr class="bor_none">
							<td><span class="font_color">企业文化：</span><?php echo ($xiangqing["xd_culture"]); ?></td>
							<td><span class="font_color">资质荣誉：</span><?php echo ($xiangqing["xd_honor"]); ?></td>
						</tr>
					</table>
				</div>
				<div class="xiangqing_jiating">
					<div class="jiating_title">
						<h2>企业家情况</h2>
						<div>&nbsp;</div>
					</div>
					<table>
						<colgroup>
							<col width="70" />
							<col width="350" />
						</colgroup>
						<tr>
							<td><span class="font_color">家庭情况：</span></td>
							<td><?php echo ($xiangqing["xd_family"]); ?></td>
						</tr>
						<tr>
							<td><span class="font_color">从业经历：</span></td>
							<td><?php echo ($xiangqing["xd_experience"]); ?></td>
						</tr>
						<tr>
							<td><span class="font_color">人脉资源：</span></td>
							<td><?php echo ($xiangqing["xd_contacts"]); ?></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="bg_blue_ash">
				<div class="xiangqing_yunying">
					<div class="yunying_title">
						<h2>运营情况</h2>
						<div>&nbsp;</div>
					</div>
					<table>
						<colgroup>
							<col width="70" />
							<col width="350" />
						</colgroup>
						<tr>
							<td><span class="font_color">业务模式：</span></td>
							<td><?php echo ($xiangqing["xd_pattern"]); ?></td>
						</tr>
						<tr>
							<td><span class="font_color">客户渠道：</span></td>
							<td><?php echo ($xiangqing["xd_channel"]); ?></td>
						</tr>
						<tr>
							<td><span class="font_color">结算规律：</span></td>
							<td><?php echo ($xiangqing["xd_law"]); ?></td>
						</tr>
						<tr>
							<td><span class="font_color">营销团队：</span></td>
							<td><?php echo ($xiangqing["xd_team"]); ?></td>
						</tr>
					</table>
				</div>
				<div class="xiangqing_guanli">
					<div class="guanli_title">
						<h2>企业管理</h2>
						<div>&nbsp;</div>
					</div>
					<table>
						<colgroup>
							<col width="70" />
							<col width="350" />
						</colgroup>
						<tr>
							<td><span class="font_color">组织职能：</span></td>
							<td><?php echo ($xiangqing["xd_function"]); ?></td>
						</tr>
						<tr>
							<td><span class="font_color">薪资激励：</span></td>
							<td><?php echo ($xiangqing["xd_excitation"]); ?></td>
						</tr>
						<tr>
							<td><span class="font_color">薪资激励：</span></td>
							<td><?php echo ($xiangqing["xd_culture"]); ?></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="xiangqing_caiwu">
				<div class="caiwu_title">
					<h2>财务情况</h2>
					<div>&nbsp;</div>
				</div>
				<table>
					<colgroup>
						<col width="70" />
						<col width="350" />
					</colgroup>
					<tr>
						<td><span class="font_color">收入情况：</span></td>
						<td><?php echo ($xiangqing["xd_income"]); ?></td>
					</tr>
					<tr>
						<td><span class="font_color">盈利情况：</span></td>
						<td><?php echo ($xiangqing["xd_profit"]); ?></td>
					</tr>
					<tr>
						<td colspan="2"><span class="font_color">库存情况：</span><?php echo ($xiangqing["xd_stock"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
							class="font_color">资产情况：</span><?php echo ($xiangqing["xd_assets"]); ?></td>
					</tr>
					<tr>
						<td colspan="2"><span class="font_color">负债情况：</span><?php echo ($xiangqing["xd_liabilities"]); ?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
							class="font_color">应收应付：</span><?php echo ($xiangqing["xd_sf"]); ?></td>
					</tr>
				</table>
			</div>
		</div>
		<!--背景资料 结束-->
		<!--贷款结果-->
		<div class="tabbody" style="display: none;">
			<div class="bg_blue_ash">
				<div class="xiangqing_yunying xiangqing_conclusion">
					<div class="yunying_title">
						<h2>实际审贷结论</h2>
						<div>&nbsp;</div>
					</div>
					<table>
						<colgroup>
							<col width="300" />
							<col width="150" />
						</colgroup>
						<tr>
							<td><span class="font_color">审核金额：</span><?php echo ($show_result ? $xiangqing[amount] : ''); ?></td>
							<td><span class="font_color">审批期限：</span><?php echo ($show_result ? $xiangqing[examination] : ''); ?></td>
						</tr>
						<tr>
							<td><span class="font_color">审批利率：</span><?php echo ($show_result ? $xiangqing[approval] : ''); ?></td>
							<td><span class="font_color">还款方式：</span><?php echo ($show_result ? $xiangqing[payment] : ''); ?></td>
						</tr>
						<tr class="bor_none">
							<td colspan="2"><span class="font_color">担保方式：</span><?php echo ($show_result ? $xiangqing[guarantee] : ''); ?></td>
						</tr>
					</table>
				</div>
				<div class="xiangqing_guanli xiangqing_conclusion"
					style="padding-bottom: 10px;">
					<div class="guanli_title">
						<h2>还款情况</h2>
						<div>&nbsp;</div>
					</div>
					<table>
						<colgroup>
							<col width="70" />
							<col width="350" />
						</colgroup>
						<tr>
							<td><span class="font_color">结清情况：</span></td>
							<td><?php echo ($show_result ? $xiangqing[settlement] : ''); ?></td>
						</tr>
						<tr>
							<td><span class="font_color">逾期情况：</span></td>
							<td><?php echo ($show_result ? $xiangqing[overdue] : ''); ?></td>
						</tr>
						<tr>
							<td><span class="font_color">坏账催收：</span></td>
							<td><?php echo ($show_result ? $xiangqing[collection] : ''); ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<!--贷款结果 结束-->
		<!--案例点评-->
		<div class="tabbody" style="display: none;">
			<div class="xiangqing_caiwu">
				<div class="caiwu_title">
					<h2>案例点评</h2>
					<div>&nbsp;</div>
				</div>
				<table style="width: 1030px;">
					<tr>
						<td><?php echo ($show_result ? $xiangqing[comments] : ''); ?></td>
					</tr>
				</table>
			</div>
		</div>
		<!--案例点评 结束-->
		<div class="xianqing_biaoqian">
			<span class="font_color">标签：</span> <?php echo ($xiangqing["biaoqian"]); ?>
		</div>
	</div>
</div>
<!-- 发表 -->
<div class="bianlun">
	<div class="zhengfang">
		<div class="title_dw">
			<img alt="" src="/static/Portal/fengkonghui/Public/img/xiangqing_09.jpg">
		</div>
		<div class="title_dw1">
			<div><?php echo ($zf_flag); ?></div>
			<img alt="" align="right" src="/static/Portal/fengkonghui/Public/img/xiangqing_11.jpg">
		</div>
		<?php if($zhengfang != null): if(is_array($zhengfang)): foreach($zhengfang as $key=>$zhengfang): ?><div class="spec_cont bianlun_div">
			<?php if($zhengfang["image"] == null): else: ?>
			<div class='spec_cont_img'>
				<img src="<?php echo ($zhengfang["image"]); ?>">
			</div><?php endif; ?>
			<div class="spec_wz">
				<a href="#" class="spec_cont_title"><?php echo ($zhengfang["rev_title"]); ?></a>
				<div class="content2"><?php echo nv_cutstr($zhengfang['rev_content'],80);?></div>
				<div class="botton02">
					<p class="fl spec_datetime"><?php echo (date("Y-m-d
						H:i:s",$zhengfang["rev_create_time"])); ?></p>
					<p class="fr spec_a_right">
						<a href="<?php echo U('Portal/Xdal/big',array('id'=>$zhengfang['ID']));?>" target="_blank">阅读全部&gt;&gt;</a>
					</p>
				</div>
			</div>
		</div><?php endforeach; endif; ?> <?php else: ?>
		<p>空</p><?php endif; ?>
		<div class="anli_post" id="xgxq">
			<form action="" method="post" class="xiangqing_sub">
				<input type="hidden" value="<?php echo ($xiangqing["ID"]); ?>" name="rev_review_hteme" />
				<textarea name="rev_content" class="zf_pinglun1"></textarea>
				<div>
					<input type="submit" class="zf_pinglun" name="sub1" value="评论">
				</div>
			</form>
		</div>
		<?php if($wzhengfang != null): if(is_array($wzhengfang)): foreach($wzhengfang as $key=>$wzhengfang): ?><div class="fkzx_jilu xiangqing_huifu">
			<div class="fkzx_tx">
				<a href="<?php echo U('Portal/member/user',array('uid'=>$wzhengfang['postby']));?>" target="_blank"><img src="<?php echo avatars($wzhengfang['postby']);?>" width="63" height="63" /></a>
			</div>
			<div class="fkzx_neirong">
				<p class="fkzx_name">
					<a href="<?php echo U('Portal/member/user',array('uid'=>$wzhengfang['postby']));?>" target="_blank"><?php echo (getname($wzhengfang["postby"])); ?></a><span><?php echo (date("Y-m-d
						H:i:s",$wzhengfang["create_time"])); ?></span>
				</p>
				<p><?php echo ($wzhengfang["content"]); ?></p>
				<p class="fkzx_huifu">
					<a class="reply_thumb" href="javascript:void(0);" data-id="<?php echo ($wzhengfang["id"]); ?>"  user-id="<?php echo ($wfanfang["postby"]); ?>">点赞(<em id="reply_thumb_<?php echo ($wzhengfang["id"]); ?>"><?php echo ($wzhengfang["nice"]); ?></em>)</a>&nbsp;&nbsp;&nbsp;
					<a class="reply_btn" href="javascript:void(0);">回复</a>&nbsp;&nbsp;&nbsp;<a
						class="open" href="javascript:void(0);"><span class="tihuan">展开</span><span
						class="num">(<?php echo ($wzhengfang["num"]); ?>)</span></a>
				</p>
				<div class="reply" style="display: none;">
					<form action="" method="post" class="xiangqing_sub">
						<input type="hidden" name="replyfor" value="<?php echo ($wzhengfang["id"]); ?>">
						<input type="hidden" value="29" name="rev_review_hteme">
						<textarea name="rev_content" class="zf_pinglun1"></textarea>
						<div>
							<input type="submit" class="zf_pinglun" name="sub1" value="回复">
						</div>
					</form>
				</div>
				<?php if(is_array($wzhengfang[replys])): foreach($wzhengfang[replys] as $key=>$row): ?><div class="fkzx_jilu fkzx_jilu_l2 xiangqing_huifu"
					style="display: none;">
					<div class="fkzx_tx">
						<a href="<?php echo U('Portal/member/user',array('uid'=>$row['postby']));?>" target="_blank"><img src="<?php echo avatars($row['postby']);?>" width="63" height="63"/></a>
					</div>
					<div class="fkzx_neirong">
						<p class="fkzx_name">
							<a href="<?php echo U('Portal/member/user',array('uid'=>$row['postby']));?>" target="_blank"><?php echo (getname($row["postby"])); ?></a><span><?php echo (date("Y-m-d
								H:i:s",$row["create_time"])); ?></span>
						</p>
						<p><?php echo ($row["content"]); ?></p>
					</div>
				</div><?php endforeach; endif; ?>
			</div>
		</div><?php endforeach; endif; ?> <?php else: ?>
		<p>没有评论</p><?php endif; ?>
		<?php if($zf_hasmore): ?><div class="xiangqing_jiazai">
			<a style="text-decoration: none;"
				href="<?php echo U('#xgxq',array('p_id'=>$page,'id'=>$xd_id,'menu_id'=>2));?>">加载更多</a>
		</div><?php endif; ?>
	</div>
	<div class="fanfang">
		<div class="title_dw">
			<img alt="" src="/static/Portal/fengkonghui/Public/img/xiangqing_10.jpg">
		</div>
		<div class="title_dw1">
			<div style="background-color: #E91404;"><?php echo ($ff_flag); ?></div>
			<img alt="" align="right" src="/static/Portal/fengkonghui/Public/img/xiangqing_11.jpg">
		</div>
		<?php if($fanfang != null): if(is_array($fanfang)): foreach($fanfang as $key=>$fanfang): ?><div class="spec_cont bianlun_div">
			<?php if($fanfang["image"] == null): else: ?>
			<div class='spec_cont_img'>
				<img src="<?php echo ($fanfang["image"]); ?>">
			</div><?php endif; ?>
			<div class="spec_wz">
				<a href="#" class="spec_cont_title"><?php echo ($fanfang["rev_title"]); ?></a>
				<p><?php echo nv_cutstr($fanfang['rev_content'],80);?></p>
				<p><?php echo (date("Y-m-d
								H:i:s",$fanfang["rev_create_time"])); ?></p>
				<p class="spec_a_right">
					<a href="<?php echo U('Portal/Xdal/big',array('id'=>$fanfang['ID']));?>" target="_blank">阅读全部&gt;&gt;</a>
				</p>
			</div>
		</div><?php endforeach; endif; ?> <?php else: ?>
		<p>空</p><?php endif; ?>

		<form action="" method="post" class="xiangqing_sub">
			<input type="hidden" value="<?php echo ($xiangqing["ID"]); ?>" name="rev_review_hteme" />
			<textarea name="rev_content" class="ff_pinglun1"></textarea>
			<div>
				<input type="submit" class="ff_pinglun" name="sub2" value="评论">
			</div>
		</form>
		<?php if($wfanfang != null): if(is_array($wfanfang)): foreach($wfanfang as $key=>$wfanfang): ?><div class="fkzx_jilu xiangqing_huifu">
			<div class="fkzx_tx">
				<a href="<?php echo U('Portal/member/user',array('uid'=>$wfanfang['postby']));?>" target="_blank"><img src="<?php echo avatars($wfanfang['postby']);?>" width="63" height="63" /></a>
			</div>
			<div class="fkzx_neirong">
				<p class="fkzx_name">
					<a href="<?php echo U('Portal/member/user',array('uid'=>$wfanfang['postby']));?>" target="_blank"><?php echo (getname($wfanfang["postby"])); ?></a><span><?php echo (date("Y-m-d
						H:i:s",$wfanfang["create_time"])); ?></span>
				</p>
				<p><?php echo ($wfanfang["content"]); ?></p>
				<p class="fkzx_huifu">
					<a class="reply_thumb" href="javascript:void(0);" data-id="<?php echo ($wfanfang["id"]); ?>" user-id="<?php echo ($wfanfang["postby"]); ?>">点赞(<em><?php echo ($wfanfang["nice"]); ?></em>)</a>&nbsp;&nbsp;&nbsp;
					<a class="reply_btn" href="javascript:void(0);">回复</a>&nbsp;&nbsp;&nbsp;
					<a class="open" href="javascript:void(0);">
						<span class="tihuan">展开</span>
						<span class="num">(<?php echo ($wfanfang["num"]); ?>)</span>
					</a>
				</p>
				<div class="reply" style="display: none;">
					<form action="" method="post" class="xiangqing_sub">
						<input type="hidden" name="replyfor" value="<?php echo ($wfanfang["id"]); ?>">
						<input type="hidden" value="29" name="rev_review_hteme">
						<textarea name="rev_content" class="zf_pinglun1"></textarea>
						<div>
							<input type="submit" class="zf_pinglun" name="sub1" value="回复">
						</div>
					</form>
				</div>
				<?php if(is_array($wfanfang[replys])): foreach($wfanfang[replys] as $key=>$row): ?><div class="fkzx_jilu fkzx_jilu_l2 xiangqing_huifu"
					style="display: none;">
					<div class="fkzx_tx">
						<a href="<?php echo U('Portal/member/user',array('uid'=>$row['postby']));?>" target="_blank"><img src="<?php echo avatars($row['postby']);?>" width="63" height="63" /></a>
					</div>
					<div class="fkzx_neirong">
						<p class="fkzx_name">
							<a href="<?php echo U('Portal/member/user',array('uid'=>$row['postby']));?>" target="_blank"><?php echo (getname($row["postby"])); ?></a><span><?php echo (date("Y-m-d
								H:i:s",$row["create_time"])); ?></span>
						</p>
						<p><?php echo ($row["content"]); ?></p>
					</div>
				</div><?php endforeach; endif; ?>
			</div>
		</div><?php endforeach; endif; ?> <?php else: ?>
		<p>没有评论</p><?php endif; ?>
		<?php if($ff_hasmore): ?><div class="xiangqing_jiazai">
			<a style="text-decoration: none;"
				href="<?php echo U('#xgxq',array('p_id'=>$page,'id'=>$xd_id,'menu_id'=>2));?>">加载更多</a>
		</div><?php endif; ?>
	</div>
	<div class="bian_img">
		<img src="/static/Portal/fengkonghui/Public/img/xiangqing_12.png" />
	</div>
</div>
<div class="xiangqing_footer">
	<div class="xq_xiangsi">
		<div class="xq_footer_titil">
			<div>&nbsp;</div>
			<h2>相似案例</h2>
			<div>&nbsp;</div>
		</div>
		<?php if(is_array($xiangsi)): $i = 0; $__LIST__ = $xiangsi;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Portal/Xdal/row',array('menu_id'=>2,'id'=>$vo[ID]));?>">
				<div class="xiangqing_footer1">
					<p style="font-weight: bold;"><?php echo nv_cutstr($vo['xd_title'],'18');?></p>
					<p><?php echo nv_cutstr($vo['xd_jianjie'],'36');?></p>
				</div>
			</a><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
	<div class="xq_xiangsi">
		<div class="xq_footer_titil">
			<div>&nbsp;</div>
			<h2>相关技术</h2>
			<div>&nbsp;</div>
		</div>
		<?php if(is_array($hongtujishu)): $i = 0; $__LIST__ = $hongtujishu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Portal/zhuanti/pdfTuijian',array('ty_id'=>$vo[ID]));?>">
			<div class="xiangqing_footer1">
				<p style="font-weight: bold;"><?php echo nv_cutstr($vo['title'],'18');?></p>
				<p><?php echo nv_cutstr($vo['describe'],'36');?></p>
			</div>
		</a><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
	<div class="xq_xiangsi">
		<div class="xq_footer_titil">
			<div>&nbsp;</div>
			<h2>红途实战</h2>
			<div>&nbsp;</div>
		</div>
		<div class="xq_footer_img">
			<a href="<?php echo ($xiangqing['red_url'] ? $xiangqing['red_url'] : 'javascript://'); ?>" <?php echo ($xiangqing['red_url'] ? 'target="_blank"' : ''); ?>>
			<img src="<?php echo ($xiangqing['red_img'] ? $xiangqing['red_img'] : ''); ?>" style="width: 371px;height:218px;" />
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
	$('.reply_btn').click(function() {
		$(this).parent().siblings('.reply').toggle();
	});
	$('.open').click(function() {
		if ($(this).parent().siblings('.xiangqing_huifu').is(':hidden')) {
			$(this).parent().siblings('.xiangqing_huifu').show();
			$(this).find('.tihuan').text('收起');
			$(this).find('.num').hide();
		} else {
			$(this).parent().siblings('.xiangqing_huifu').hide();
			$(this).find('.tihuan').text('展开');
			$(this).find('.num').show();
		}
	});
	$('.neirong-tab a').click(function() {
		$(this).addClass('on').siblings().removeClass('on');
		var i = $('.neirong-tab a').index(this);
		$('.tabbody:eq('+i+')').show().siblings('.tabbody').hide();
	});

	$('.reply_thumb').click(function(){
		var $this = $(this);
		var id = $(this).data('id');
		var uid = $(this).attr('user-id');
		$.post("<?php echo U('Xdal/nice');?>", { "id":id,"uid":uid},function(data){
			if(data.status == 1){
				$this.find('em').text('' + data.info);
			}else{
				alert(data.info);
			}
		}, "json");
	});
</script> 
	<?php echo ($site_tongji); ?>
</body>
</html>