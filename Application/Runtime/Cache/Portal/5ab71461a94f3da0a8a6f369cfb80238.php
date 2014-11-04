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
		<ul>
			<li><a class="da_left_def">个人注册</a></li>
			<li><a href="<?php echo U('Member/registerqy');?>">企业注册</a></li>
		</ul>
	</div>
	<div class="da_right">
		<form id="reg" action="<?php echo U('Member/doregister');?>" method="post">
			<table class="reg_left">
				<tr>
					<td class="reg_table_right">昵称</td>
					<td><input type="text" name="user_login_name"
						class="reg_input" placeholder="2-15字符" /></td>
				</tr>
				<tr>
					<td class="reg_table_right">密码</td>
					<td><input id="pass" type="password" name="pass"
						class="reg_input" maxlength="15" placeholder="6-15位字符" /></td>
				</tr>
				<tr>
					<td class="reg_table_right">确认密码</td>
					<td><input type="password" name="repass" class="reg_input"
						maxlength="15" /></td>
				</tr>
				<tr>
					<td class="reg_table_right">手机号</td>
					<td><input type="text" name="user_tel" maxlength="11"
						class="reg_input reg_tel" /> <input type="button"
						name="phone_fake" value="发送验证" class="reg_but sentsms"
						placeholder="请输入11位手机号"></td>
				</tr>
				<tr>
					<td class="reg_table_right">短信验证码</td>
					<td><input type="text" name="user_tel_yz"
						class="reg_input reg_yz"
						onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)"
						onblur="this.v();" maxlength="6" /></td>
				</tr>
				<tr>
					<td class="reg_table_right">邮箱</td>
					<td><input type="text" name="user_emaile" class="reg_input reg_yz" /></td>
				</tr>
			</table>
			<table class="reg_right">
				<colgroup>
					<col width="100" />
					<col width="200" />
				</colgroup>
				<tr>
					<td class="reg_table_right">所在城市</td>
					<td><select class="reg_input" name="user_city"
						required="required">
							<option value="">-- 选择所在城市 --</option>
							<?php $_result=area();if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["ID"]); ?>"><?php echo ($vo["area_title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select></td>
				</tr>
				<tr>
					<td class="reg_table_right">公司类别</td>
					<td><select class="reg_input" name="company_type"
						required="required">
							<option value="">-- 选择公司类别 --</option>
							<?php $_result=category();if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select></td>
				</tr>
				<tr>
					<td class="reg_table_right">职务级别</td>
					<td><select class="reg_input" name="user_post_level"
						required="required">
							<option value="">-- 选择公司类别 --</option>
							<?php $_result=postLevel();if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select></td>
				</tr>
				<tr>
					<td class="reg_table_right">邀请码</td>
					<td><input type="text" name="user_yq" class="reg_input reg_yz" /></td>
				</tr>
				<tr>
					<td class="reg_table_right">&nbsp;</td>
					<td class="reg_xy_1"><input type="checkbox" value="1"
						required="required" name="user_xy" id="user_xy" class="reg_xy">&nbsp;<label
						for="user_xy">已阅 <a href="#">注册协议</a></label></td>
				</tr>
				<tr>
					<td class="reg_table_right">&nbsp;</td>
					<td><input type="hidden" name="type" value="personal" /> <input
						type="submit" class="reg_sub" name="sub" value="注册" /></td>
				</tr>
			</table>
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
	$('#reg').validate({
		rules: {
			user_login_name: {
		        required: true,
		        minlength: 2
		    },
		    pass: {
				required: true,
				minlength: 6
			},
			repass: {
				required: true,
				minlength: 6,
				equalTo: "#pass"
			},
			user_tel: {
				required: true,
				minlength: 11,
			    digits: true
			},
			user_tel_yz: {
				required: true,
				minlength: 6,
				digits: true
			}
		}
	});

    $('input[name=phone_fake]').click(function(){
        var btn = $(this);
        if (btn.val() != '发送验证') {
            return ;
        }
        var phone = $('input[name=user_tel]').val();
        var myreg = /^13[\d]{9}$|14^[0-9]\d{8}|^15[0-9]\d{8}$|^18[0-9]\d{8}$/;
        if(!myreg.test(phone)){
           alert('请输入有效的手机号码！');return false;
        }

        $.ajax({
            url:'<?php echo U('Member/sendPhone');?>',
            data:{'phone':phone},
            dataType:'json',
            beforeSend:function(){
                 btn.val('获取中...');
            },
            success:function(d){
                if (d.state == 'success') {
                    btn.val('获取成功').prop('disabled', true);
                } else if (d.state == 'fail') {
                    btn.val('获取失败');
                }
                alert(d.info);
            }
        });
    }); 
</script> 
	<?php echo ($site_tongji); ?>
</body>
</html>