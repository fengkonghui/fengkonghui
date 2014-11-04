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

	<div class="wrap jj">
		<?php $getMenu = \Common\Controller\AdminbaseController::getMenu(); ?>
<?php if(!empty($getMenu)): ?><div class="nav">
		<ul class="cc">
			<?php if(is_array($getMenu)): $i = 0; $__LIST__ = $getMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i; $current = ($r['action']==ACTION_NAME) ? 'current' : ''; ?>
				<li class='<?php echo ($current); ?>'>
					<a href="<?php echo U($r['app'].'/'.$r['model'].'/'.$r['action']);?>"><?php echo ($r["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div><?php endif; ?>
		<div class="common-form">
			<form method="post" class="J_ajaxForm" >
				<div class="h_a">菜单信息</div>
				<input type="hidden" class="input" name="id" value="<?php echo ($id); ?>">
				<div class="table_list">
					<table cellpadding="0" cellspacing="0" class="table_form" width="100%">
						<tbody>
							<tr>
								<td>菜单分类:</td>
								<td>
									<select name="cid" id="navcid_select">
										<?php if(is_array($navcats)): foreach($navcats as $key=>$vo): $navcid_selected=$navcid==$vo['navcid']?"selected":""; ?>
											<option value="<?php echo ($vo["navcid"]); ?>" <?php echo ($navcid_selected); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
									</select>
								</td>
							</tr>
							<tr>
								<td>上级:</td>
								<td>
									<select name="parentid">
										<option value="0">/</option>
										<?php echo ($nav_trees); ?>
									</select>
								</td>
							</tr>
							<tr>
								<td>标签:</td>
								<td><input type="text" class="input" name="label" value="<?php echo ($label); ?>"><span class="must_red">*</span></td>
							</tr>
							<tr>
								<td>地址:</td>
								<td>
									<input type="radio" name="nav" id="outlink">
									<input type="text" class="input" name="href" id="outlink_input" value="http://" />

									<input type="radio" name="nav" id="selecturl">
									<select name="href" id="selecthref">
										<option disabled="disabled">默认</option>
										<option value="home">&nbsp;&nbsp;&nbsp;&nbsp;首页</option>
										<?php if(is_array($navs)): foreach($navs as $key=>$vo): ?><option disabled="disabled"><?php echo ($vo["name"]); ?></option>
											<?php if(is_array($vo['items'])): foreach($vo['items'] as $key=>$voo): ?><option value='<?php echo ($voo["rule"]); ?>'>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($voo["label"]); ?></option><?php endforeach; endif; endforeach; endif; ?>
									</select>
									<!-- 
									<textarea readonly="readonly" rows="5" cols="57" id="href_input"><?php echo ($href); ?></textarea>
									<input type="hidden" name="href" id="u_input" value='<?php echo ($hrefold); ?>' />
									-->
								</td>
							</tr>
							<tr>
								<td>打开方式:</td>
								<td>
									<select name="target">
										<option value="">默认方式</option>
										<option value="_blank">新窗口打开</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>图标:</td>
								<td><input type="text" class="input" name="icon" value="<?php echo ($icon); ?>"></td>
							</tr>
							<tr>
								<td>显示:</td>
								<td>
									<select name="status">
										<option value="1">显示</option>
										<option value="0">不显示</option>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="">
					<div class="btn_wrap_pd">
						<button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">保存</button>
					</div>
				</div>
			</form>
		</div>
	</div>

<script src="/static/js/common.js<?php echo ($js_debug); ?>"></script> 

	<script>
		$(function() {
			$("#navcid_select").change(function() {
				location.href = location.href + "&cid=" + $(this).val();
			});

			$("#selecthref").click(function() {
				checkChange(2);
			});
			$("input[name='href']").click(function() {
				checkChange(1);
			});

			var opt = $("#selecthref option[value='" + '<?php echo ($hrefold); ?>' + "']");
			if (opt.length > 0) {
				opt.attr('selected', 'selected');
				checkChange(2);
			} else {
				checkChange(1);
				$('#outlink_input').val('<?php echo ($hrefold); ?>');
			}

			function checkChange(i) {
				if (i == 1) {
					//自动输入url
					$('#outlink_input').attr('name', 'href');
					$('#selecthref').removeAttr('name');
					$('#outlink').attr({'checked': 'checked', 'name': 'nav'});
				} else {
					//选择链接url
					$('#selecthref').attr('name', 'href');
					$('#outlink_input').removeAttr('name');
					$('#selecturl').attr({'checked': 'checked', 'name': 'nav'});
				}
			}
			/*
			 Wind.use('ajaxForm','artDialog','iframeTools', function () {
			 $("#href_input").click(function(){
			 art.dialog.data('menu_url', $("#href_input").val());
			 art.dialog.open("<?php echo u('nav/select');?>", {
			 title: "选择链接地址",
			 close: function () {
			 var checked_v = art.dialog.data('checked_v');
			 var checked_u = art.dialog.data('checked_u');
			 if (checked_v !== undefined) $('#href_input').val(checked_v);
			 if (checked_u !== undefined) $('#u_input').val(checked_u);
			 }
			 },false);
			 });
			 });
			 */
		});


	</script>

</body>
</html>